<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShareCartData
{
    public function handle(Request $request, Closure $next)
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $cartTotal = 0;
        
        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
        
        view()->share([
            'headerCart' => $cart,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal
        ]);
        
        return $next($request);
    }
}