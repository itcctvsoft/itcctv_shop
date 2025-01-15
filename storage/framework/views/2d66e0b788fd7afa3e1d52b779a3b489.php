
<?php $__env->startSection('css'); ?>
    
     
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
 
     <!-- section start -->
     <section class="section-b-space">
        <div class="container">
            <div class="checkout-page">
                <div class="checkout-form">
                    <form method="POST" action ="<?php echo e(route('front.shopingcart.order')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-title">
                                    <h3>Chi tiết đơn hàng</h3>
                                </div>
                                <div class="row check-out">
                                    <h2> Địa chỉ nhận hóa đơn </h2>
                                    <div id="invoice_div" class="form-group col-md-12 col-sm-12 col-xs-12">
                                            
                                                 <div id = "invoice_div_detail">
                                                <?php if($defaut_setting && isset($invoiceaddress)): ?>
                                                
                                                    <input type="hidden" name="invoice_id" value="<?php echo e($invoiceaddress->id); ?>" />
                                                    <div class="px-20">  
                                                        <h6> <?php echo e($invoiceaddress->full_name); ?> </j6>
                                                        <h6> <?php echo e($invoiceaddress->phone); ?> </j6>
                                                        <h6> <?php echo e($invoiceaddress->address); ?> </j6>
                                                    </div>
                                                
                                                <?php endif; ?>
                                                </div>
                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#addInvoiceAddress"
                                                                    data-bs-toggle="modal" class="bottom_btn">thêm</a> |
                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#changeInvoiceAddress"
                                                                    data-bs-toggle="modal" class="bottom_btn">chọn địa chỉ khác</a>
                                               
                                   
                                    </div>
                                    <h2> Địa chỉ giao hàng </h2>
                                    <div id="ship_div" class="form-group col-md-12 col-sm-12 col-xs-12">
                                            
                                                 <div id = "ship_div_detail">
                                                 <?php if($defaut_setting && isset($shipaddress)): ?>
                                                    <input type="hidden" name="ship_id" value="<?php echo e($shipaddress->id); ?>" />
                                                    <div  class="px-10">  
                                                        <h6> <?php echo e($shipaddress->full_name); ?> </j6>
                                                        <h6> <?php echo e($shipaddress->phone); ?> </j6>
                                                        <h6> <?php echo e($shipaddress->address); ?> </j6>
                                                    </div>
                                                
                                                <?php endif; ?>
                                                </div>
                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#addShipAddress"
                                                                    data-bs-toggle="modal" class="bottom_btn">thêm</a> |
                                                <a href="javascript:void(0)"
                                                                    data-bs-target="#changeShipAddress"
                                                                    data-bs-toggle="modal" class="bottom_btn">chọn địa chỉ khác</a>
                                               
                                   
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="checkout-details">
                                    <div class="order-box">
                                        <div class="title-box">
                                            <div>Sản phẩm <span>Tổng</span></div>
                                        </div>
                                        <ul class="qty">
                                            <?php $tong = 0;?>
                                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li><?php echo e($pro->title); ?> × <?php echo e($pro->quantity); ?> <span><?php echo e(number_format($pro->quantity * $pro->price,0,".",",")); ?></span></li>
                                                <?php $tong += $pro->quantity * $pro->price;?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           
                                             
                                        </ul>
                                        <ul class="sub-total">
                                            <li>tổng hàng <span class="count"><?php echo e(number_format($tong,0,".",",")); ?></span></li>
                                            <li>chi phí vận chuyển
                                                <div class="shipping">
                                                    <div class="shopping-option">
                                                        
                                                        <label for="free-shipping">Thông báo sau cho khách hàng</label>
                                                    </div>
                                                    
                                                </div>
                                            </li>
                                        </ul>
                                        <ul class="total">
                                        <li>Tổng <span class="count"><?php echo e(number_format($tong,0,".",",")); ?></span></li>
                                        </ul>
                                    </div>
                                    <div class="payment-box">
                                        <div class="upper-box">
                                            <div class="payment-options">
                                            <?php echo $paymentinfo ?>
                                            </div>
                                        </div>
                                        <div class="text-end"><button type="submit" class="btn-solid btn">Đặt hàng</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- section end -->
 <!-- Select invoice address start -->
 <div class="modal logout-modal fade" id="changeInvoiceAddress" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn địa chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                             
                            <div style="padding-left:10px" class="form-row row">
                                <?php $__currentLoopData = $addressbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row col-sl-12 py-10" style="border-bottom: 1px solid gray">
                                    <div class="col-lg-2  align-self-center ">
                                        <input type="radio" data-name="<?php echo e($address->full_name); ?>" data-phone="<?php echo e($address->phone); ?>" data-address=" <?php echo e($address->address); ?>" class="invoice_ra" name="invoice_id" value="<?php echo e($address->id); ?>">
                                    </div>
                                    <div class="col-lg-10    ">  
                                        <h6> Tên: <span> <?php echo e($address->full_name); ?></span> </h6>
                                        <h6> Điện thoại: <span> <?php echo e($address->phone); ?></span> </h6>
                                        <h6> Địa chỉ: <span> <?php echo e($address->address); ?></span> </h6>

                                    </div> 
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </div>
                            <div class="col-md-12  py-10 ">
                                    <button id="btnAddInv"  data-bs-dismiss="modal" class="btn btn-solid w-auto">Lưu</button>
                                </div>
                    </div>
            </div>
        </div>
</div>
    <!-- modal end -->
     <!-- Modal invoice start -->
<div class="modal logout-modal fade" id="addInvoiceAddress" tabindex="-1" role="dialog">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm địa chỉ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="theme-form" method= "POST" action="<?php echo e(route('front.profile.addinvoiceadd')); ?>">
                    <?php echo csrf_field(); ?>    
                    <div style="padding-left:10px" class="form-row row">
                        <div class="col-md-12 py-10">
                            <label for="email">Tên đầy đủ</label>
                            <input type="text" name="full_name" class="form-control" id="full_name"  
                                value="<?php echo e(old('full_name')); ?>" required >
                        </div>
                        <div class="col-md-12   py-10">
                            <label for="review">Điện thoại</label>
                            <input type="text" name="phone" class="form-control" id="phone"  
                            value="<?php echo e(old('phone')); ?>"  required >
                        </div>
                        <div class="col-md-12  py-10 ">
                            <label for="review">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" id="address" value="<?php echo e(old('address')); ?>"
                                    required  >
                        </div>
                        <div class="col-md-12  py-10 ">
                            <input type="checkbox" name="default" value = "1"/> địa chỉ mặc định
                        </div>
                        <div class="col-md-12  py-10 ">
                            <button type="submit" id="btnAddInv" class="btn btn-solid w-auto">Lưu</button>
                        </div>
                        
                    </div>
                </form>
            </div>
    </div>
</div>
</div>
    <!-- modal invoice end -->
    <!-- Select ship address start -->
 <div class="modal logout-modal fade" id="changeShipAddress" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chọn địa chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                             
                            <div style="padding-left:10px" class="form-row row">
                                <?php $__currentLoopData = $addressbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row col-sl-12 py-10" style="border-bottom: 1px solid gray">
                                    <div class="col-lg-2  align-self-center ">
                                        <input type="radio" data-name="<?php echo e($address->full_name); ?>" data-phone="<?php echo e($address->phone); ?>" data-address=" <?php echo e($address->address); ?>" class="ship_ra" name="ship_id" value="<?php echo e($address->id); ?>">
                                    </div>
                                    <div class="col-lg-10    ">  
                                        <h6> Tên: <span> <?php echo e($address->full_name); ?></span> </h6>
                                        <h6> Điện thoại: <span> <?php echo e($address->phone); ?></span> </h6>
                                        <h6> Địa chỉ: <span> <?php echo e($address->address); ?></span> </h6>

                                    </div> 
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                            </div>
                            <div class="col-md-12  py-10 ">
                                    <button id="btnAddInv"  data-bs-dismiss="modal" class="btn btn-solid w-auto">Lưu</button>
                                </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal end -->
     <!-- Modal ship start -->
     <div class="modal logout-modal fade" id="addShipAddress" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm địa chỉ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="theme-form" method= "POST" action="<?php echo e(route('front.profile.addshipadd')); ?>">
                            <?php echo csrf_field(); ?>    
                            <div style="padding-left:10px" class="form-row row">
                                <div class="col-md-12 py-10">
                                    <label for="email">Tên đầy đủ</label>
                                    <input type="text" name="full_name" class="form-control" id="full_name"  
                                       value="<?php echo e(old('full_name')); ?>" required >
                                </div>
                                <div class="col-md-12   py-10">
                                    <label for="review">Điện thoại</label>
                                    <input type="text" name="phone" class="form-control" id="phone"  
                                    value="<?php echo e(old('phone')); ?>"  required >
                                </div>
                                <div class="col-md-12  py-10 ">
                                    <label for="review">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" id="address" value="<?php echo e(old('address')); ?>"
                                          required  >
                                </div>
                                <div class="col-md-12  py-10 ">
                                    <input type="checkbox" name="default" value = "1"/> địa chỉ mặc định
                                </div>
                                <div class="col-md-12  py-10 ">
                                    <button type="submit" id="btnAddInv" class="btn btn-solid w-auto">Lưu</button>
                                </div>
                               
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <!-- modal ship end -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    $('.invoice_ra').on('click', function () {
        var invoice_id = $(this).attr("value");
        var inner = '<input type="hidden" name="invoice_id" value="' + invoice_id+'"  />'
            + '<div class="px-20">'+$(this).attr("data-name")+' <h6> </h6>'
            + '<h6> '+$(this).attr("data-phone")+' </h6>'
            +'<h6> '+$(this).attr("data-address")+' </h6> </div>';
        $('#invoice_div_detail').html(inner);
    });
    $('.ship_ra').on('click', function () {
        var ship_id = $(this).attr("value");
        var inner = '<input type="hidden" name="ship_id" value="' + ship_id+'"  />'
            + '<div class="px-20">'+$(this).attr("data-name")+' <h6> </h6>'
            + '<h6> '+$(this).attr("data-phone")+' </h6>'
            +'<h6> '+$(this).attr("data-address")+' </h6> </div>';
        $('#ship_div_detail').html(inner);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp1\htdocs\shoplite\resources\views/frontend/cart/checkout.blade.php ENDPATH**/ ?>