@extends('layouts.client')

@section('content')
    <!-- SECTION -->
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Banner collections -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('img/shop01.png') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Laptop<br>Collection</h3>
                            <a href="#" class="cta-btn">Mua ngay <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('img/shop03.png') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Phụ kiện<br>Collection</h3>
                            <a href="#" class="cta-btn">Mua ngay <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="{{ asset('img/shop02.png') }}" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Camera<br>Collection</h3>
                            <a href="#" class="cta-btn">Mua ngay <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /SECTION -->

    <!-- PRODUCTS SECTION -->
    <div class="section" style="background-color: #f9f9f9; padding: 60px 0;">
        <div class="container">
            @foreach($categories as $categoryName => $productList)
                @if($productList->count() > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="category-header">
                                <h3 class="title">{{ $categoryName }}</h3>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row display-flex-wrap">
                                @foreach($productList as $item)
                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-30 d-flex">
                                        <div class="product-card">
                                            <div class="product-img-container">
                                                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                                                <div class="product-label">
                                                    @if($item->quantity > 0)
                                                        <span class="new-label">MỚI</span>
                                                    @else
                                                        <span class="new-label" style="background: #999;">HẾT HÀNG</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="product-content">
                                                <p class="product-brand">{{ $item->brand }}</p>
                                                <h3 class="product-title">
                                                    <a href="#">{{ $item->name }}</a>
                                                </h3>
                                                <h4 class="product-price">
                                                    {{ number_format($item->price, 0, ',', '.') }}₫
                                                </h4>
                                                
                                                <!-- Hiển thị số lượng còn -->
                                                @if($item->quantity > 0)
                                                    <p style="font-size: 11px; color: #4CAF50; margin-top: 5px;">
                                                        <i class="fa fa-check-circle"></i> Còn {{ $item->quantity }} sản phẩm
                                                    </p>
                                                @else
                                                    <p style="font-size: 11px; color: #f44336; margin-top: 5px;">
                                                        <i class="fa fa-times-circle"></i> Tạm hết hàng
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="product-action">
                                                @if($item->quantity > 0)
                                                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="add-to-cart-btn">
                                                            <i class="fa fa-shopping-cart"></i> THÊM VÀO GIỎ
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="add-to-cart-btn" disabled style="background: #999; cursor: not-allowed;">
                                                        <i class="fa fa-ban"></i> HẾT HÀNG
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="category-spacer"></div>
                @endif
            @endforeach
        </div>
    </div>
@endsection