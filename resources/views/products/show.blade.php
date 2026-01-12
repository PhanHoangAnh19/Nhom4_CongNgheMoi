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
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-responsive img-fluid rounded shadow">
                    <!-- Nếu có nhiều ảnh sau này thì thêm carousel -->
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="col-md-6">
                    <h2 class="product-name fw-bold">{{ $product->name }}</h2>
                    <h4 class="product-price mb-4">
                        Giá: <strong class="text-danger">{{ number_format($product->price, 0, ',', '.') }} ₫</strong>
                    </h4>

                    <p><strong>Hãng:</strong> {{ $product->brand }}</p>
                    <p><strong>Tồn kho:</strong> 
                        @if($product->quantity > 0)
                            <span class="text-success">{{ $product->quantity }} sản phẩm</span>
                        @else
                            <span class="text-danger">Hết hàng</span>
                        @endif
                    </p>

                    <!-- Mô tả -->
                    @if($product->description)
                        <div class="product-description mt-4">
                            {!! $product->description !!}
                        </div>
                    @endif

                    <!-- Nút thêm vào giỏ hàng (trang chi tiết) -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-5">
                        @csrf
                        <div class="input-group mb-4 w-50">
                            <span class="input-group-text">Số lượng</span>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->quantity }}" class="form-control text-center" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg {{ $product->quantity <= 0 ? 'disabled' : '' }}" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            <i class="fa fa-shopping-cart me-2"></i> THÊM VÀO GIỎ HÀNG
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sản phẩm liên quan -->
            @if($relatedProducts->count() > 0)
                <div class="section-title mt-5">
                    <h3 class="title">Sản phẩm cùng hãng</h3>
                </div>
                <div class="row">
                    @foreach($relatedProducts as $related)
                        <div class="col-md-3 mb-4">
                            <div class="product text-center">
                                <img src="{{ asset($related->image) }}" alt="{{ $related->name }}" class="img-fluid rounded mb-2">
                                <h4><a href="{{ route('product.show', $related->slug) }}">{{ $related->name }}</a></h4>
                                <p class="price text-danger fw-bold">{{ number_format($related->price, 0, ',', '.') }} ₫</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection