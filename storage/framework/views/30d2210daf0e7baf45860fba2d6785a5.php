<footer class="footer">
    <div class="footer-container">
        <div class="footer-top">
            <div class="footer-section">
                <div class="footer-title footer-mobile-title">
                    <h4>Thông tin công ty</h4>
                </div>

                <div class="footer-contant">
                    <?php if(isset($detail) && property_exists($detail, 'logo')): ?>
                        <div class="footer-logo"><img src="<?php echo e($detail->logo); ?>" alt=""></div>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'company_name')): ?>
                        <h3><?php echo e($detail->company_name); ?></h3>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'memory')): ?>
                        <p><?php echo e($detail->memory); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="footer-section">
                <h4 class="widget-title text-white !mb-3">THÔNG TIN CHI TIẾT</h4>
                <ul class="contact-list">
                    <?php if(isset($detail) && property_exists($detail, 'address')): ?>
                        <li><i class="fa fa-map-marker"></i> <?php echo e($detail->address); ?></li>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'phone')): ?>
                        <li><i class="fa fa-phone"></i> Điện thoại: <?php echo e($detail->phone); ?></li>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'email')): ?>
                        <li><i class="fa fa-envelope"></i> Email: <?php echo e($detail->email); ?></li>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'mst')): ?>
                        <li><i class="fa fa-book"></i> Mã số doanh nghiệp: <?php echo e($detail->mst); ?></li>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'thoigiandk')): ?>
                        <li><i class="fa fa-book"></i> <?php echo e($detail->thoigiandk); ?></li>
                    <?php endif; ?>

                    <?php if(isset($detail) && property_exists($detail, 'nguoilienhe')): ?>
                        <li><i class="fa fa-book"></i> <?php echo e($detail->nguoilienhe); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp3/layouts/footer.blade.php ENDPATH**/ ?>