
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="<?php echo e($setting->short_name); ?>">
  <meta content="INDEX,FOLLOW" name="robots" />
  <meta name="copyright" content="<?php echo e($setting->site_url); ?>" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <meta http-equiv="audience" content="General" />
  <meta name="resource-type" content="Document" />
  <meta name="distribution" content="Global" />
  <meta name="revisit-after" content="1 days" />
  <meta name="GENERATOR" content="<?php echo e($setting->short_name); ?>" />
  <meta name="keywords" content= "<?php echo e(isset($keyword)?$keyword:$setting->keyword); ?>"/>
  <meta name="description" content= "<?php echo e(isset($description)?strip_tags($description):$setting->memory); ?>"/>
  
  <!-- Facebook Meta Tags -->
  <meta property="og:title" content=' <?php echo e(isset($page_up_title)?$page_up_title:$setting->web_title); ?>' />
  <meta property="og:description" content="<?php echo e(isset($description)?strip_tags($description):$setting->memory); ?>" />
  <meta property="og:image" content="<?php echo e(isset($ogimage)?$ogimage:$setting->logo); ?>" />
  <meta property="og:url" content='<?php echo e("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>'>
  <meta property="og:type" content="website">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta property="twitter:domain" content="<?php echo e($setting->site_url); ?>">
  <meta property="twitter:url" content='<?php echo e("https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>'>
  <meta name="twitter:title" content=' <?php echo e(isset($page_up_title)?$page_up_title:$setting->web_title); ?>' />
  <meta name="twitter:description" content="<?php echo e(isset($description)?strip_tags($description):$setting->memory); ?>" />
  <meta name="twitter:image" content="<?php echo e(isset($ogimage)?$ogimage:$setting->logo); ?>" />
      
  <link href="<?php echo e($setting->icon); ?>" rel="shortcut icon">
  <link rel="shortcut icon" href="<?php echo e($setting->icon); ?>" type="image/x-icon" />
  <title><?php echo e(isset($page_up_title)?$page_up_title:""); ?> <?php echo e($setting->web_title); ?> </title>

  <!-- google fonts -->
  <link rel="stylesheet" href="<?php echo e(asset('/frontend_tp3/css/style.css')); ?>">
  <style>
    <?php if(env('SHOW_CART') == 0): ?>
        <?php if(auth()->user() && auth()->user()->full_name != 'demo1'): ?>
            .cart-box{
                display:none !important;
            }
            .item-cart,   #btn_add_to_cart{
                display:none !important;
            }
        <?php endif; ?>
        <?php if(!auth()->user()  ): ?>
            .cart-box{
                display:none !important;
            }
            .item-cart,   #btn_add_to_cart{
                display:none !important;
            }
        <?php endif; ?>
    <?php endif; ?>
       
  </style>
  <?php echo $__env->yieldContent('topcss'); ?>
 <?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/head.blade.php ENDPATH**/ ?>