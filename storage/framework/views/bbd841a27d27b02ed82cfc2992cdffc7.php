
<?php $__env->startSection('css'); ?>
     
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <!-- left side bar -->
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a  href="javascript:void(0)" onclick="show(<?php echo e($order->id); ?>)" class="card mb-4 lift">
                        <div class="card-body p-5">
                            <span class="flex flex-wrap row">
                                <span class="col ">
                                  
                                <span class=" col "><?php echo e($order->id); ?></span> 
                                    <?php echo e(substr($order->created_at,0,10)); ?>

                                </span>
                                <span class="col ">
                                    <?php echo e(number_format($order->final_amount,0,'.',',')); ?>

                                </span>
                                <span class=" col">
                                    <?php echo e($order->status); ?> 
                                </span>
                                
                            </span>
                            <div id="order<?php echo e($order->id); ?>" style="background: #eee; display:none; padding-left: 10px; padding-top:10px">
                                <?php $__currentLoopData = $order->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderdetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="card-body p-2">
                                        <span class="flex flex-wrap row  ">
                                            <span class="  col">
                                                <?php echo e($orderdetail->title); ?>

                                            </span>
                                            <span class=" col">
                                                <?php echo e(number_format($orderdetail->price,0,'.',',')); ?>

                                            </span>
                                            <span class= " col ">
                                                <?php echo e($orderdetail->quantity); ?> 
                                            </span>
                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 <!-- right side content -->
            </div>
        </div>
    </section>
    <!--  dashboard section end -->
   
 
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
function show(id)
{
    $("#order" + id).toggle();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\shoplite\resources\views/frontend/profile/order.blade.php ENDPATH**/ ?>