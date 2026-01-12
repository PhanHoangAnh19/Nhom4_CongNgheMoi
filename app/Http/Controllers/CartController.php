<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hiển thị trang giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // Thêm sản phẩm vào giỏ hàng - Sử dụng Route Model Binding
    public function add(Request $request, Product $product)
    {
        // Kiểm tra số lượng tồn kho
        if (!$product->quantity || $product->quantity < 1) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng!');
        }

        $cart = session()->get('cart', []);
        $requestQuantity = $request->input('quantity', 1);

        // Nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $requestQuantity;

            // Kiểm tra số lượng tồn kho
            if ($newQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Số lượng vượt quá hàng tồn kho! (Còn ' . $product->quantity . ' sản phẩm)');
            }

            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            // Kiểm tra số lượng yêu cầu
            if ($requestQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Số lượng vượt quá hàng tồn kho! (Còn ' . $product->quantity . ' sản phẩm)');
            }

            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand ?? 'N/A',
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => $requestQuantity,
                'color' => $product->color ?? 'N/A',
                'ram' => $product->ram ?? 'N/A',
                'storage' => $product->storage ?? 'N/A',
                'description' => $product->description ?? '',
                'stock' => $product->quantity,
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);

        // Redirect sang trang giỏ hàng kèm thông báo thành công
        return redirect()->route('cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    // Cập nhật số lượng sản phẩm
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (isset($cart[$productId])) {
            // Kiểm tra số lượng tồn kho
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại!'
                ]);
            }

            if ($quantity > $product->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá hàng tồn kho! (Còn ' . $product->quantity . ' sản phẩm)'
                ]);
            }

            if ($quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng phải lớn hơn 0!'
                ]);
            }

            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);

            // Tính lại tổng tiền
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'subtotal' => number_format($cart[$productId]['price'] * $quantity, 0, ',', '.'),
                'total' => number_format($total, 0, ',', '.')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không có trong giỏ hàng!'
        ]);
    }

    // Xóa sản phẩm khỏi giỏ hàng - Sử dụng Route Model Binding
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}