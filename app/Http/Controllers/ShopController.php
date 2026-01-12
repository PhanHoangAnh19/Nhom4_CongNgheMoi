<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function category($slug)
    {
        // Tìm danh mục theo slug (giả sử bạn có model Category)
        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy sản phẩm thuộc danh mục
        $products = Product::where('category_id', $category->id)->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }
}
