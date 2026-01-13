<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; 
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index() 
    {
        // Lấy danh sách đơn hàng mới nhất
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết một đơn hàng cụ thể
     */
    public function show($id)
    {
        // Phải dùng 'orderItems' (hoặc đúng tên hàm bạn đặt trong Model Order)
        // Load thêm 'product' bên trong orderItems để hiện tên/ảnh sản phẩm
        $order = Order::with('orderItems.product')->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        try {
            $order = Order::findOrFail($id);
            
            $data = ['status' => $request->status];

            // Logic thêm: Nếu đơn hàng hoàn thành, tự động cập nhật đã thanh toán (tùy chọn)
            if ($request->status === 'completed') {
                $data['payment_status'] = 'paid';
            }

            $order->update($data);

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}