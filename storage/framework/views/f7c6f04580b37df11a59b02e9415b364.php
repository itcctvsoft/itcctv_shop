
<meta charset="utf-8">
<link href="<?php echo e($detail->icon); ?>" rel="shortcut icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="GENERATOR" content="<?php echo e($detail->short_name); ?>" />
<meta name="keywords" content= "<?php echo e(isset($keyword)?$keyword:$detail->keyword); ?>"/>
<meta name="description" content= "<?php echo e(isset($description)?strip_tags($description):$detail->memory); ?>"/>
<meta name="author" content="<?php echo e($detail->short_name); ?>">
<title><?php echo e($detail->company_name); ?></title>
<!-- BEGIN: CSS Assets-->
<link rel="stylesheet" href="<?php echo e(asset('backend/assets/dist/css/app.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('backend/assets/vendor/css/bootstrap-switch-button.min.css')); ?>" > 
<link rel="stylesheet" href="https://itcctv-soft.s3.us-east-1.amazonaws.com/cdn/mydatepicker.css" > 
<!-- END: CSS Assets-->
<!-- <script src="<?php echo e(asset('backend/assets/vendor/libs/jquery/jquery.js')); ?>"></script>  -->

 


<?php echo $__env->yieldContent('css'); ?>
<?php echo $__env->yieldContent('scriptop'); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/backend/layouts/head.blade.php ENDPATH**/ ?>