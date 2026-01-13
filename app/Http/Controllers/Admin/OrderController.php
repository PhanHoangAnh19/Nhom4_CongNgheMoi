<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Dùng để quản lý giao dịch database

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng (Phân trang 10 dòng/trang)
     */
    public function index() 
    {
        // Sử dụng Eager Loading để tránh lỗi N+1 (tối ưu tốc độ tải trang)
        $orders = Order::latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị chi tiết một đơn hàng cụ thể
     */
    public function show($id)
    {
        // Eager loading 'items' để lấy danh sách sản phẩm cùng lúc với đơn hàng
        $order = Order::with('items')->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng (Sửa lỗi Route not defined)
     */
    public function updateStatus(Request $request, $id)
    {
        // Kiểm tra dữ liệu đầu vào (Validation) để đảm bảo an toàn dữ liệu
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled' // Chỉ chấp nhận các giá trị này
        ]);

        try {
            $order = Order::findOrFail($id);
            
            // Sử dụng update() để ghi đè trạng thái mới từ form
            $order->update([
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công!');
        } catch (\Exception $e) {
            // Nếu có lỗi (VD: DB lỗi), quay lại và thông báo
            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }
}