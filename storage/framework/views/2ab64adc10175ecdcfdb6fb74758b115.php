<?php
    $user = auth()->user();
    if($user)
    {
        $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
        .$user->id.") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
        $pro_carts =   \Illuminate\Support\Facades\DB::select($sql ) ;
    }
    else
    {
        $pro_carts = [];
    }
?>

<div><img src="<?php echo e(asset('frontend/assets/images/icon/cart.png')); ?>"
        class="img-fluid blur-up lazyload" alt=""> <i
        class="ti-shopping-cart"></i></div>
<span id = "cart_qty_cls" class="cart_qty_cls"><?php echo e(count($pro_carts)); ?></span>
<ul class="show-div shopping-cart" id="head_shoping_cart">
   
   
    <?php  
        $totalcart = 0;
        for($i = 0; $i < count($pro_carts); $i ++)
        {
            $pro = $pro_carts[$i];
            $photos = explode( ',', $pro->photo); 
            if($i == 5)
                break;  
            ?>
                <li> 
                    <div class="cart-product">
                        <img alt="" class="cart-product-image" src="<?php echo e($photos[0]); ?>">
                        
                        <div class="cart-product-info">
                            <a href="#"><h6 class="cart-product-title"><?php echo e($pro->title); ?></h6></a>
                            <h6><span><?php echo e($pro->quantity); ?> x <?php echo e(number_format($pro->price, 0, ".", ",")); ?></span></h6>
                        </div>
                    </div>  
                     
                </li>
            <?php
            $totalcart  += $pro->price*$pro->quantity;
        } 
        for( ; $i < count($pro_carts); $i ++)
        {
            $pro = $pro_carts[$i];
            $totalcart  += $pro->price*$pro->quantity;
        }
        ?>
        <?php if(count ($pro_carts) > 10): ?>
            <li>   <a href="#"> Xem thêm ...  </a>    </li>
        <?php endif; ?>
        <li>  
            <div class="total"> 
                <h5>Tổng : <span> <?php echo e(number_format($totalcart,0,".",",")); ?> </span></h5>
            </div>
        </li>  
        <li>  
            <div class="buttons">
                <a href="<?php echo e(route('front.shopingcart.view')); ?>" class="view-cart">  Xem giỏ hàng</a>
                <a href="<?php echo e(route('front.shopingcart.checkout')); ?>" class="checkout">Mua hàng</a>
            </div>
        </li>         
   
</ul><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/frontend/layouts/head_shopcart.blade.php ENDPATH**/ ?>