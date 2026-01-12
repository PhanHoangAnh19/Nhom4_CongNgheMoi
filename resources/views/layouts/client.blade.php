<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nhóm 4 CNM')</title>

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/slick-theme.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    @stack('styles')
</head>
<body>
    <!-- HEADER -->
    <header>
        <!-- TOP HEADER -->
        <div id="top-header">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#"><i class="fa fa-phone"></i> 0397788946</a></li>
                    <li><a href="#"><i class="fa fa-envelope-o"></i> Nhom4@email.com</a></li>
                    <li><a href="#"><i class="fa fa-map-marker"></i> 48 Cao Thắng</a></li>
                </ul>
                <ul class="header-links pull-right">
                    <li><a href="#"><i class="fa fa-dollar"></i> VND</a></li>
                    <li>
                        @auth
                            <a href="#">
                                <i class="fa fa-user-o"></i>
                                {{ auth()->user()->name }}
                            </a>
                        @else
                            <a href="{{ route('login') }}">
                                <i class="fa fa-user-o"></i>
                                Đăng nhập
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
        <!-- /TOP HEADER -->

        <!-- MAIN HEADER -->
        <div id="header">
            <div class="container">
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="{{ route('shop.index') }}" class="logo">
                                <img src="{{ asset('img/Nhom4.png') }}" alt="Nhóm 4 CNM">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form action="{{ route('shop.index') }}" method="GET">
                                <select class="input-select" name="category">
                                    <option value="">Tất cả danh mục</option>
                                    <option value="phone">Điện thoại</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="accessory">Phụ kiện</option>
                                </select>
                                <input class="input" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
                                <button class="search-btn" type="submit">Tìm kiếm</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Wishlist -->
                            <div>
                                <a href="#">
                                    <i class="fa fa-heart-o"></i>
                                    <span>Yêu thích</span>
                                    <div class="qty">0</div>
                                </a>
                            </div>
                            <!-- /Wishlist -->

                            <!-- Cart -->
                            <div class="dropdown">
                                <a href="{{ route('cart.index') }}" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty">{{ $cartCount ?? 0 }}</div>
                                </a>
                                <div class="cart-dropdown">
                                    @if(!empty($headerCart) && count($headerCart) > 0)
                                        <div class="cart-list">
                                            @foreach(array_slice($headerCart, 0, 3) as $id => $item)
                                                <div class="product-widget">
                                                    <div class="product-img">
                                                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                                                    </div>
                                                    <div class="product-body">
                                                        <h3 class="product-name">
                                                            <a href="#">{{ Str::limit($item['name'], 30) }}</a>
                                                        </h3>
                                                        <h4 class="product-price">
                                                            <span class="qty">{{ $item['quantity'] }}x</span>
                                                            {{ number_format($item['price'], 0, ',', '.') }}₫
                                                        </h4>
                                                    </div>
                                                    <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete" style="border: none; background: none; cursor: pointer;">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="cart-summary">
                                            <small>{{ $cartCount }} sản phẩm</small>
                                            <h5>TỔNG: {{ number_format($cartTotal ?? 0, 0, ',', '.') }}₫</h5>
                                        </div>
                                        <div class="cart-btns">
                                            <a href="{{ route('cart.index') }}">Xem giỏ hàng</a>
                                            <a href="{{ route('checkout.index') }}">
                                                Thanh toán <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    @else
                                        <div class="cart-list">
                                            <p style="padding: 20px; text-align: center; color: #999;">
                                                Giỏ hàng trống
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toggle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toggle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
            </div>
        </div>
        <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        <div class="container">
            <div id="responsive-nav">
                <ul class="main-nav nav navbar-nav">
                    <li class="{{ Request::is('shop') ? 'active' : '' }}">
                        <a href="{{ route('shop.index') }}">Trang chủ</a>
                    </li>
                    <li><a href="#">Khuyến mãi</a></li>
                    <li><a href="#">Danh mục</a></li>
                    <li><a href="#">Laptop</a></li>
                    <li><a href="#">Điện thoại</a></li>
                    <li><a href="#">Phụ kiện</a></li>
                    <li class="{{ Request::is('cart') ? 'active' : '' }}">
                        <a href="{{ route('cart.index') }}">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /NAVIGATION -->

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <!-- /FLASH MESSAGES -->

    <!-- MAIN CONTENT -->
    @yield('content')
    <!-- /MAIN CONTENT -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Đăng ký nhận <strong>TIN TỨC MỚI NHẤT</strong></p>
                        <form>
                            <input class="input" type="email" placeholder="Nhập email của bạn">
                            <button class="newsletter-btn"><i class="fa fa-envelope"></i> Đăng ký</button>
                        </form>
                        <ul class="newsletter-follow">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->
    <footer id="footer">
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Về chúng tôi</h3>
                            <p>Chuyên cung cấp các sản phẩm điện tử chính hãng với giá tốt nhất.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>48 Cao Thắng, Đà Nẵng</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>0397788946</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>Nhom4@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Danh mục</h3>
                            <ul class="footer-links">
                                <li><a href="#">Khuyến mãi</a></li>
                                <li><a href="#">Laptop</a></li>
                                <li><a href="#">Điện thoại</a></li>
                                <li><a href="#">Phụ kiện</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Thông tin</h3>
                            <ul class="footer-links">
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Liên hệ</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Đổi trả & Hoàn tiền</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Dịch vụ</h3>
                            <ul class="footer-links">
                                <li><a href="#">Tài khoản</a></li>
                                <li><a href="{{ route('cart.index') }}">Giỏ hàng</a></li>
                                <li><a href="#">Theo dõi đơn hàng</a></li>
                                <li><a href="#">Hỗ trợ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="bottom-footer" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                        </ul>
                        <span class="copyright">
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> 
                            Nhóm 4 CNM. All rights reserved.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/jquery.zoom.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>