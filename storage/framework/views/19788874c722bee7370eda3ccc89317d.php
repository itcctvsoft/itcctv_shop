
<?php $__env->startSection('content'); ?>

<div class = 'content'>
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Điều chỉnh tài khoản
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <!-- BEGIN: Form Layout -->
            <form method="post" action="<?php echo e(route('bankaccount.update',$bankaccount->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('patch'); ?>
                <div class="intro-y box p-5">
                    <div>
                        <label for="regular-form-1" class="form-label">Tên</label>
                        <input id="title" name="title" type="text" value="<?php echo e($bankaccount->title); ?>" class="form-control" placeholder="title">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Số tài khoản</label>
                        <input id="banknumber" name="banknumber" type="text" value="<?php echo e($bankaccount->banknumber); ?>" class="form-control" placeholder="số tài khoản">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Tên tài khoản</label>
                        <input id="accountname" name="accountname" type="text" value="<?php echo e($bankaccount->accountname); ?>" class="form-control" placeholder="tên tài khoản">
                    </div>
                    <div class="mt-3">
                        <label for="regular-form-1" class="form-label">Tên ngân hàng</label>
                        <input id="bankname" name="bankname" type="text" value="<?php echo e($bankaccount->bankname); ?>" class="form-control" placeholder="tên ngân hàng">
                    </div>
                    <div class="mt-3 form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" <?php echo e(old('is_default', $bankaccount->is_default ?? false) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_default">
                            Đặt làm tài khoản mặc định
                        </label>
                    </div>
                    <div class="mt-3">
                        <div class="flex flex-col sm:flex-row items-center">
                            <label style="min-width:70px  " class="form-select-label" for="status">Tình trạng</label>
                           
                            <select name="status"  class="form-select mt-2 sm:mr-2"   >
                                <option value ="active" <?php echo e($bankaccount->status=='active'?'selected':''); ?>>Active</option>
                                <option value = "inactive" <?php echo e($bankaccount->status=='inactive'?'selected':''); ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul>
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li>    <?php echo e($error); ?> </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary w-24">Cập nhật</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/backend/bankaccounts/edit.blade.php ENDPATH**/ ?>