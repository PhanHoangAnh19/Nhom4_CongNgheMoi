<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-color: #D10024;
        --bg-light: #fbfbfc;
        --card-shadow: 0 10px 25px rgba(0,0,0,0.06);
    }
 
    /* Tối ưu Banner */
    .shop-banner {
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 30px;
        transition: 0.3s;
    }
    .shop-banner:hover { transform: translateY(-5px); }
 
    /* Card sản phẩm chuyên nghiệp */
    .product-item {
        background: #fff;
        border: 1px solid #f1f1f1;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.4s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .product-item:hover {
        box-shadow: var(--card-shadow);
        border-color: transparent;
        transform: translateY(-8px);
    }
 
    /* Khung ảnh cố định để không bị lệch hàng */
    .product-img-box {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        overflow: hidden;
    }
    .product-img-box img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain; /* Giữ nguyên tỉ lệ ảnh */
    }
 
    /* Nhãn MỚI/HẾT HÀNG */
    .product-label {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }
    .label-new {
        background: var(--primary-color);
        color: white;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 50px;
    }
 
    /* Header danh mục */
    .category-title-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }
    .category-title-box h3 {
        margin: 0;
        font-weight: 800;
        text-transform: uppercase;
        position: relative;
    }
    .category-title-box h3::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 60px;
        height: 2px;
        background: var(--primary-color);
    }
 
    /* Nút thêm giỏ hàng */
    .btn-add-to-cart {
        background: #15161D;
        color: white;
        border: none;
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        font-weight: 700;
        transition: 0.3s;
        margin-top: auto;
    }
    .btn-add-to-cart:hover {
        background: var(--primary-color);
    }
</style>
 
<div class="section">
    <div class="container">
        <div class="row">
            <?php
                $banners = [
                    ['title' => 'Laptop', 'img' => 'shop01.png'],
                    ['title' => 'Phụ kiện', 'img' => 'shop03.png'],
                    ['title' => 'Camera', 'img' => 'shop02.png']
                ];
            ?>
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 col-xs-6">
                <div class="shop shop-banner">
                    <div class="shop-img">
                        <img src="<?php echo e(asset('img/' . $bn['img'])); ?>" alt="">
                    </div>
                    <div class="shop-body">
                        <h3><?php echo e($bn['title']); ?><br>Collection</h3>
                        <a href="#" class="cta-btn">Mua ngay <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
 
<div class="section" style="background: #fbfbfc; padding: 60px 0;">
    <div class="container">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $productList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($productList->count() > 0): ?>
                <div class="mb-50">
                    <div class="category-title-box">
                        <h3 class="title"><?php echo e($categoryName); ?></h3>
                        <!-- SỬA: Link "Xem tất cả" - giả sử bạn có route lọc theo category -->
                        <a href="<?php echo e(route('shop.category', Str::slug($categoryName))); ?>" class="text-danger fw-bold">
                            Xem tất cả <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <div class="row">
                        <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-sm-6 col-xs-6 mb-30">
                            <div class="product-item">
                                <div class="product-label">
                                    <span class="label-new"><?php echo e($item->quantity > 0 ? 'MỚI' : 'HẾT HÀNG'); ?></span>
                                </div>
                               
                                <!-- Ảnh sản phẩm - CLICK MỞ MODAL -->
                                <div class="product-img-box" style="cursor: pointer;"
                                    data-bs-toggle="modal" data-bs-target="#productModal"
                                    data-name="<?php echo e($item->name); ?>"
                                    data-brand="<?php echo e($item->brand); ?>"
                                    data-price="<?php echo e(number_format($item->price, 0, ',', '.')); ?>₫"
                                    data-stock="<?php echo e($item->quantity > 0 ? 'Sẵn hàng (' . $item->quantity . ')' : 'Hết hàng'); ?>"
                                    data-image="<?php echo e(asset($item->image)); ?>"
                                    data-description="<?php echo e($item->description ?? 'Chưa có mô tả chi tiết'); ?>">
                                    <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->name); ?>" onerror="this.src='<?php echo e(asset('img/no-image.png')); ?>'">
                                </div>
 
                                <div class="product-body text-center" style="flex: 1;">
                                    <p class="text-muted small mb-1"><?php echo e($item->brand); ?></p>
                                   
                                    <!-- Tên sản phẩm - CLICK MỞ MODAL -->
                                    <h3 class="h6 fw-bold mb-2" style="cursor: pointer;"
                                        data-bs-toggle="modal" data-bs-target="#productModal"
                                        data-name="<?php echo e($item->name); ?>"
                                        data-brand="<?php echo e($item->brand); ?>"
                                        data-price="<?php echo e(number_format($item->price, 0, ',', '.')); ?>₫"
                                        data-stock="<?php echo e($item->quantity > 0 ? 'Sẵn hàng (' . $item->quantity . ')' : 'Hết hàng'); ?>"
                                        data-image="<?php echo e(asset($item->image)); ?>"
                                        data-description="<?php echo e($item->description ?? 'Chưa có mô tả chi tiết'); ?>">
                                        <?php echo e(Str::limit($item->name, 35)); ?>

                                    </h3>
                                   
                                    <h4 class="text-danger fw-extrabold mb-3">
                                        <?php echo e(number_format($item->price, 0, ',', '.')); ?>₫
                                    </h4>
                                   
                                    <div class="mb-3">
                                        <?php if($item->quantity > 0): ?>
                                            <small class="text-success"><i class="fa fa-check"></i> Sẵn hàng (<?php echo e($item->quantity); ?>)</small>
                                        <?php else: ?>
                                            <small class="text-secondary"><i class="fa fa-clock-o"></i> Chờ hàng</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
 
                                <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn-add-to-cart <?php echo e($item->quantity <= 0 ? 'disabled' : ''); ?>" <?php echo e($item->quantity <= 0 ? 'disabled' : ''); ?>>
                                        <i class="fa fa-shopping-cart"></i> THÊM GIỎ HÀNG
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/client/index.blade.php ENDPATH**/ ?>