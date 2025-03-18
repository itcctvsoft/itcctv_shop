<?php
    $cats = \App\Models\Category::where('status','active')->where('parent_id',null)->orderBy('title','asc')->get();
    if(!isset($slug))
        $slug = '';  
?>
<?php
  
  foreach ($cats as $cat)
  {
      $sql = "select count(id) as tong from products where cat_id = ".$cat->id;
      $re = \DB::select($sql);
      $cat->sobai = $re[0]->tong;
  }
  ?>


    <h3>Danh mục sản phẩm</h3>
    <ul class="category-list">
       
        <li><a href="<?php echo e(route('front.product.hot')); ?>" data-category="all" class="<?php echo e($slug==''?'active':''); ?>">Tất cả</a></li>
        <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(route('front.product.cat',$cat->slug)); ?>" class="<?php echo e($slug==$cat->slug?'active':''); ?>" ><?php echo e($cat->title); ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       
    </ul>


 <?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/catpromenu.blade.php ENDPATH**/ ?>