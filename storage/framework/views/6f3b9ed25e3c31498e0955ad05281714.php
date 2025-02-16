

<?php $__env->startSection('content'); ?>
    <section class="payment-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #333; font-weight: bold;">Kết quả thanh toán</h2>

            <div class="order-details mx-auto mb-4"
                style="max-width: 500px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px;">
                <?php if($status === 'success'): ?>
                    <h4 class="text-center" style="color: #28a745; font-weight: bold;">Giao dịch thành công</h4>
                    <p class="text-center">Mã đơn hàng: <strong><?php echo e($orderId); ?></strong></p>
                    <p class="text-center">Số tiền thanh toán:
                        <strong><?php echo e(number_format($amount, 0, '.', ',')); ?> VND</strong>
                    </p>
                    <p class="text-center">Mã giao dịch: <strong><?php echo e($transactionNo); ?></strong></p>
                <?php else: ?>
                    <h4 class="text-center" style="color: #dc3545; font-weight: bold;">Giao dịch không thành công</h4>
                    <p class="text-center">Lý do: <strong><?php echo e($message); ?></strong></p>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <a href="<?php echo e(route('front.profile.order')); ?>" class="btn btn-lg"
                    style="background-color: #007bff; color: #fff; padding: 10px 20px; font-size: 18px; border-radius: 5px;">
                    Xem đơn hàng
                </a>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend_tp.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp/cart/vnpay_result.blade.php ENDPATH**/ ?>