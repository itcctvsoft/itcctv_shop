
<?php $__env->startSection('content'); ?>

<div class="content">
<?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <h2 class="intro-y text-lg  mt-10">
        Điều chỉnh chức năng cho role: <span class="font-medium"> <?php echo e($role->title); ?> </span>
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
         
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Alias</th>
                        <th class="whitespace-nowrap">Tên</th>
                        
                        <th class="text-center whitespace-nowrap">
                            <a class="btn" href="<?php echo e(route('role.selectall',$role->id)); ?>" 
                            class="flex items-center mr-3" href="javascript:;"> 
                              Chọn hết</a>

                        </th>
                         
                        
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $role_functions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <tr class="intro-x">
                        <td>
                             <?php echo e($item->alias); ?> 
                        </td>
                        <td>
                        <?php echo e($item->title); ?> 
                        </td>
                         
                        <td class="text-center"> 
                            <input type="checkbox" 
                            data-toggle="switchbutton" 
                            data-onlabel="active"
                            data-offlabel="inactive"
                            <?php echo e($item->value==1?"checked":""); ?>

                            data-size="sm"
                            name="toogle"
                            value="<?php echo e($item->id); ?>"
                            data-style="ios">
                        </td>
                       
                         
                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                </tbody>
            </table>
            
        </div>
    </div>
    <!-- END: HTML Table Data -->
        <!-- BEGIN: Pagination -->
         
        <!-- END: Pagination -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('backend/assets/vendor/js/bootstrap-switch-button.min.js')); ?>"></script>
 
<script>
 

    $("[name='toogle']").change(function() {
        var mode = $(this).prop('checked');
        var id=$(this).val();
        $.ajax({
            url:"<?php echo e(route('role.functionstatus')); ?>",
            type:"post",
            data:{
                _token:'<?php echo e(csrf_token()); ?>',
                mode:mode,
                id:id,
                role_id:<?php echo e($role->id); ?>,
            },
            success:function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: response.msg,
                showConfirmButton: false,
                timer: 1000
                });
                console.log(response.msg);
            }
            
        });
  
});  
    
</script>
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/backend/roles/cfunction.blade.php ENDPATH**/ ?>