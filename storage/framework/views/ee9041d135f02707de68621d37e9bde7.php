<?php $__env->startSection('topcss'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('frontend_tp3.layouts.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="account-container">
        <!-- Menu bên trái -->
        <aside class="account-menu">
            <ul>
                <li class="menu-item "><a href="#">Thông tin tài khoản</a></li>
                <li class="menu-item "><a href="<?php echo e(route('front.profile.addressbook')); ?>">Địa chỉ mua hàng</a></li>
                <li class="menu-item"><a href="<?php echo e(route('front.shopingcart.view')); ?>"><i class="icon-cart"></i> Giỏ hàng</a>
                </li>
                <li class="menu-item active"><a href="<?php echo e(route('front.profile.order')); ?>"><i class="icon-history"></i> Lịch
                        sử mua hàng</a></li>
                <li class="menu-item"><a href="<?php echo e(route('front.wishlist.view')); ?>"><i class="icon-heart"></i> Danh sách yêu
                        thích</a></li>
            </ul>
        </aside>

        <!-- Nội dung chính -->
        <div class="account-details">
            <div class="order-list-container">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="order-item" onclick="toggleDetails(<?php echo e($order->id); ?>)">
                        <div class="order-circle"><?php echo e($order->id); ?></div>
                        <div class="order-info">
                            <div class="order-date"><?php echo e(date('Y-m-d', strtotime($order->created_at))); ?></div>
                            <div class="order-total"><?php echo e(number_format($order->final_amount, 0, '.', ',')); ?> VND</div>
                            <div class="order-status"><?php echo e($order->status); ?></div>
                        </div>
                        <div class="order-toggle"><span class="icon-toggle">▶</span></div>
                    </div>
                    <div id="order-details-<?php echo e($order->id); ?>" class="order-details" style="display: none;">
                        <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="order-product">
                                <span><?php echo e($detail->title); ?></span>
                                <span><?php echo e(number_format($detail->price, 0, '.', ',')); ?> VND</span>
                                <span><?php echo e($detail->quantity); ?></span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footscript'); ?>
    <script>
        function toggleDetails(orderId) {
            const details = document.getElementById(`order-details-${orderId}`);
            details.style.display = details.style.display === "none" ? "block" : "none";

            const toggleIcon = details.previousElementSibling.querySelector(".icon-toggle");
            toggleIcon.textContent = details.style.display === "block" ? "▼" : "▶";
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend_tp3.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/profile/order.blade.php ENDPATH**/ ?>