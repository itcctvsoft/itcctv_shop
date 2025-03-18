<?php
  // $cats = \App\Models\Category::where('parent_id',null)->where('is_show',1)->where('status','active')->get();
  $cats = \App\Models\Category::where('status','active')->where('parent_id',null)->orderBy('title','asc')->get();
  foreach($cats as $cat)
  {
      $childcats = \App\Models\Category::where('parent_id',$cat->id)->where('is_show',1)->where('status','active')->get();
      if(count($childcats)> 0)
        $cat->childcats = $childcats;
  }
  $catblogs = \App\Models\BlogCategory::where('status','active')->get();
?>

<header class="header">
  <div class="header-wrapper">
      <div class="header-content">
          <div class="header-top">
              <div class="logo">
                <a href="/">
                  <img src="<?php echo e($setting->logo); ?>" alt="<?php echo e($setting->company_name); ?>">
                  <span></span>
                </a>
              </div>
              <div class="search-bar">
                <form method = "GET" action="<?php echo e(route('front.product.search')); ?>"  >
                  <input name="searchdata" placeholder="Tìm kiếm sản phẩm..." id="search-form1" type="text"  >
                </form> 
                
                 
              </div>
              <?php if(!auth()->id()): ?>
              <!-- Nhóm nút khi chưa đăng nhập -->
              <div class="auth-buttons" style="display: block;">
                  <a href="<?php echo e(route('front.login')); ?>">🔑<span class='thide'>Đăng nhập</span></a>
                  <a href="<?php echo e(route('front.register')); ?>">✍️<span class='thide'>Đăng ký</span></a>
              </div>
              <?php else: ?>
              <!-- Nhóm nút khi đã đăng nhập -->
              <div class="user-actions" style="display: block;"> <!--Ẩn mặc định-->
                  <a href="<?php echo e(route('front.profile')); ?>" class="account">👤<span class='thide'>Tài khoản</span></a>
                  <a href="<?php echo e(route('front.shopingcart.view')); ?>" class="cart">
                      🛒 <span class='thide'>Giỏ hàng</span>
                  </a>
              </div>
              <?php endif; ?>
              <div class="menu-button" onclick="toggleMenu()">
                  <span></span>
                  <span></span>
                  <span></span>
              </div>
          </div>
          <div class="menu-container">
              <nav class="menu">
                <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#">Danh mục</a>
                  <div class="submenu">
                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="submenu-link" href="<?php echo e(route('front.product.cat',$cat->slug)); ?>"><?php echo e($cat->title); ?></a>
                        
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                </div>
            

                <a class="nav-link  " href="<?php echo e(route('front.product.hot' )); ?>" >Sản phẩm hot</a>
                <a class="nav-link  " href="<?php echo e(route('front.product.cat','laptop')); ?>" >Laptop</a>
                <a class="nav-link  " href="<?php echo e(route('front.chinhsach.view','bang-gia')); ?>" >Bảng giá</a>
                
                <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="<?php echo e(route('front.categories.view')); ?>">Tin tức</a>
                  <div class="submenu">
                    <?php if(count($catblogs)> 0): ?>
                        <?php $__currentLoopData = $catblogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catblog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <a class="submenu-link" href="<?php echo e(route('front.category.view',$catblog->slug)); ?>"><?php echo e($catblog->title); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php endif; ?>
                  </div>
                </div>
                  
              </nav>
          </div>
      </div>
  </div>
</header>
 <?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/header.blade.php ENDPATH**/ ?>