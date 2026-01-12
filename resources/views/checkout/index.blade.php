@extends('layouts.client')

@section('title', 'Thanh toán - Nhóm 4 CNM')

@section('content')
<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                    <li class="active">Thanh toán</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Thông tin thanh toán -->
                <div class="col-md-7">
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">Thông tin người nhận</h3>
                        </div>
                        
                        <div class="form-group">
                            <label>Họ và tên <span style="color: #D10024;">*</span></label>
                            <input class="input" 
                                   type="text" 
                                   name="customer_name" 
                                   value="{{ old('customer_name', $user->name ?? '') }}"
                                   placeholder="Nhập họ và tên"
                                   required>
                            @error('customer_name')
                                <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Email <span style="color: #D10024;">*</span></label>
                            <input class="input" 
                                   type="email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', $user->email ?? '') }}"
                                   placeholder="email@example.com"
                                   required>
                            @error('customer_email')
                                <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Số điện thoại <span style="color: #D10024;">*</span></label>
                            <input class="input" 
                                   type="tel" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone') }}"
                                   placeholder="0123456789"
                                   required>
                            @error('customer_phone')
                                <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ <span style="color: #D10024;">*</span></label>
                            <input class="input" 
                                   type="text" 
                                   name="shipping_address" 
                                   value="{{ old('shipping_address') }}"
                                   placeholder="Số nhà, tên đường"
                                   required>
                            @error('shipping_address')
                                <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phường/Xã</label>
                            <input class="input" 
                                   type="text" 
                                   name="ward" 
                                   value="{{ old('ward') }}"
                                   placeholder="Nhập phường/xã">
                        </div>

                        <div class="form-group">
                            <label>Quận/Huyện</label>
                            <input class="input" 
                                   type="text" 
                                   name="district" 
                                   value="{{ old('district') }}"
                                   placeholder="Nhập quận/huyện">
                        </div>

                        <div class="form-group">
                            <label>Tỉnh/Thành phố <span style="color: #D10024;">*</span></label>
                            <select class="input" name="city" required>
                                <option value="">Chọn tỉnh/thành phố</option>
                                <option value="Hà Nội" {{ old('city') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                                <option value="Hồ Chí Minh" {{ old('city') == 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                                <option value="Đà Nẵng" {{ old('city') == 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                                <option value="Hải Phòng" {{ old('city') == 'Hải Phòng' ? 'selected' : '' }}>Hải Phòng</option>
                                <option value="Cần Thơ" {{ old('city') == 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                            </select>
                            @error('city')
                                <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Ghi chú đơn hàng (Tùy chọn)</label>
                            <textarea class="input" 
                                      name="note" 
                                      rows="4"
                                      placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <!-- Phương thức thanh toán -->
                    <div class="shiping-methods" style="margin-top: 30px;">
                        <div class="section-title">
                            <h3 class="title">Phương thức thanh toán</h3>
                        </div>
                        
                        <div class="input-radio">
                            <input type="radio" 
                                   name="payment_method" 
                                   id="payment-cod" 
                                   value="cod" 
                                   {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}
                                   required>
                            <label for="payment-cod">
                                <span></span>
                                Thanh toán khi nhận hàng (COD)
                            </label>
                            <div class="caption" style="padding-left: 25px; color: #999; font-size: 12px;">
                                Thanh toán bằng tiền mặt khi nhận hàng
                            </div>
                        </div>

                        <div class="input-radio">
                            <input type="radio" 
                                   name="payment_method" 
                                   id="payment-bank" 
                                   value="bank_transfer"
                                   {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                            <label for="payment-bank">
                                <span></span>
                                Chuyển khoản ngân hàng
                            </label>
                            <div class="caption" style="padding-left: 25px; color: #999; font-size: 12px;">
                                Chuyển khoản qua Internet Banking
                            </div>
                        </div>

                        <div class="input-radio">
                            <input type="radio" 
                                   name="payment_method" 
                                   id="payment-card" 
                                   value="credit_card"
                                   {{ old('payment_method') == 'credit_card' ? 'checked' : '' }}>
                            <label for="payment-card">
                                <span></span>
                                Thanh toán bằng thẻ
                            </label>
                            <div class="caption" style="padding-left: 25px; color: #999; font-size: 12px;">
                                Thanh toán qua Visa, Mastercard
                            </div>
                        </div>
                        
                        @error('payment_method')
                            <span style="color: #D10024; font-size: 12px;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Đơn hàng của bạn -->
                <div class="col-md-5">
                    <div class="order-details">
                        <div class="section-title text-center">
                            <h3 class="title">Đơn hàng của bạn</h3>
                        </div>
                        
                        <div class="order-summary">
                            <div class="order-col">
                                <div><strong>SẢN PHẨM</strong></div>
                                <div><strong>TỔNG</strong></div>
                            </div>
                            
                            <div class="order-products" style="max-height: 300px; overflow-y: auto;">
                                @foreach($cart as $item)
                                    <div class="order-col">
                                        <div>
                                            {{ $item['quantity'] }}x {{ Str::limit($item['name'], 30) }}
                                            <div style="font-size: 11px; color: #999;">
                                                @if(isset($item['ram']) && $item['ram'] != 'N/A')
                                                    {{ $item['ram'] }}
                                                @endif
                                                @if(isset($item['storage']) && $item['storage'] != 'N/A')
                                                    @if(isset($item['ram']) && $item['ram'] != 'N/A') | @endif
                                                    {{ $item['storage'] }}
                                                @endif
                                                @if(isset($item['color']) && $item['color'] != 'N/A')
                                                    @if((isset($item['ram']) && $item['ram'] != 'N/A') || (isset($item['storage']) && $item['storage'] != 'N/A')) | @endif
                                                    Màu: {{ $item['color'] }}
                                                @endif
                                            </div>
                                        </div>
                                        <div>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}₫</div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="order-col">
                                <div>Tạm tính</div>
                                <div><strong>{{ number_format($total, 0, ',', '.') }}₫</strong></div>
                            </div>
                            
                            <div class="order-col">
                                <div>Phí vận chuyển</div>
                                <div><strong>Miễn phí</strong></div>
                            </div>
                            
                            <div class="order-col">
                                <div><strong>TỔNG CỘNG</strong></div>
                                <div><strong class="order-total">{{ number_format($total, 0, ',', '.') }}₫</strong></div>
                            </div>
                        </div>
                        
                        <button type="submit" class="primary-btn order-submit" style="width: 100%;">
                            Đặt hàng
                        </button>

                        <div style="margin-top: 15px; text-align: center; font-size: 12px; color: #999;">
                            <i class="fa fa-lock"></i> Thanh toán an toàn & bảo mật
                            <br>
                            <span style="font-size: 11px; margin-top: 10px; display: block;">
                                Bằng cách đặt hàng, bạn đồng ý với 
                                <a href="#" style="color: #D10024;">Điều khoản sử dụng</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /SECTION -->

@push('styles')
<style>
.billing-details .form-group {
    margin-bottom: 20px;
}
.billing-details label {
    display: block;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 12px;
    margin-bottom: 10px;
}
.shiping-methods {
    padding: 30px;
    border: 2px solid #E4E7ED;
}
.input-radio {
    margin-bottom: 15px;
}
.input-radio input[type="radio"] {
    display: none;
}
.input-radio label {
    position: relative;
    padding-left: 25px;
    cursor: pointer;
    font-weight: 500;
}
.input-radio label span {
    position: absolute;
    left: 0;
    top: 2px;
    width: 16px;
    height: 16px;
    border: 2px solid #E4E7ED;
    border-radius: 50%;
}
.input-radio input[type="radio"]:checked + label span {
    border-color: #D10024;
}
.input-radio input[type="radio"]:checked + label span:after {
    content: '';
    position: absolute;
    left: 2px;
    top: 2px;
    width: 8px;
    height: 8px;
    background: #D10024;
    border-radius: 50%;
}
</style>
@endpush
@endsection