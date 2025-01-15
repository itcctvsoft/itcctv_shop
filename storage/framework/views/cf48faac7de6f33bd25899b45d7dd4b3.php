 <?php
 
 $setting = \App\Models\SettingDetail::find(1);
 $user = auth()->user();
 if ($user) {
     $pro_carts = \DB::table('shoping_carts as c')
         ->join('products as d', 'c.product_id', '=', 'd.id')
         ->where('c.user_id', $user->id)
         ->where('d.status', 'active')
         ->select('c.quantity', 'd.*')
         ->get();
 } else {
     $pro_carts = [];
 }
 $cart_size = count($pro_carts);
 ?>
 
 <?php $__env->startSection('head_css'); ?>
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('content'); ?>
     <?php echo $__env->make('frontend_tp.layouts.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     <section class="wrapper !bg-[#ffffff]">
         <div class="container pt-14 xl:pt-[4.5rem] lg:pt-[4.5rem] md:pt-[4.5rem] pb-[4.5rem] xl:pb-24 lg:pb-24 md:pb-24">
             <form method="POST" action="<?php echo e(route('front.shopingcart.order')); ?>">
                 <?php echo csrf_field(); ?>
                 <div class="flex flex-wrap mx-[-15px] md:mx-[-20px] xl:mx-[-35px] mt-[-70px]">

                     <div
                         class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] xl:px-[35px] lg:px-[20px] md:px-[20px] px-[15px] mt-[70px] max-w-full">
                         <div class="row check-out">
                             <h2>Địa chỉ nhận hóa đơn</h2>
                             <div id="invoice_div" class="form-group col-md-12 col-sm-12 col-xs-12">
                                 <div id="invoice_div_detail">
                                     <?php if(isset($invoiceaddress)): ?>
                                         <input type="hidden" name="invoice_id" value="<?php echo e($invoiceaddress->id); ?>" />
                                         <div style="padding-left:30px">
                                             <h6><?php echo e($invoiceaddress->full_name); ?></h6>
                                             <h6><?php echo e($invoiceaddress->phone); ?></h6>
                                             <h6><?php echo e($invoiceaddress->address); ?></h6>
                                         </div>
                                     <?php endif; ?>
                                 </div>
                                 <a href="javascript:void(0)" data-bs-target="#addInvoiceAddress" data-bs-toggle="modal"
                                     class="bottom_btn">Thêm</a> |
                                 <a href="javascript:void(0)" data-bs-target="#changeInvoiceAddress" data-bs-toggle="modal"
                                     class="bottom_btn">Chọn địa chỉ khác</a>
                             </div>

                             <h2>Địa chỉ giao hàng</h2>
                             <div id="ship_div" class="form-group col-md-12 col-sm-12 col-xs-12">
                                 <div id="ship_div_detail">
                                     <?php if(isset($shipaddress)): ?>
                                         <input type="hidden" name="ship_id" value="<?php echo e($shipaddress->id); ?>" />
                                         <div style="padding-left:30px">
                                             <h6><?php echo e($shipaddress->full_name); ?></h6>
                                             <h6><?php echo e($shipaddress->phone); ?></h6>
                                             <h6><?php echo e($shipaddress->address); ?></h6>
                                         </div>
                                     <?php endif; ?>
                                 </div>
                                 <a href="javascript:void(0)" data-bs-target="#addShipAddress" data-bs-toggle="modal"
                                     class="bottom_btn">Thêm</a> |
                                 <a href="javascript:void(0)" data-bs-target="#changeShipAddress" data-bs-toggle="modal"
                                     class="bottom_btn">Chọn địa chỉ nhận hàng</a>
                             </div>

                             <h2>Phương thức thanh toán</h2>
                             <div id="payment_method" class="form-group col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="payment_method" id="cod"
                                         value="cod" checked>
                                     <label class="form-check-label" for="cod">Thanh toán sau khi nhận hàng
                                         (COD)</label>
                                 </div>
                                 <div class="form-check">
                                     <input class="form-check-input" type="radio" name="payment_method" id="online"
                                         value="online">
                                     <label class="form-check-label" for="online">Thanh toán online</label>
                                 </div>
                             </div>
                         </div>
                     </div>

                     <div
                         class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] xl:px-[35px] lg:px-[20px] md:px-[20px] px-[15px] mt-[70px] max-w-full">
                         <h3 class="!mb-4">Đơn hàng</h3>
                         <div class="shopping-cart mb-7">
                             <?php $tong = 0; ?>
                             <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php $photos = explode(',', $pro->photo); ?>
                                 <div class="shopping-cart-item flex justify-between mb-4">
                                     <div class="flex flex-row items-center">
                                         <figure class="!rounded-[.4rem] !w-[7rem]">
                                             <a href="<?php echo e(route('front.product.view', $pro->slug)); ?>">
                                                 <img class="!rounded-[.4rem]" src="<?php echo e($photos[0]); ?>"
                                                     style="width:90px;height:100px;" alt="<?php echo e($pro->title); ?>">
                                             </a>
                                         </figure>
                                         <div class="w-full ml-4">
                                             <h3 class="post-title h6 !leading-[1.35] !mb-1">
                                                 <a href="<?php echo e(route('front.product.view', $pro->slug)); ?>"
                                                     class="title_color">
                                                     <?php echo e($pro->title); ?>

                                                 </a>
                                             </h3>
                                         </div>
                                     </div>
                                     <div class="ml-2 flex items-center">
                                         <p class="price text-[0.7rem]"><span
                                                 class="amount"><?php echo e(number_format($pro->price, 0, '.', ',')); ?></span></p>
                                     </div>
                                 </div>
                                 <?php $tong += $pro->quantity * $pro->price; ?>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>

                         <hr class="!my-4">
                         <h3 class="!mb-2">Chi phí vận chuyển</h3>
                         <div class="!mb-5">
                             <label class="form-check-label" for="express">Thông báo sau cho khách hàng</label>
                         </div>

                         <hr class="!my-4">
                         <div id="payment_method_detail" class="!mb-5">
                             <label class="form-check-label"><strong>Phương thức thanh toán:</strong></label>
                             <p id="selected_payment_method" class="title_color font-bold !m-0">Thanh toán sau khi nhận hàng
                                 (COD)</p>
                         </div>

                         <div class="table-responsive">
                             <table class="table table-order">
                                 <tbody>
                                     <tr>
                                         <td class="!pl-0"><strong class="title_color">Tổng</strong></td>
                                         <td class="!pr-0 text-right">
                                             <p class="price title_color font-bold !m-0">
                                                 <?php echo e(number_format($tong, 0, '.', ',')); ?> đ</p>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>

                             <button type="submit"
                                 class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] rounded w-full mt-4 hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Đặt
                                 hàng</button>
                         </div>
                     </div>
                 </div>
             </form>
         </div>
     </section>
     <!--  -->

     <div class="modal fade" id="addInvoiceAddress" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered modal-sm">
             <div class="modal-content !text-center">
                 <div class="modal-body relative flex-auto pt-[2.5rem] pr-[2.5rem] pb-[2.5rem] pl-[2.5rem]">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     <h2 class="mb-3 text-left">Thêm địa chỉ</h2>
                     <form class="text-left mb-3" method= "POST" action="<?php echo e(route('front.profile.addinvoiceadd')); ?>">
                         <?php echo csrf_field(); ?>
                         <div class="relative mb-4">
                             <label for="email">Tên đầy đủ</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="full_name" id="full_name" value="<?php echo e(old('full_name')); ?>">
                         </div>
                         <div class="relative mb-4">
                             <label for="review">Điện thoại</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="phone" id="phone" value="<?php echo e(old('phone')); ?>">
                         </div>
                         <div class="relative mb-4">
                             <label for="review">Địa chỉ</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="address" id="address" value="<?php echo e(old('address')); ?>">

                         </div>

                         <div class="relative mb-4">
                             <div class="form-check block min-h-[1.36rem] mb-0.5 pl-[1.55rem]">
                                 <input class="form-check-input" type="checkbox" value="1" name="default"
                                     checked="">
                                 <label class="form-check-label" for="flexCheckChecked"> Địa chỉ mặc định </label>
                             </div>
                         </div>
                         <button type="submit"
                             class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] btn-login w-full mb-2">
                             Lưu</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!--/.modal -->

     <div class="modal fade" id="addShipAddress" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered modal-sm">
             <div class="modal-content !text-center">
                 <div class="modal-body relative flex-auto pt-[2.5rem] pr-[2.5rem] pb-[2.5rem] pl-[2.5rem]">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     <h2 class="mb-3 text-left">Thêm địa chỉ</h2>
                     <form id="addAddressForm" class="text-left mb-3" method= "POST"
                         action="<?php echo e(route('front.profile.addshipadd')); ?>">
                         <?php echo csrf_field(); ?>
                         <div class="relative mb-4">
                             <label for="email">Tên đầy đủ</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="full_name" id="full_name" value="<?php echo e(old('full_name')); ?>">
                         </div>
                         <div class="relative mb-4">
                             <label for="review">Điện thoại</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="phone" id="phone" value="<?php echo e(old('phone')); ?>">
                         </div>
                         <div class="relative mb-4">
                             <label for="review">Địa chỉ</label>
                             <input
                                 class=" form-control  relative block w-full text-[.75rem] font-medium text-[#60697b] bg-[#fefefe] bg-clip-padding border shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] border-solid border-[rgba(8,60,130,0.07)] transition-[border-color] duration-[0.15s] ease-in-out focus:text-[#60697b] focus:bg-[rgba(255,255,255,.03)] focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] focus:!border-[rgba(63,120,224,0.5)] focus-visible:!border-[rgba(63,120,224,0.5)] focus-visible:!outline-0 placeholder:text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] leading-[1.25]"
                                 name="address" id="address" value="<?php echo e(old('address')); ?>">

                         </div>

                         <div class="relative mb-4">
                             <div class="form-check block min-h-[1.36rem] mb-0.5 pl-[1.55rem]">
                                 <input class="form-check-input" type="checkbox" value="1" name="default"
                                     checked="">
                                 <label class="form-check-label" for="flexCheckChecked"> Địa chỉ mặc định </label>
                             </div>
                         </div>
                         <button type="submit"
                             class="btn btn-primary text-white !bg-[#3f78e0] border-[#3f78e0] hover:text-white hover:bg-[#3f78e0] hover:border-[#3f78e0] focus:shadow-[rgba(92,140,229,1)] active:text-white active:bg-[#3f78e0] active:border-[#3f78e0] disabled:text-white disabled:bg-[#3f78e0] disabled:border-[#3f78e0] !rounded-[50rem] btn-login w-full mb-2">
                             Lưu</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!--/.modal -->

     <div class="modal fade" id="changeInvoiceAddress" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered modal-sm">
             <div class="modal-content !text-center">
                 <div class="modal-body relative flex-auto pt-[2.5rem] pr-[2.5rem] pb-[2.5rem] pl-[2.5rem]">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     <h2 class="mb-3 text-left">Chọn địa chỉ nhận hóa đơn</h2>
                     <?php $i = 0; ?>
                     <?php $__currentLoopData = $addressbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <div class="form-check block min-h-[1.36rem] mb-0.5" style="border-bottom:1px solid">
                             <input class="invoice_ra form-check-input" type="radio" id="ra<?php echo e($i); ?>}"
                                 data-name="<?php echo e($address->full_name); ?>" data-phone="<?php echo e($address->phone); ?>"
                                 data-address=" <?php echo e($address->address); ?>" class="invoice_ra" name="invoice_id"
                                 value="<?php echo e($address->id); ?>">
                             <label class="form-check-label" for="ra<?php echo e($i); ?>}">

                                 <div>
                                     <h6> Tên: <span> <?php echo e($address->full_name); ?></span> </h6>
                                     <h6> Điện thoại: <span> <?php echo e($address->phone); ?></span> </h6>
                                     <h6> Địa chỉ: <span> <?php echo e($address->address); ?></span> </h6>
                                 </div>
                             </label>
                             <?php $i++; ?>
                         </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 </div>
             </div>
         </div>
     </div>
     <!--/.modal -->

     <div class="modal fade" id="changeShipAddress" tabindex="-1">
         <div class="modal-dialog modal-dialog-centered modal-sm">
             <div class="modal-content !text-center">
                 <div class="modal-body relative flex-auto pt-[2.5rem] pr-[2.5rem] pb-[2.5rem] pl-[2.5rem]">
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     <h2 class="mb-3 text-left">Chọn địa chỉ nhận hóa đơn</h2>
                     <?php $i = 0; ?>
                     <?php $__currentLoopData = $addressbooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <div class="form-check block min-h-[1.36rem] mb-0.5" style="border-bottom:1px solid">
                             <input class="ship_ra form-check-input" type="radio" id="ra<?php echo e($i); ?>}"
                                 data-name="<?php echo e($address->full_name); ?>" data-phone="<?php echo e($address->phone); ?>"
                                 data-address=" <?php echo e($address->address); ?>" class="invoice_ra" name="invoice_id"
                                 value="<?php echo e($address->id); ?>">
                             <label class="form-check-label" for="ra<?php echo e($i); ?>}">

                                 <div>
                                     <h6> Tên: <span> <?php echo e($address->full_name); ?></span> </h6>
                                     <h6> Điện thoại: <span> <?php echo e($address->phone); ?></span> </h6>
                                     <h6> Địa chỉ: <span> <?php echo e($address->address); ?></span> </h6>
                                 </div>
                             </label>
                             <?php $i++; ?>
                         </div>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 </div>
             </div>
         </div>
     </div>

     <!--/.modal -->
 <?php $__env->stopSection(); ?>
 <?php $__env->startSection('scripts'); ?>
     <script>
         $(document).ready(function() {
             // Cập nhật địa chỉ hóa đơn
             $('.invoice_ra').on('click', function() {
                 var invoice_id = $(this).val();
                 var name = $(this).data("name");
                 var phone = $(this).data("phone");
                 var address = $(this).data("address");

                 var inner = `
                    <input type="hidden" name="invoice_id" value="${invoice_id}" />
                    <div class="px-20">
                        <h6>${name}</h6>
                        <h6>${phone}</h6>
                        <h6>${address}</h6>
                    </div>
                `;
                 $('#invoice_div_detail').html(inner);
                 $('#changeInvoiceAddress').modal('hide');
             });

             // Cập nhật địa chỉ giao hàng
             $(document).on('click', '.ship_ra', function() {
                 var ship_id = $(this).val();
                 var name = $(this).data("name");
                 var phone = $(this).data("phone");
                 var address = $(this).data("address");

                 var inner = `
                    <input type="hidden" name="ship_id" value="${ship_id}" />
                    <div class="px-20">
                        <h6>${name}</h6>
                        <h6>${phone}</h6>
                        <h6>${address}</h6>
                    </div>
                `;
                 $('#ship_div_detail').html(inner);
                 $('#changeShipAddress').modal('hide');
             });



             // Cập nhật phương thức thanh toán
             $('input[name="payment_method"]').on('click', function() {
                 var payment_method = $(this).val();
                 var payment_text = payment_method === 'cod' ?
                     'Thanh toán sau khi nhận hàng (COD)' :
                     'Thanh toán online';

                 var inner = `
            <input type="hidden" name="payment_method" value="${payment_method}" />
            <div class="px-20">
                <h6>Phương thức thanh toán: ${payment_text}</h6>
            </div>
        `;
                 $('#payment_method_detail').html(inner);
             });

             // Xử lý nút đặt hàng
             $('#addAddressForm').on('submit', function(e) {
                 e.preventDefault(); // Ngăn chặn form submit mặc định

                 var payment_method = $('input[name="payment_method"]:checked').val();
                 var shipAddress = $('input[name="ship_id"]').val();
                 var invoiceAddress = $('input[name="invoice_id"]').val();

                 // Kiểm tra xem các trường có giá trị hay không
                 if (!shipAddress || !invoiceAddress) {
                     Swal.fire({
                         title: 'Thông báo!',
                         text: 'Vui lòng chọn địa chỉ giao hàng và địa chỉ hóa đơn trước khi đặt hàng.',
                         icon: 'warning',
                         imageUrl: 'https://i.pinimg.com/originals/8a/e6/7f/8ae67f6fdd49bd3ae686328de6a28b34.gif',
                         imageWidth: 150,
                         imageHeight: 150,
                         imageAlt: 'Lỗi địa chỉ',
                         backdrop: 'rgba(0, 0, 0, 0.4)',
                         confirmButtonText: 'OK',
                     });
                     return;
                 }

                 // Thêm các trường thông tin hóa đơn nếu cần
                 var fullName = $('input[name="full_name"]').val();
                 var phone = $('input[name="phone"]').val();
                 var address = $('input[name="address"]').val();

                 if (!fullName || !phone || !address) {
                     Swal.fire({
                         title: 'Thông báo!',
                         text: 'Vui lòng nhập đầy đủ thông tin địa chỉ giao hàng.',
                         icon: 'warning',
                         confirmButtonText: 'OK',
                     });
                     return;
                 }

                 // Gửi yêu cầu AJAX
                 if (payment_method === 'online') {
                     Swal.fire({
                         title: 'Đang xử lý đơn hàng!',
                         text: 'Vui lòng chờ trong giây lát...',
                         icon: 'info',
                         confirmButtonText: 'OK',
                     });

                     $.ajax({
                         url: "<?php echo e(route('front.shopingcart.order')); ?>",
                         method: 'POST',
                         data: {
                             _token: "<?php echo e(csrf_token()); ?>",
                             payment_method: payment_method,
                             ship_id: shipAddress,
                             invoice_id: invoiceAddress,
                             full_name: fullName,
                             phone: phone,
                             address: address,
                         },
                         success: function(response) {
                             if (response.status === 'success') {
                                 var form = $('<form>', {
                                     method: 'POST',
                                     action: "<?php echo e(route('payment.online')); ?>",
                                 });

                                 form.append($('<input>', {
                                     type: 'hidden',
                                     name: '_token',
                                     value: "<?php echo e(csrf_token()); ?>",
                                 }));
                                 form.append($('<input>', {
                                     type: 'hidden',
                                     name: 'order_id',
                                     value: response.order_id,
                                 }));
                                 form.append($('<input>', {
                                     type: 'hidden',
                                     name: 'amount',
                                     value: response.amount,
                                 }));
                                 form.append($('<input>', {
                                     type: 'hidden',
                                     name: 'order_desc',
                                     value: response.order_desc,
                                 }));

                                 $('body').append(form);
                                 form.submit();
                             } else {
                                 Swal.fire({
                                     title: 'Lỗi!',
                                     text: 'Đã xảy ra lỗi khi tạo đơn hàng. Vui lòng thử lại.',
                                     icon: 'error',
                                     confirmButtonText: 'OK',
                                 });
                             }
                         },
                         error: function() {
                             Swal.fire({
                                 title: 'Lỗi hệ thống!',
                                 text: 'Không thể xử lý đơn hàng. Vui lòng thử lại sau.',
                                 icon: 'error',
                                 confirmButtonText: 'OK',
                             });
                         },
                     });
                 } else {
                     $('form').submit();
                 }
             });

         });
     </script>
 <?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend_tp.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Workspace\KhoaLuan_2024\shop-main\resources\views/frontend_tp/cart/checkout.blade.php ENDPATH**/ ?>