<?php
 
  $setting =\App\Models\SettingDetail::find(1);
  $user = auth()->user();
  if($user)
  {
      $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
      .$user->id.") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
      $pro_carts =   \DB::select($sql ) ;
  }
  else
  {
      $pro_carts = [];
  }
  $cart_size= count($pro_carts);
?>
<!DOCTYPE html>
<html lang="vi">
<?php echo $__env->make('frontend_tp3.layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<body>
  <?php echo $__env->make('frontend_tp3.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="main-content">
      <div class="sticky-container">
      <div class="banner-left">
          <img src="<?php echo e(asset('/frontend_tp3/img/header-left.png')); ?>" alt="Tết Đậm Nét" />
      </div>
    </div>
      <div class="container">

     <?php echo $__env->yieldContent('content'); ?>
      </div>
      
    
      <div class="sticky-container">
        <div class="banner-right">

            <img src="<?php echo e(asset('/frontend_tp3/img/header-right.png')); ?>" alt="Trang trí Tết" />
        </div>
      </div>

     
  </main>

<?php echo $__env->make('frontend_tp3.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('frontend_tp3.layouts.foot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
</body>
</html>
<?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/master.blade.php ENDPATH**/ ?>