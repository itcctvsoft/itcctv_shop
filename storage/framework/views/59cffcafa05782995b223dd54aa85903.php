 <!-- BEGIN: Dark Mode Switcher-->
     
 <div style="background-color: rgb(var(--color-primary) / var(--tw-bg-opacity)); height:50px; width:100%; text-align:center; color:white; display: flex; align-items: center; justify-content: center;">
              Phần mềm quản lý bán hàng ITCCTV_SHOP phiên bản <?php echo e($detail->version); ?>.0 
       </div>
    <!-- END: Dark Mode Switcher-->
        
        <!-- BEGIN: JS Assets-->
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        
        <script src="<?php echo e(asset('backend/assets/dist/js/app2.js')); ?>"></script>
        <script src="<?php echo e(asset('backend/assets/vendor/libs/jquery/jquery.js')); ?>"></script> 
        <script src="https://itcctv-soft.s3.us-east-1.amazonaws.com/cdn/mydatepicker.js"></script> 
        <!-- END: JS Assets-->
       <script>
              function formatNumberS(input) {
                     // Loại bỏ tất cả các dấu phẩy
                     let value = input.value.replace(/,/g, '');
                     // let value = input.value.replace(/[^0-9,]/g, '');
                     // Chuyển thành dạng số và định dạng lại với dấu phân cách hàng nghìn
                     input.value = parseFloat(value);
                     if(isNaN(input.value))
                            input.value=0;
                     value = input.value;
                    
                     if (!isNaN(value) && value.length > 3) {
                            input.value = parseFloat(value).toLocaleString('en');
                     }
                     
              }
       </script>
        <?php echo $__env->yieldContent('scripts'); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/backend/layouts/footer.blade.php ENDPATH**/ ?>