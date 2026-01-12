<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // Thêm dòng này để xử lý xóa file ảnh

class ProductController extends Controller
{
    /**
     * TRANG ADMIN: Danh sách quản lý
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'brand' => 'required', 
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên điện thoại',
            'brand.required' => 'Vui lòng chọn hãng sản xuất',
            'price.numeric' => 'Giá bán phải là con số',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/products'), $fileName);
            $data['image'] = 'uploads/products/' . $fileName;
        }

        Product::create($data);
        
        return redirect()->route('admin.products.index')->with('success', 'Đã thêm điện thoại mới thành công!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'brand' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // 1. Xóa ảnh cũ nếu có để tránh rác server
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            // 2. Lưu ảnh mới
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $fileName);
            $data['image'] = 'uploads/products/' . $fileName;
        }

        $product->update($data);

        // SỬA LỖI: redirect về admin.products.index
        return redirect()->route('admin.products.index')->with('success', 'Đã cập nhật thông tin máy!');
    }

    public function destroy(Product $product)
    {
        // Xóa file ảnh vật lý trước khi xóa dữ liệu trong DB
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        // SỬA LỖI: redirect về admin.products.index
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }

    /**
     * TRANG THỐNG KÊ
     */
    public function thongKe() 
    {
        $dataQuantity = Product::select('brand', DB::raw('count(*) as total'))
                        ->groupBy('brand')
                        ->get();

        $dataRevenue = Product::select('brand', DB::raw('SUM(price * quantity) as total_revenue'))
                        ->groupBy('brand')
                        ->get();

        $totalAllRevenue = Product::sum(DB::raw('price * quantity'));

        return view('products.thongke', [
            'labels' => $dataQuantity->pluck('brand')->toArray(),
            'values' => $dataQuantity->pluck('total')->toArray(),
            'revLabels' => $dataRevenue->pluck('brand')->toArray(),
            'revValues' => $dataRevenue->pluck('total_revenue')->toArray(),
            'totalAllRevenue' => $totalAllRevenue,
        ]);
    }
}