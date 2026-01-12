@extends('layouts.client')

@section('title', 'Giỏ hàng - Nhóm 4 CNM')

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        @if(empty($cart))
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center" style="padding: 80px 0;">
                        <i class="fa fa-shopping-cart" style="font-size: 100px; color: #ddd; margin-bottom: 20px;"></i>
                        <h3 style="color: #666; margin-bottom: 10px;">Giỏ hàng trống</h3>
                        <p style="color: #999; margin-bottom: 30px;">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                        <a href="{{ url('/') }}" class="primary-btn" style="display: inline-block; padding: 12px 40px;">
                            <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <!-- Danh sách sản phẩm -->
                <div class="col-md-8">
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>SẢN PHẨM ({{ count($cart) }})</strong></div>
                        </div>
                    </div>

                    @foreach($cart as $id => $item)
                        <div class="product-widget" style="border-bottom: 1px solid #E4E7ED; padding: 20px 0; display: flex; align-items: center;">
                            <div class="product-img" style="flex: 0 0 100px;">
                                <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" style="width: 100px; height: 100px; object-fit: cover;">
                            </div>
                            
                            <div class="product-body" style="flex: 1; padding-left: 20px;">
                                <h3 class="product-name">
                                    <a href="#">{{ $item['name'] }}</a>
                                </h3>
                                <p style="font-size: 12px; color: #999; margin: 5px 0;">
                                    @if(isset($item['brand']) && $item['brand'] != 'N/A')
                                        <span><strong>Hãng:</strong> {{ $item['brand'] }}</span>
                                    @endif
                                    @if(isset($item['ram']) && $item['ram'] != 'N/A')
                                        <span> | <strong>RAM:</strong> {{ $item['ram'] }}</span>
                                    @endif
                                    @if(isset($item['storage']) && $item['storage'] != 'N/A')
                                        <span> | <strong>Bộ nhớ:</strong> {{ $item['storage'] }}</span>
                                    @endif
                                    @if(isset($item['color']) && $item['color'] != 'N/A')
                                        <br><span><strong>Màu:</strong> {{ $item['color'] }}</span>
                                    @endif
                                </p>
                                <h4 class="product-price" style="color: #D10024; font-weight: 700; margin-top: 10px;">
                                    {{ number_format($item['price'], 0, ',', '.') }}₫
                                    @if(isset($item['stock']))
                                        <span style="font-size: 11px; color: #4CAF50; display: block; margin-top: 5px;">
                                            <i class="fa fa-check-circle"></i> Còn {{ $item['stock'] }} sản phẩm
                                        </span>
                                    @endif
                                </h4>
                            </div>

                            <div style="flex: 0 0 150px; text-align: center;">
                                <div class="input-number" style="display: inline-block;">
                                    <input type="number" 
                                           value="{{ $item['quantity'] }}" 
                                           min="1" 
                                           class="quantity-input"
                                           data-id="{{ $id }}"
                                           data-price="{{ $item['price'] }}"
                                           style="width: 80px; padding: 5px; text-align: center; border: 1px solid #E4E7ED;">
                                    <span class="qty-up" style="cursor: pointer; margin-left: 5px;">
                                        <i class="fa fa-angle-up"></i>
                                    </span>
                                    <span class="qty-down" style="cursor: pointer;">
                                        <i class="fa fa-angle-down"></i>
                                    </span>
                                </div>
                            </div>

                            <div style="flex: 0 0 120px; text-align: right;">
                                <h4 class="subtotal" data-id="{{ $id }}" style="color: #2B2D42; font-weight: 700; margin-bottom: 10px;">
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫
                                </h4>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete" style="border: none; background: none; cursor: pointer; color: #D10024;">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ url('/') }}" style="color: #2B2D42;">
                            <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="primary-btn" style="background: #999;" 
                                    onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                <i class="fa fa-trash"></i> Xóa toàn bộ
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Tổng đơn hàng -->
                <div class="col-md-4">
                    <div class="order-summary" style="border: 2px solid #E4E7ED; padding: 30px;">
                        <div class="order-col">
                            <div><strong>TỔNG ĐON HÀNG</strong></div>
                        </div>
                        
                        <div class="order-col" style="padding: 20px 0; border-bottom: 1px solid #E4E7ED;">
                            <div>Tạm tính:</div>
                            <div><strong id="cart-total">{{ number_format($total, 0, ',', '.') }}₫</strong></div>
                        </div>
                        
                        <div class="order-col" style="padding: 20px 0; border-bottom: 1px solid #E4E7ED;">
                            <div>Phí vận chuyển:</div>
                            <div><strong>Miễn phí</strong></div>
                        </div>
                        
                        <div class="order-col" style="padding: 20px 0;">
                            <div><strong>TỔNG CỘNG:</strong></div>
                            <div>
                                <strong class="order-total" id="final-total" style="color: #D10024; font-size: 24px;">
                                    {{ number_format($total, 0, ',', '.') }}₫
                                </strong>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="primary-btn order-submit" style="width: 100%; text-align: center; padding: 15px;">
                            Thanh toán <i class="fa fa-arrow-circle-right"></i>
                        </a>

                        <div style="margin-top: 15px; text-align: center; font-size: 12px; color: #999;">
                            <i class="fa fa-lock"></i> Thanh toán an toàn & bảo mật
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- /SECTION -->

@push('scripts')
<script>
$(document).ready(function() {
    // Xử lý thay đổi số lượng
    $('.quantity-input').on('change', function() {
        updateCart($(this));
    });

    // Tăng số lượng
    $('.qty-up').on('click', function() {
        var input = $(this).siblings('.quantity-input');
        var currentVal = parseInt(input.val());
        input.val(currentVal + 1);
        updateCart(input);
    });

    // Giảm số lượng
    $('.qty-down').on('click', function() {
        var input = $(this).siblings('.quantity-input');
        var currentVal = parseInt(input.val());
        if (currentVal > 1) {
            input.val(currentVal - 1);
            updateCart(input);
        }
    });

    function updateCart(input) {
        var productId = input.data('id');
        var quantity = input.val();
        var price = input.data('price');

        $.ajax({
            url: '{{ route("cart.update") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    // Cập nhật subtotal
                    $('.subtotal[data-id="' + productId + '"]').text(response.subtotal + '₫');
                    // Cập nhật total
                    $('#cart-total').text(response.total + '₫');
                    $('#final-total').text(response.total + '₫');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.product-widget {
    transition: background-color 0.3s;
}
.product-widget:hover {
    background-color: #f9f9f9;
}
.quantity-input {
    border-radius: 4px;
}
.qty-up, .qty-down {
    display: inline-block;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    background: #E4E7ED;
    border-radius: 3px;
}
.qty-up:hover, .qty-down:hover {
    background: #D10024;
    color: white;
}
</style>
@endpush
@endsection