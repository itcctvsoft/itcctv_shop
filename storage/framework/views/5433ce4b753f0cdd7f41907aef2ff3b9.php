
<?php $__env->startSection('topcss'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('frontend_tp3.layouts.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="product-container">
    <!-- Sidebar: Categories -->
    <?php
    $slug = $cat->slug;
    ?>

  
    <section class='catproduct-module'>
        
            <div class="product-list">
              
                    <?php
                        ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $pros = \DB::select('select a.*, b.old_price from (select * from products where id = '.$pro->id.') as a left join productextends b on a.id = b.product_id  ') ;
                        $product = $pros[0];
                        $cat = \App\Models\Category::find($product->cat_id); 
                        $photos = explode( ',', $product->photo);
                        $word = 0;
                        if ($product->price < $product->old_price )
                            $word = round(($product->old_price - $product->price)*100 /$product->old_price);
                        ?>
                        <div class="product-item" data-category="<?php echo e($product->cat_id); ?>">
                            <?php if($word > 0): ?>
                            <div class="discount-badge">-<?php echo e($word); ?>%</div> 
                            <?php endif; ?>
                            <a href="<?php echo e(route('front.product.view',$product->slug)); ?>">
                                <img src="<?php echo e($photos[0]?$photos[0]:asset('frontend/assets/images/electronics/pro/26.jpg')); ?>" alt="<?php echo e($product->title); ?>">
                            </a>
                            <h3><?php echo e($product->title); ?></h3>
                        
                            <div class="pro_actions">
                                <div class="price "><del> <?php echo e($product->old_price?number_format($product->old_price,0,".",",") :''); ?></del> 
                                    <?php echo e(number_format($product->price,0,".",",")); ?>

                                </div>
                                <a href="javascript:void(0)" class="btn   ti-shopping-cart" data-id="<?php echo e($product->id); ?>" >🛒</a>
                                <a href="javascript:void(0)" class="btn ti-heart" data-id="<?php echo e($product->id); ?>"
                                    aria-hidden="true">❤️</a>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
            </div>
            <nav class="flex pagination-container" aria-label="pagination" class="">
                <!-- /.pagination -->
                <?php echo e($products->links('vendor.pagination.simple-new')); ?>

            </nav>
    </section>
    <aside class="category-menu">
        <?php echo $__env->make('frontend_tp3.layouts.catpromenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend_tp3.layouts.sideproduct', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('frontend_tp3.layouts.sidehotproduct', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </aside>
    <!-- Main Content: Products -->
    
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('footscript'); ?>
 
<?php $__env->stopSection(); ?>


 
<?php echo $__env->make('frontend_tp3.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/product/category.blade.php ENDPATH**/ ?>