<?php
?>

<div class="offcanvas-body flex flex-col">
    <div class="shopping-cart" id="head_shoping_cart">
        <?php $i = 0;
        $tong = 0;
        foreach ($pro_carts as $procart )
        {
                $photos = explode( ',', $procart->photo);
                $tong += $procart->price * $procart->quantity;

            ?>
        <div class="shopping-cart-item flex justify-between !mb-4">
            <div class="flex flex-row">
                <figure class="!rounded-[.4rem] !w-[7rem]">
                    <a href="<?php echo e(route('front.product.view', $procart->slug)); ?>">
                        <img class="!rounded-[.4rem]" src="<?php echo e($photos[0]); ?>" alt="<?php echo e($procart->title); ?>">
                    </a>
                </figure>
                <div class="!w-full !ml-[1rem]">
                    <h3 class="post-title !text-[.8rem] !leading-[1.35] !mb-1"><a
                            href="<?php echo e(route('front.product.view', $procart->slug)); ?>"
                            class="title_color"><?php echo e($procart->title); ?></a></h3>
                    <p class="price !text-[.7rem]"> <ins class="no-underline text-[#e2626b]"><span
                                class="amount"><?php echo e(number_format($procart->price, 0, '.', ',')); ?>đ</span></ins> x
                        <?php echo e($procart->quantity); ?></p>

                    <!--/.form-select-wrapper -->
                </div>
            </div>
            <!-- <div class="!ml-[.5rem]"><a href="#" class="title_color"><i class="uil uil-trash-alt before:content-['\\ed4b']"></i></a></div> -->
        </div>

        <?php
        }
        ?>

        <?php if (count($pro_carts) === 0): ?>
        <div class="empty-cart flex justify-center items-center flex-col">
            <img src="https://i.pinimg.com/originals/26/39/1e/26391e7b551203ac10f1c8ee89b151fe.gif" alt="Giỏ hàng trống"
                style="width: 400px; height: 300px; margin-bottom: 1rem;">
        </div>
        <?php endif; ?>
        <!--/.shopping-cart-item -->
    </div>
    <!-- /.shopping-cart-->
    <div class="offcanvas-footer flex-col text-center">
        <div class="flex !w-full justify-between !mb-4">
            <span>Tổng:</span>
            <span id="tong_quick_cart" class="h6 !mb-0"><?php echo e(number_format($tong, 0, '.', ',')); ?> đ</span>
        </div>

        <div class="flex flex-col gap-1">
            <!-- Nút Xem giỏ hàng -->
            <a href="<?php echo e(route('front.shopingcart.view')); ?>"
                class="btn view-cart flex items-center gap-2 text-[#3f78e0] bg-white border border-[#3f78e0] p-3 rounded-lg hover:bg-[#e6f4ff] transition-all duration-300">
                <i class="uil uil-shopping-cart-alt !text-[1rem]"></i>
                <span>Xem giỏ hàng</span>
            </a>

            <!-- Nút Mua hàng -->
            <a href="<?php echo e(route('front.shopingcart.checkout')); ?>"
                class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#00FFFF] hover:border-[#00FFFF] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#00FFFF] active:border-[#00FFFF] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] btn-icon btn-icon-start rounded-lg hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)] transition-all duration-300">
                <i class="uil uil-credit-card !text-[.9rem] mr-[0.3rem] before:content-['\\ea74']"></i>
                Mua hàng
            </a>
        </div>


        <p class="!text-[.7rem] !mb-0">Liên hệ hotline: <?php echo e($setting->hotline); ?> nếu gặp khó khăn trong quá trình mua
            hàng!</p>
    </div>
    <!-- /.offcanvas-footer-->
</div>
<?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp/layouts/quickcart.blade.php ENDPATH**/ ?>