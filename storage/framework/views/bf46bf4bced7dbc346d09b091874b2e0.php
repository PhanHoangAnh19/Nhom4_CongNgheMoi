<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Nhóm 4 CNM'); ?></title>

    <!-- Font Montserrat -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Các CSS cũ của template -->
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/slick.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/slick-theme.css')); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/nouislider.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome.min.css')); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>" />

    <!-- CSS fix layout bể -->
    <style>
        .header-search {
        display: flex;
        align-items: center;
    }

    .header-search form {
        display: flex;
        align-items: center;
        width: 100%;
        gap: 0; /* Xóa khoảng cách thừa */
    }

    .header-search .input-select {
        width: 220px !important; /* Rộng hơn để chữ "Tất cả danh mục" không bị che */
        height: 46px !important;
        padding: 0 10px !important;
        border: 1px solid #ddd !important;
        border-right: none !important;
        border-radius: 40px 0 0 40px !important;
        font-size: 14px !important;
        background: #fff !important;
        color: #333 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .header-search .input {
        flex: 1 !important;
        height: 46px !important;
        border: 1px solid #ddd !important;
        border-left: none !important;
        border-right: none !important;
        padding: 0 15px !important;
        font-size: 14px !important;
        border-radius: 0 !important;
    }

    .header-search .search-btn {
        height: 46px !important;
        width: 120px !important;
        background: #D10024 !important;
        color: white !important;
        border: none !important;
        font-weight: bold !important;
        border-radius: 0 40px 40px 0 !important;
        padding: 0 20px !important;
        transition: background 0.3s !important;
    }

    .header-search .search-btn:hover {
        background: #b8001f !important;
    }

    /* Fix trên mobile: cuộn ngang nếu cần */
    @media (max-width: 991px) {
        .header-search form {
            flex-wrap: nowrap !important;
        }
        .header-search .input-select {
            width: 160px !important; /* Giảm nhẹ trên mobile */
        }
    }
        /* Fix top-header trôi xuống, giữ trên line xám */
        #top-header {
            background: #15161D;
            color: #fff;
            padding: 10px 0;
        }
        #top-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #top-header .header-links {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        #top-header .header-links li {
            display: inline-block;
            margin-right: 20px;
        }
        #top-header .header-links.pull-right {
            margin-left: auto;
        }
        #navigation {
        background: #ffffff !important; /* Màu nền trắng */
        border-bottom: 1px solid #e0e0e0 !important; /* Đường viền dưới nhẹ */
        padding: 0 !important;
    }

    #responsive-nav {
        overflow: hidden;
    }

    #navigation .main-nav.nav.navbar-nav {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        justify-content: center !important; /* Chữ nằm giữa */
        align-items: center !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
        white-space: nowrap !important;
    }

    #navigation .main-nav li {
        margin: 0 15px !important; /* Khoảng cách đều giữa các item */
        padding: 0 !important;
        white-space: nowrap !important;
    }

    #navigation .main-nav li a {
        color: #333 !important; /* Chữ đen */
        padding: 15px 10px !important;
        font-size: 15px !important;
        text-decoration: none !important;
        display: block !important;
        transition: 0.3s !important;
        white-space: nowrap !important;
        position: relative !important;
    }

    #navigation .main-nav li a:hover,
    #navigation .main-nav li.active a {
        color: #D10024 !important; /* Màu đỏ khi hover/active */
    }

    #navigation .main-nav li.active a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 70%;
        height: 3px;
        background: #D10024 !important;
        border-radius: 3px 3px 0 0;
    }

    /* Responsive: mobile cuộn ngang nếu cần */
    @media (max-width: 991px) {
        #responsive-nav {
            overflow-x: auto !important;
            white-space: nowrap !important;
            padding: 10px 0 !important;
        }
        #navigation .main-nav {
            justify-content: flex-start !important; /* Trên mobile bắt đầu từ trái để cuộn */
        }
    }

    /* Không cho chữ xuống dòng */
    #navigation .main-nav li a {
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 140px !important; /* Giới hạn chiều rộng chữ nếu quá dài */
    }
        /* Fix tìm kiếm xuống dòng */
        .header-search form {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .header-search .input-select,
        .header-search .input,
        .header-search .search-btn {
            height: 40px;
            border-radius: 0;
        }
        .header-search .input-select {
            width: 180px;
        }
        .header-search .input {
            flex: 1;
        }
        .header-search .search-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0 20px;
        }

        /* Fix banner và Collection về hàng ngang */
        .shop-banner {
            margin-bottom: 0;
        }
        .section .row {
            margin: 0 -15px;
        }
        .section .col-md-4,
        .section .col-xs-6 {
            padding: 0 15px;
        }
        @media (max-width: 767px) {
            .section .col-xs-6 {
                width: 50%;
                float: left;
            }
        }

        /* Fix modal đẹp hơn */
        #productModal .modal-content {
            border-radius: 15px;
        }
        #productModal img {
            max-height: 400px;
            object-fit: contain;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
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
                        <?php if(auth()->guard()->check()): ?>
                            <a href="#">
                                <i class="fa fa-user-o"></i>
                                <?php echo e(auth()->user()->name); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>">
                                <i class="fa fa-user-o"></i>
                                Đăng nhập
                            </a>
                        <?php endif; ?>
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
                            <a href="<?php echo e(route('shop.index')); ?>" class="logo">
                                <img src="<?php echo e(asset('img/Nhom4.png')); ?>" alt="Nhóm 4 CNM">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form action="<?php echo e(route('shop.index')); ?>" method="GET">
                                <select class="input-select" name="category">
                                    <option value="">Tất cả danh mục</option>
                                    <option value="phone">Điện thoại</option>
                                    <option value="laptop">Laptop</option>
                                    <option value="accessory">Phụ kiện</option>
                                </select>
                                <input class="input" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo e(request('search')); ?>">
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
                                <a href="<?php echo e(route('cart.index')); ?>" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Giỏ hàng</span>
                                    <div class="qty"><?php echo e($cartCount ?? 0); ?></div>
                                </a>
                                <div class="cart-dropdown">
                                    <?php if(!empty($headerCart) && count($headerCart) > 0): ?>
                                        <div class="cart-list">
                                            <?php $__currentLoopData = array_slice($headerCart, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="product-widget">
                                                    <div class="product-img">
                                                        <img src="<?php echo e(asset($item['image'])); ?>" alt="<?php echo e($item['name']); ?>">
                                                    </div>
                                                    <div class="product-body">
                                                        <h3 class="product-name">
                                                            <a href="#"><?php echo e(Str::limit($item['name'], 30)); ?></a>
                                                        </h3>
                                                        <h4 class="product-price">
                                                            <span class="qty"><?php echo e($item['quantity']); ?>x</span>
                                                            <?php echo e(number_format($item['price'], 0, ',', '.')); ?>₫
                                                        </h4>
                                                    </div>
                                                    <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST" style="display: inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="delete" style="border: none; background: none; cursor: pointer;">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="cart-summary">
                                            <small><?php echo e($cartCount); ?> sản phẩm</small>
                                            <h5>TỔNG: <?php echo e(number_format($cartTotal ?? 0, 0, ',', '.')); ?>₫</h5>
                                        </div>
                                        <div class="cart-btns">
                                            <a href="<?php echo e(route('cart.index')); ?>">Xem giỏ hàng</a>
                                            <a href="<?php echo e(route('checkout.index')); ?>">
                                                Thanh toán <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="cart-list">
                                            <p style="padding: 20px; text-align: center; color: #999;">
                                                Giỏ hàng trống
                                            </p>
                                        </div>
                                    <?php endif; ?>
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
                    <li class="<?php echo e(Request::is('shop') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('shop.index')); ?>">Trang chủ</a>
                    </li>
                    <li><a href="#">Khuyến mãi</a></li>
                    <li><a href="#">Danh mục</a></li>
                    <li><a href="#">Laptop</a></li>
                    <li><a href="#">Điện thoại</a></li>
                    <li><a href="#">Phụ kiện</a></li>
                    <li class="<?php echo e(Request::is('cart') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('cart.index')); ?>">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /NAVIGATION -->

    <!-- FLASH MESSAGES -->
    <?php if(session('success')): ?>
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <ul style="margin: 0; padding-left: 20px;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    <!-- /FLASH MESSAGES -->

    <!-- MAIN CONTENT -->
    <?php echo $__env->yieldContent('content'); ?>
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
                                <li><a href="<?php echo e(route('cart.index')); ?>">Giỏ hàng</a></li>
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
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>

    <!-- Bootstrap 5 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="<?php echo e(asset('js/slick.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/nouislider.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.zoom.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
    
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>

    <!-- Modal Chi tiết sản phẩm -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Chi tiết sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modalProductImage" src="" alt="Sản phẩm" class="img-fluid rounded shadow">
                        </div>
                        <div class="col-md-6">
                            <h4 id="modalProductName" class="fw-bold mb-3"></h4>
                            <p><strong>Hãng:</strong> <span id="modalProductBrand"></span></p>
                            <p><strong>Giá:</strong> <span id="modalProductPrice" class="text-danger fs-4 fw-bold"></span></p>
                            <p><strong>Tồn kho:</strong> <span id="modalProductStock"></span></p>
                            <p id="modalProductDescription" class="text-muted mt-3"></p>

                            <div class="mt-4">
                                <button id="modalAddToCart" class="btn btn-primary btn-block mb-2" data-product-id="">
                                    <i class="fa fa-shopping-cart"></i> Thêm vào giỏ
                                </button>
                                <button class="btn btn-success btn-block">Mua ngay</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript để điền dữ liệu và xử lý thêm giỏ hàng -->
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const productModal = document.getElementById('productModal');
    const modalAddForm = document.getElementById('modalAddForm');
    let currentProductId = null;

    // Khi modal mở
    productModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        // Điền dữ liệu
        document.getElementById('modalProductName').textContent = trigger.getAttribute('data-name') || 'Không có tên';
        document.getElementById('modalProductBrand').textContent = trigger.getAttribute('data-brand') || 'N/A';
        document.getElementById('modalProductPrice').textContent = trigger.getAttribute('data-price') || 'N/A';
        document.getElementById('modalProductStock').textContent = trigger.getAttribute('data-stock') || 'N/A';
        document.getElementById('modalProductImage').src = trigger.getAttribute('data-image') || '<?php echo e(asset('img/no-image.png')); ?>';
        document.getElementById('modalProductDescription').textContent = trigger.getAttribute('data-description') || 'Chưa có mô tả chi tiết';

        // Lấy ID sản phẩm
        currentProductId = trigger.getAttribute('data-id');

        // Cập nhật action form đúng (dùng placeholder :id)
        if (currentProductId && modalAddForm) {
            const baseUrl = "<?php echo e(route('cart.add', ['product' => ':id'])); ?>";
            modalAddForm.action = baseUrl.replace(':id', currentProductId);
        } else {
            console.error('Không tìm thấy ID sản phẩm!');
        }
    });

    // Submit form bình thường (Laravel sẽ redirect)
    if (modalAddForm) {
        modalAddForm.addEventListener('submit', function (e) {
            if (!currentProductId) {
                e.preventDefault();
                alert('Không tìm thấy ID sản phẩm!');
            }
            // Không cần preventDefault vì muốn submit POST thật
        });
    }
});
</script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/layouts/client.blade.php ENDPATH**/ ?>