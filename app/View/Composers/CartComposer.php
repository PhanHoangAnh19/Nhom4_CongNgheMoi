<?php

namespace App\View\Composers;

use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        // Lấy giỏ hàng từ session
        $cart = session()->get('cart', []);
        
        // Tính tổng số lượng và tổng tiền
        $cartCount = 0;
        $cartTotal = 0;
        
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
            $cartTotal += $item['price'] * $item['quantity'];
        }
        
        // Chia sẻ biến với view
        $view->with([
            'cart' => $cart,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal
        ]);
    }
}