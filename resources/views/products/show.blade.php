@extends('layouts.app') <!-- Hoặc tên layout frontend của bạn -->

@section('title', $product->name . ' - Nhóm 4 CNM')

@section('content')
    <div class="section">
        <div class="container">
            <!-- Breadcrumb -->
            <ul class="breadcrumb">
                <li><a href="{{ route('shop.index') ?? '/' }}">Trang chủ</a></li>
                <li><a href="#">{{ $product->brand }}</a></li>
                <li class="active">{{ $product->name }}</li>
            </ul>

            <!-- Product Detail -->
            <div class="row">
                <!-- Ảnh sản phẩm -->
                <div class="col-md-6">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-responsive">
                    <!-- Nếu có nhiều ảnh sau này thì thêm carousel -->
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-md-6">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <h4 class="product-price">
                        Giá: <strong>{{ number_format($product->price, 0, ',', '.') }} ₫</strong>
                    </h4>

                    <p><strong>Hãng:</strong> {{ $product->brand }}</p>
                    <p><strong>Tồn kho:</strong> {{ $product->quantity }} sản phẩm</p>

                    <!-- Mô tả (nếu có cột description thì thêm) -->
                    @if($product->description)
                        <div class="product-description">
                            {!! $product->description !!}
                        </div>
                    @endif

                    <!-- Nút thêm vào giỏ hàng -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-to-cart {{ $product->quantity <= 0 ? 'disabled' : '' }}" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            <i class="fa fa-shopping-cart"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sản phẩm liên quan -->
            @if($relatedProducts->count() > 0)
                <div class="section-title">
                    <h3 class="title">Sản phẩm cùng hãng</h3>
                </div>
                <div class="row">
                    @foreach($relatedProducts as $related)
                        <div class="col-md-3">
                            <div class="product">
                                <img src="{{ asset($related->image) }}" alt="{{ $related->name }}">
                                <h4><a href="{{ route('product.show', $related->slug) }}">{{ $related->name }}</a></h4>
                                <p class="price">{{ number_format($related->price, 0, ',', '.') }} ₫</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection