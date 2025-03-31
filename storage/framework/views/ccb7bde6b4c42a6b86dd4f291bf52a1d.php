<div class="col-lg-3">
    <div class="dashboard-sidebar">
        <div class="profile-top">
            <div class="profile-image">
                <img src="<?php echo e(isset($profile->photo)?$profile->photo:asset('frontend/assets/images/avtar.jpg')); ?>" alt="" class="img-fluid">
            </div>
            <div class="profile-detail">
                
                <h5><?php echo e($profile->full_name); ?></h5>
                <h6><?php echo e($profile->email); ?></h6>
            </div>
        </div>
        <div class="faq-tab">
            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link <?php echo e($menu ==1? 'active':''); ?>" href="<?php echo e(route('front.profile')); ?>"
                        >Thông tin tài khoản</a></li>
                <li class="nav-item">
                    <a  href="<?php echo e(route('front.shopingcart.view')); ?>"
                        class="nav-link  <?php echo e($menu ==2? 'active':''); ?>">Giỏ hàng</a></li>
                <li class="nav-item ">
                    <a  class="nav-link <?php echo e($menu ==3? 'active':''); ?>" href="<?php echo e(route('front.profile.addressbook')); ?>"
                        >Danh sách địa chỉ</a></li>
                <li class="nav-item ">
                    <a class="nav-link <?php echo e($menu ==4? 'active':''); ?>" href="<?php echo e(route('front.wishlist.view')); ?>">SP Yêu thích</a></li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($menu ==5? 'active':''); ?> " href="<?php echo e(route('front.profile.order')); ?>">Đơn hàng chờ xử lý</a></li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($menu ==6? 'active':''); ?>" href="<?php echo e(route('front.profile.warehouseout')); ?>">Đơn hàng hoàn thành</a></li>
                <li class="nav-item ">
                    <a   class="nav-link <?php echo e($menu ==7? 'active':''); ?>" href="<?php echo e(route('front.profile.viewsuptrans')); ?>">Công nợ</a></li>
                
            </ul>
        </div>
    </div>
</div><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/frontend/profile/profilemenu.blade.php ENDPATH**/ ?>