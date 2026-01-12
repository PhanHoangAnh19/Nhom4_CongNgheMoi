<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddToCartButton extends Component
{
    public $productId;
    public $quantity;

    public function __construct($productId, $quantity = 1)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function render()
    {
        return view('components.add-to-cart-button');
    }
}