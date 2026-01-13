<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    use HasFactory;

    // Bổ sung 'product_image' để khớp với CheckoutController dòng 114
    protected $fillable = [
        'order_id', 
        'product_id', 
        'product_name', 
        'product_image', // Thêm trường này
        'price', 
        'quantity', 
        'subtotal'
    ];

    /**
     * Quan hệ ngược lại với Order
     */
    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Quan hệ với Product (để lấy thông tin sản phẩm hiện tại nếu cần)
     */
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
}