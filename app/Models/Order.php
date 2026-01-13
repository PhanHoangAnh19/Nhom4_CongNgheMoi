<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'total_amount',
        'status',
        'user_id',
        'shipping_address',
        'payment_method',
        'payment_status',
        // BỔ SUNG CÁC TRƯỜNG DƯỚI ĐÂY:
        'city',
        'district',
        'ward',
        'note'
    ];

    // Đã khớp với Order::with('orderItems') trong CheckoutController dòng 156
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Đã giải quyết lỗi Call to undefined method generateOrderNumber()
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
    }
}