<?php $__env->startSection('title', 'Giỏ hàng - Nhóm 4 CNM'); ?>

<?php $__env->startSection('content'); ?>
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb-tree">
                    <li><a href="<?php echo e(route('shop.index')); ?>">Trang chủ</a></li>
                    <li class="active">Giỏ hàng</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <?php if(empty($cart)): ?>
            <div class="row">
                <div class="col-md-12 text-center" style="padding: 80px 0;">
                    <i class="fa fa-shopping-cart" style="font-size: 100px; color: #ddd; margin-bottom: 20px;"></i>
                    <h3 style="color: #666;">Giỏ hàng trống</h3>
                    <p style="color: #999; margin-bottom: 30px;">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                    <a href="<?php echo e(route('shop.index')); ?>" class="primary-btn">Tiếp tục mua sắm</a>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="cart-header" style="border-bottom: 2px solid #E4E7ED; padding-bottom: 10px; margin-bottom: 20px;">
                        <strong>SẢN PHẨM (<?php echo e(count($cart)); ?>)</strong>
                    </div>

                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cart-item" style="border-bottom: 1px solid #E4E7ED; padding: 20px 0;">
                            <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                                <div class="col-md-2 col-xs-4">
                                    <img src="<?php echo e(asset($item['image'])); ?>" alt="<?php echo e($item['name']); ?>" 
                                         style="width: 100%; border-radius: 5px; border: 1px solid #eee; object-fit: contain;">
                                </div>

                                <div class="col-md-5 col-xs-8">
                                    <h3 class="product-name" style="font-size: 16px; margin: 0 0 5px 0;">
                                        <a href="#" style="font-weight: 700; color: #2B2D42;"><?php echo e($item['name']); ?></a>
                                    </h3>
                                    <p style="font-size: 12px; color: #777; margin-bottom: 5px;">
                                        <?php if(isset($item['brand'])): ?> <span>Hãng: <?php echo e($item['brand']); ?></span> <?php endif; ?>
                                        <?php if(isset($item['color'])): ?> <span> | Màu: <?php echo e($item['color']); ?></span> <?php endif; ?>
                                    </p>
                                    <h4 style="color: #D10024; font-size: 16px;"><?php echo e(number_format($item['price'], 0, ',', '.')); ?>₫</h4>
                                    <?php if(isset($item['stock'])): ?>
                                        <span style="font-size: 11px; color: #4CAF50;"><i class="fa fa-check-circle"></i> Còn <?php echo e($item['stock']); ?> sản phẩm</span>
                                    <?php endif; ?>
                                </div>

                                <div class="col-md-3 col-xs-6 text-center">
                                    <div class="qty-container" style="display: flex; align-items: center; justify-content: center;">
                                        <button class="qty-btn qty-down" data-id="<?php echo e($id); ?>">-</button>
                                        <input type="number" value="<?php echo e($item['quantity']); ?>" min="1" 
                                               class="quantity-input" data-id="<?php echo e($id); ?>" data-price="<?php echo e($item['price']); ?>" readonly>
                                        <button class="qty-btn qty-up" data-id="<?php echo e($id); ?>">+</button>
                                    </div>
                                </div>

                                <div class="col-md-2 col-xs-6 text-right">
                                    <h4 class="subtotal" data-id="<?php echo e($id); ?>" style="font-weight: 700; margin-bottom: 10px;">
                                        <?php echo e(number_format($item['price'] * $item['quantity'], 0, ',', '.')); ?>₫
                                    </h4>
                                    <form action="<?php echo e(route('cart.remove', $id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" style="border: none; background: none; color: #D10024; cursor: pointer; font-size: 13px;">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div style="margin-top: 30px; display: flex; justify-content: space-between;">
                        <a href="<?php echo e(route('shop.index')); ?>" class="btn-link"><i class="fa fa-arrow-left"></i> Tiếp tục mua sắm</a>
                        <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" onclick="return confirm('Xóa sạch giỏ hàng?')" style="border:none; background:none; color:#999;">
                                <i class="fa fa-trash"></i> Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="order-summary-box" style="border: 2px solid #E4E7ED; padding: 25px; background: #fff;">
                        <h3 style="font-size: 18px; margin-bottom: 20px; text-transform: uppercase;">Tổng đơn hàng</h3>
                        <div class="summary-line" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span>Tạm tính:</span>
                            <strong id="cart-total"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</strong>
                        </div>
                        <div class="summary-line" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span>Phí vận chuyển:</span>
                            <strong style="color: #4CAF50;">Miễn phí</strong>
                        </div>
                        <hr>
                        <div class="summary-line" style="display: flex; justify-content: space-between; margin-bottom: 25px;">
                            <span style="font-weight: 700;">TỔNG CỘNG:</span>
                            <strong id="final-total" style="color: #D10024; font-size: 22px;"><?php echo e(number_format($total, 0, ',', '.')); ?>₫</strong>
                        </div>
                        <a href="<?php echo e(route('checkout.index')); ?>" class="primary-btn" style="width: 100%; text-align: center; display: block;">
                            THANH TOÁN <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .qty-container { gap: 5px; }
    .qty-btn {
        width: 30px; height: 30px;
        border: 1px solid #E4E7ED;
        background: #fff; cursor: pointer;
        transition: 0.2s;
    }
    .qty-btn:hover { background: #D10024; color: #fff; border-color: #D10024; }
    .quantity-input {
        width: 45px; height: 30px;
        text-align: center; border: 1px solid #E4E7ED;
    }
    .btn-link { color: #2B2D42; font-weight: 700; text-decoration: none; }
    .btn-link:hover { color: #D10024; }
    /* Fix cho mobile */
    @media (max-width: 768px) {
        .row { flex-wrap: wrap; }
        .text-right { text-align: center !important; margin-top: 15px; }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    function updateCart(productId, quantity) {
        $.ajax({
            url: '<?php echo e(route("cart.update")); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                if (response.success) {
                    $('.subtotal[data-id="' + productId + '"]').text(response.subtotal + '₫');
                    $('#cart-total').text(response.total + '₫');
                    $('#final-total').text(response.total + '₫');
                }
            }
        });
    }

    $('.qty-up').on('click', function() {
        let input = $(this).siblings('.quantity-input');
        let newVal = parseInt(input.val()) + 1;
        input.val(newVal);
        updateCart(input.data('id'), newVal);
    });

    $('.qty-down').on('click', function() {
        let input = $(this).siblings('.quantity-input');
        let newVal = parseInt(input.val()) - 1;
        if (newVal >= 1) {
            input.val(newVal);
            updateCart(input.data('id'), newVal);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/cart/index.blade.php ENDPATH**/ ?>