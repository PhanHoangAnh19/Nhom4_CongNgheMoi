

<?php $__env->startSection('content'); ?>
    <!-- SECTION -->
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- Banner collections -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="<?php echo e(asset('img/shop01.png')); ?>" alt="">
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
                            <img src="<?php echo e(asset('img/shop03.png')); ?>" alt="">
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
                            <img src="<?php echo e(asset('img/shop02.png')); ?>" alt="">
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
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryName => $productList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($productList->count() > 0): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="category-header">
                                <h3 class="title"><?php echo e($categoryName); ?></h3>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row display-flex-wrap">
                                <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 col-sm-6 col-xs-6 mb-30 d-flex">
                                        <div class="product-card">
                                            <div class="product-img-container">
                                                <img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->name); ?>">
                                                <div class="product-label">
                                                    <?php if($item->quantity > 0): ?>
                                                        <span class="new-label">MỚI</span>
                                                    <?php else: ?>
                                                        <span class="new-label" style="background: #999;">HẾT HÀNG</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="product-content">
                                                <p class="product-brand"><?php echo e($item->brand); ?></p>
                                                <h3 class="product-title">
                                                    <a href="#"><?php echo e($item->name); ?></a>
                                                </h3>
                                                <h4 class="product-price">
                                                    <?php echo e(number_format($item->price, 0, ',', '.')); ?>₫
                                                </h4>
                                                
                                                <!-- Hiển thị số lượng còn -->
                                                <?php if($item->quantity > 0): ?>
                                                    <p style="font-size: 11px; color: #4CAF50; margin-top: 5px;">
                                                        <i class="fa fa-check-circle"></i> Còn <?php echo e($item->quantity); ?> sản phẩm
                                                    </p>
                                                <?php else: ?>
                                                    <p style="font-size: 11px; color: #f44336; margin-top: 5px;">
                                                        <i class="fa fa-times-circle"></i> Tạm hết hàng
                                                    </p>
                                                <?php endif; ?>
                                            </div>

                                            <div class="product-action">
                                                <?php if($item->quantity > 0): ?>
                                                    <form action="<?php echo e(route('cart.add', $item->id)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="add-to-cart-btn">
                                                            <i class="fa fa-shopping-cart"></i> THÊM VÀO GIỎ
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="add-to-cart-btn" disabled style="background: #999; cursor: not-allowed;">
                                                        <i class="fa fa-ban"></i> HẾT HÀNG
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="category-spacer"></div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/client/index.blade.php ENDPATH**/ ?>