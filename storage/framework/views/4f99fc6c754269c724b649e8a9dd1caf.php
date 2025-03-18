 

    <nav class="breadcrumb-container">
      <ul class="breadcrumb">
          <li><a href="<?php echo e(route('home')); ?>">Trang chủ</a></li>
          <?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <?php if($link->url != '#'): ?>
                <a   href="<?php echo e($link->url); ?>">
              <?php endif; ?>
                <?php echo e($link->title); ?>

              <?php if($link->url != '#'): ?>
                </a>
              <?php endif; ?>
              
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </nav><?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/breadcrumb.blade.php ENDPATH**/ ?>