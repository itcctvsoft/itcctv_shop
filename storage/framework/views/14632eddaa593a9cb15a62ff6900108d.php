

<?php $__env->startSection('content'); ?>
    <section class="payment-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #333; font-weight: bold;">Thanh toán đơn hàng</h2>
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div class="order-details mx-auto mb-4"
                        style="max-width: 500px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px;">
                        <h4 class="text-center" style="color: #007bff; font-weight: bold;">Thông tin đơn hàng</h4>
                        <p class="text-center mb-1" style="font-size: 16px; color: #555;">Tổng số tiền:
                            <span style="color: #28a745; font-weight: bold;">
                                <?php echo e(number_format($totalAmount, 0, '.', ',')); ?> đ
                            </span>
                        </p>
                        
                        <div class="order-box">
                            <div class="title-box">
                                <div>Sản phẩm <span>Tổng</span></div>
                            </div>
                            <p>
                                <?php $tong = 0;?>
                                <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($pro->title); ?> × <?php echo e($pro->quantity); ?> : <span style="font-weight:700"><?php echo e(number_format($pro->quantity * $pro->price,0,".",",")); ?> </span></li>
                                    <?php $tong += $pro->quantity * $pro->price;?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               
                                 
                            </p>
                            
                             
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-xs-12">
                    <div  class="" >
                 
                        <div style=" width: 100%; margin: 0 auto; font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; border-radius: 10px; ">
                          
                         <div   class="option1">
                             <!-- Cách 1 -->
                             <div  >
                                 <h3 style="margin-bottom: 10px;">Cách 1: Mở app ngân hàng/ Ví và quét mã QR</h3>
                                 <div style="border: 1px solid #ddd; padding: 10px; display: inline-block; border-radius: 10px;">
                                     <img src="https://qr.sepay.vn/img?acc=221755419&bank=ACB&amount=<?php echo e($order->price); ?>&des=<?php echo e($order->code); ?>&template=compact&download=true" alt="QR Code" style="width: 200px; height: 200px;">
                                 </div>
                                
                             </div>
                            </div>
                             <!-- Cách 2 -->
                             <div class="option2" >
                                 <h3 style="margin-bottom: 10px;">Cách 2: Chuyển khoản thủ công theo thông tin</h3>
                                 <table style="width: 100%; border-collapse: collapse;">
                                     <tr>
                                         <td style="padding: 5px 0; font-weight: bold;">Ngân hàng:</td>
                                         <td style="padding: 5px 0;">ACB</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 5px 0; font-weight: bold;">Thụ hưởng:</td>
                                         <td style="padding: 5px 0;">TRUONG THI HUONG GIANG</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 5px 0; font-weight: bold;">Số tài khoản:</td>
                                         <td style="padding: 5px 0;">221755419</td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 5px 0; font-weight: bold;">Số tiền:</td>
                                         <td style="padding: 5px 0; color: #007bff; font-weight: bold;"><?php echo e(number_format( ($order->price),0,',','.')); ?></td>
                                     </tr>
                                     <tr>
                                         <td style="padding: 5px 0; font-weight: bold;">Nội dung CK:</td>
                                         <td style="padding: 5px 0; color: red; font-weight: bold;"><?php echo e($order->code); ?></td>
                                     </tr>
                                 </table>
                                 <p style="margin-top: 10px; font-size: 14px; color: #666;">
                                     Lưu ý: Vui lòng giữ nguyên nội dung chuyển khoản <strong style="color: red;"><?php echo e($order->code); ?></strong> để xác nhận thanh toán tự động.
                                 </p>
                             </div>
                         
                             
                        
                         <p id ='checkout_box' style="text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
                             Trạng thái: <span style="color: #007bff;">Chờ thanh toán...</span> 🔄
                         </p>
                         <p id ='success_pay_box' style="display:none; text-align: center; margin-top: 20px; font-size: 14px; color: #666;">
                            Trạng thái: <span style="color:green;">Đã thanh toán thành công!Hãy đến <a href=" ">Xem trạng thái đơn hàng!</span>  
                        </p>
                    </div>
                       <!-- Form Thanh Toán -->
                    <div class="option2" >
                        <h3 style="margin-bottom: 10px;">Cách 3: Dùng cổng thanh toán</h3>
                        <div class="text-center">
                            <form action="<?php echo e(route('process_vnpay_payment')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <!-- Hidden Inputs -->
                                <input type="hidden" name="order_id" value="<?php echo e($orderId); ?>">
                                <input type="hidden" name="amount" value="<?php echo e($totalAmount); ?>">
                                <input type="hidden" name="order_desc" value="<?php echo e($orderDescription); ?>">

                                <!-- Button -->
                                <button type="submit" class="btn btn-primary text-white"
                                    style="background-color: #007bff; padding: 10px 20px; font-size: 16px; border-radius: 5px; border: none;">
                                     VNPay
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Chi tiết đơn hàng -->
            
           
         
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    var pay_status = 'Unpaid';
    // $("#checkout_box").hide();
    // Hàm kiểm tra trạng thái đơn hàng
    // Sử dụng Ajax để lấy trạng thái đơn hàng. Nếu thanh toán thành công thì hiển thị Box đã thanh toán thành công, ẩn box checkout
    function check_payment_status() {
        if(pay_status == 'Unpaid') {
             $.ajax({
                  type: "POST",
                  data: {code: '<?php echo e($order->code); ?>',id:<?php echo e($order->id); ?> },
                  url: "<?php echo e(route('payment.kiemtradon') .'?_token='.csrf_token()); ?>",
                  dataType:"json",
                  success: function(data){
                      if(data.payment_status == "Paid") {
                          $("#checkout_box").hide();
                          $("#success_pay_box").show();
                          pay_status = 'Paid';
                      }
                  }
                });
            }
        }
      //Kiểm tra trạng thái đơn hàng 1 giây một lần
      setInterval(check_payment_status, 1000);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/frontend/cart/online_payment.blade.php ENDPATH**/ ?>