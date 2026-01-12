<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        // Kiểm tra số lượng tồn kho trước khi thanh toán
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if (!$product) {
                // Xóa sản phẩm không tồn tại khỏi giỏ hàng
                unset($cart[$id]);
                session()->put('cart', $cart);
                continue;
            }

            if ($product->quantity < $item['quantity']) {
                return redirect()->route('cart.index')->with(
                    'error',
                    'Sản phẩm "' . $item['name'] . '" chỉ còn ' . $product->quantity . ' trong kho. Vui lòng cập nhật số lượng!'
                );
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $user = Auth::user();

        return view('checkout.index', compact('cart', 'total', 'user'));
    }

    // Xử lý đặt hàng
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|string|in:cod,bank_transfer,credit_card',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên',
            'customer_email.required' => 'Vui lòng nhập email',
            'customer_email.email' => 'Email không đúng định dạng',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'city.required' => 'Vui lòng chọn tỉnh/thành phố',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        DB::beginTransaction();

        try {
            // Kiểm tra lại số lượng tồn kho và tính tổng tiền
            $totalAmount = 0;
            foreach ($cart as $id => $item) {
                $product = Product::lockForUpdate()->find($id);

                if (!$product) {
                    throw new \Exception('Sản phẩm "' . $item['name'] . '" không tồn tại!');
                }

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception('Sản phẩm "' . $item['name'] . '" chỉ còn ' . $product->quantity . ' trong kho!');
                }

                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Tạo đơn hàng - user_id có thể null nếu chưa đăng nhập
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
                'district' => $request->district,
                'ward' => $request->ward,
                'note' => $request->note,
            ]);

            // Tạo order items và cập nhật số lượng sản phẩm
            foreach ($cart as $id => $item) {
                $product = Product::find($id);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                // Giảm số lượng sản phẩm trong kho
                $product->quantity -= $item['quantity'];
                $product->save();
            }

            DB::commit();

            // Xóa giỏ hàng
            session()->forget('cart');

            // Lưu order_id vào session để kiểm tra quyền truy cập
            session()->put('last_order_id', $order->id);

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Trang đặt hàng thành công
    public function success($orderId)
    {
        // Tìm order
        $order = Order::with('orderItems')->find($orderId);

        if (!$order) {
            abort(404, 'Đơn hàng không tồn tại');
        }

        // Kiểm tra quyền truy cập
        $canAccess = false;

        // Trường hợp 1: Đã đăng nhập và là đơn của mình
        if (Auth::check() && $order->user_id == Auth::id()) {
            $canAccess = true;
        }

        // Trường hợp 2: Vừa mới đặt hàng (có trong session)
        if (session()->get('last_order_id') == $order->id) {
            $canAccess = true;
        }

        if (!$canAccess) {
            abort(403, 'Bạn không có quyền xem đơn hàng này');
        }

        return view('checkout.success', compact('order'));
    }

    // Hàm dành cho Admin xem toàn bộ đơn hàng
    public function adminOrders()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Hàm hiển thị chi tiết đơn hàng
    public function adminOrderDetail($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function history()
    {
        // Chỉ lấy đơn hàng của người đang đăng nhập
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.order_history', compact('orders'));
    }
}