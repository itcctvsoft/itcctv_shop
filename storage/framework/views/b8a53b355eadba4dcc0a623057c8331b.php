


<div class="new-products-sidebar">
    <h4>Sản phẩm mới</h4>
    <ul class="new-products-list">
        <!-- Mỗi sản phẩm -->
        <?php $__currentLoopData = $newpros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $photos = explode( ',', $pro->photo);
            ?>
            <li class="new-product-item">
                <a href="<?php echo e(route('front.product.view',$pro->slug)); ?>">
                    <img src="<?php echo e($photos[0]); ?>" alt="<?php echo e($pro->title); ?>">
                    <div class="product-info">
                        <span class="product-title"><?php echo e($pro->title); ?></span>
                        <span class="product-price"><?php echo e(number_format($pro->price,0,'.',',')); ?></span>
                    </div>
                </a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>

 <?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/sideproduct.blade.php ENDPATH**/ ?>