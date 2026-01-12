

<?php $__env->startSection('title', 'Đặt hàng thành công - Nhóm 4 CNM'); ?>

<?php $__env->startSection('content'); ?>
<!-- SECTION -->
<div class="section" style="padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <!-- Success Message -->
                <div style="background: white; border: 2px solid #4CAF50; border-radius: 8px; padding: 40px; text-align: center; margin-bottom: 30px;">
                    <div style="display: inline-block; width: 80px; height: 80px; background: #4CAF50; border-radius: 50%; margin-bottom: 20px; position: relative;">
                        <i class="fa fa-check" style="color: white; font-size: 50px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                    </div>
                    <h1 style="color: #2B2D42; font-size: 32px; margin-bottom: 10px;">Đặt hàng thành công!</h1>
                    <p style="color: #666; font-size: 16px; margin-bottom: 20px;">
                        Cảm ơn bạn đã đặt hàng. Chúng tôi đã nhận được đơn hàng của bạn.
                    </p>
                    <div style="background: #f9f9f9; padding: 20px; border-radius: 5px; display: inline-block;">
                        <p style="color: #999; font-size: 12px; margin-bottom: 5px;">MÃ ĐƠN HÀNG</p>
                        <p style="color: #D10024; font-size: 28px; font-weight: 700; margin: 0;"><?php echo e($order->order_number); ?></p>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="order-details" style="background: white; border: 2px solid #E4E7ED; padding: 30px; margin-bottom: 20px;">
                    <div class="section-title">
                        <h3 class="title">Chi tiết đơn hàng</h3>
                    </div>
                    
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6">
                            <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Ngày đặt hàng</p>
                            <p style="font-weight: 700;"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <div class="col-md-6">
                            <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Trạng thái</p>
                            <p>
                                <span style="background: #FFC107; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 700;">
                                    Đang xử lý
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-6">
                            <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Phương thức thanh toán</p>
                            <p style="font-weight: 700;">
                                <?php if($order->payment_method == 'cod'): ?>
                                    Thanh toán khi nhận hàng (COD)
                                <?php elseif($order->payment_method == 'bank_transfer'): ?>
                                    Chuyển khoản ngân hàng
                                <?php else: ?>
                                    Thanh toán bằng thẻ
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p style="color: #999; font-size: 12px; margin-bottom: 5px;">Tổng tiền</p>
                            <p style="color: #D10024; font-size: 24px; font-weight: 700;">
                                <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫
                            </p>
                        </div>
                    </div>

                    <div style="border-top: 1px solid #E4E7ED; padding-top: 20px;">
                        <h4 style="font-weight: 700; margin-bottom: 15px;">Thông tin người nhận</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p style="margin-bottom: 10px;">
                                    <span style="color: #999;">Họ tên:</span>
                                    <strong><?php echo e($order->customer_name); ?></strong>
                                </p>
                                <p style="margin-bottom: 10px;">
                                    <span style="color: #999;">Email:</span>
                                    <strong><?php echo e($order->customer_email); ?></strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p style="margin-bottom: 10px;">
                                    <span style="color: #999;">Số điện thoại:</span>
                                    <strong><?php echo e($order->customer_phone); ?></strong>
                                </p>
                                <p style="margin-bottom: 10px;">
                                    <span style="color: #999;">Địa chỉ:</span>
                                    <strong><?php echo e($order->shipping_address); ?>, <?php echo e($order->ward); ?>, <?php echo e($order->district); ?>, <?php echo e($order->city); ?></strong>
                                </p>
                            </div>
                        </div>
                        <?php if($order->note): ?>
                            <p style="margin-top: 10px;">
                                <span style="color: #999;">Ghi chú:</span>
                                <em><?php echo e($order->note); ?></em>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-summary" style="background: white; border: 2px solid #E4E7ED; padding: 30px; margin-bottom: 20px;">
                    <div class="section-title">
                        <h3 class="title">Sản phẩm đã đặt</h3>
                    </div>
                    
                    <div class="order-col">
                        <div><strong>SẢN PHẨM</strong></div>
                        <div><strong>TỔNG</strong></div>
                    </div>
                    
                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="order-col" style="border-bottom: 1px solid #E4E7ED; padding: 15px 0;">
                            <div style="display: flex; align-items: center;">
                                <img src="<?php echo e(asset($item->product_image)); ?>" 
                                     alt="<?php echo e($item->product_name); ?>" 
                                     style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 5px;">
                                <div>
                                    <strong><?php echo e($item->product_name); ?></strong>
                                    <p style="color: #999; font-size: 12px; margin: 5px 0;">Số lượng: <?php echo e($item->quantity); ?></p>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <p style="color: #999; font-size: 12px;"><?php echo e(number_format($item->price, 0, ',', '.')); ?>₫</p>
                                <strong><?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>₫</strong>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="order-col" style="margin-top: 20px;">
                        <div><strong>TỔNG CỘNG:</strong></div>
                        <div><strong class="order-total"><?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>₫</strong></div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div style="background: #E3F2FD; border-left: 4px solid #2196F3; padding: 20px; margin-bottom: 20px;">
                    <h4 style="color: #1976D2; font-weight: 700; margin-bottom: 15px;">
                        <i class="fa fa-info-circle"></i> Bước tiếp theo
                    </h4>
                    <ul style="margin: 0; padding-left: 20px; color: #1976D2;">
                        <li style="margin-bottom: 10px;">Chúng tôi sẽ xác nhận đơn hàng qua email và số điện thoại trong vòng 24h</li>
                        <li style="margin-bottom: 10px;">Đơn hàng sẽ được giao trong vòng 3-5 ngày làm việc</li>
                        <li style="margin-bottom: 10px;">Bạn có thể theo dõi tình trạng đơn hàng trong mục "Đơn hàng của tôi"</li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div style="text-align: center;">
                    <a href="<?php echo e(route('shop.index')); ?>" class="primary-btn" style="display: inline-block; padding: 12px 40px; margin: 0 10px;">
                        <i class="fa fa-shopping-cart"></i> Tiếp tục mua sắm
                    </a>
                    <a href="#" class="primary-btn" style="display: inline-block; padding: 12px 40px; margin: 0 10px; background: #2B2D42;">
                        <i class="fa fa-list"></i> Đơn hàng của tôi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /SECTION -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.client', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/checkout/success.blade.php ENDPATH**/ ?>