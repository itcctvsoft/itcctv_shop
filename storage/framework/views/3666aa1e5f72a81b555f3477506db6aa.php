
<?php $__env->startSection('css'); ?>
    
<style>
    .report-table {
      margin-top:20px;
        display: flex;
        flex-direction: column;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .report-header {
        display: flex;
        font-weight: bold;
        background-color: #f8f9fa;
        padding: 12px 16px;
        border-bottom: 2px solid #e0e0e0;
    }
    
    .report-row {
        display: flex;
        padding: 12px 16px;
        border-bottom: 1px solid #e0e0e0;
        background-color: #fdfdfd;
        cursor: pointer;
    }
    
    .report-row:nth-child(even) {
        background-color: #f8f8f8;
    }
    
    .report-cell {
        flex: 1;
        text-align: left;
        padding: 4px 8px;
    }
    
    /* Hiện chi tiết khi mở */
    .hidden {
        display: none;
    }
    
     /* Chi tiết giao dịch */
    .report-details {
       
        padding: 15px;
        background-color: #ffffff;
        border-bottom: 1px solid #ddd;
    }
    
    
    /* Layout 2 cột */
    .details-container {
        display: flex;
        gap: 20px;
    }
    .details-column {
      flex: 1;
    }
    .details-column p{
      line-height: 1.9;
    }
    .details-column.one {
        flex: 1;
    }
    
    .details-column.two {
        flex: 2;
    }
    /* Khi màn hình nhỏ, cột sẽ xếp thành 2 hàng */
    @media screen and (max-width: 768px) {
        .details-container {
            flex-direction: column; /* Chuyển thành dạng cột */
        }
        
        .details-column {
            width: 100%; /* Mỗi cột chiếm toàn bộ chiều rộng */
        }
    }
    /* Hiển thị khi mở */
    .show {
        display: block;
    }
    
    .product-list {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr; /* Cột 1 chiếm 2 phần, cột 2 & 3 chiếm 1 phần */
        gap: 10px;
    }
    
    .product-item {
        display: contents; /* Giữ bố cục lưới mà không bọc từng dòng */
    }
    
    .product-name, .product-quantity, .product-price {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    
    .proheader {
        font-weight: bold;
        background: #f5f5f5;
        border-bottom: 2px solid #000;
    }
    /* Dòng series kéo dài cả 3 cột */
    .product-series {
        grid-column: 1 / span 3; /* Trải dài cả 3 cột */
        padding: 8px;
        font-style: italic;
        color: #555;
        background: #f9f9f9;
        border-bottom: 1px solid #ddd;
    }
      </style>
      <link rel="stylesheet" href="https://itcctv-soft.s3.us-east-1.amazonaws.com/cdn/mydatepicker.css" > 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <!-- left side bar -->
                <?php
                    $menu = 7;
                    ?>

                <?php echo $__env->make('frontend.profile.profilemenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <!-- left side bar -->
                  <!-- right side content -->
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <h4> DANH SÁCH THU CHI</h4>
                        <div class="grid grid-cols-12  ">
                            <div class=" ">
                                <div class="row  ">
                                    <div class='col-lg-9  '> 
                                        <div class= "mt-3">
                                            <label class="font-medium"> Đối tác: </label>
                                            <?php echo e($user->full_name); ?>

                                        </div>
                                        <div class= "mt-3">
                                            <label class="font-medium"> Tổng công nợ: </label>
                                            <span class="<?php echo e($user->budget > 0?'text-danger':'text-success'); ?>"><?php echo e(Number_format($user->budget,0,'.',',')); ?></span>
                                            <br/><span class="form-help"> (-) đối tác nợ tiền , (+) cửa hàng nợ tiền </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-3  ">
                                        
                                        <a href="<?php echo e(route('front.profile.paymentonline' )); ?>" class="btn btn-success  " style="color:white">Trả tiền công nợ</a>
                                
                                    </div>
                                </div>
                                <div class="intro-y flex items-center mt-8" style="margin-top:20px">
                                    <h4 class="text-lg font-medium mr-auto">
                                        Chi tiết tài khoản đối tác
                                    </h4>
                                </div>
                
                                <div class="row  flex flex-col ">
                                    <div class='col-lg-9  '> 
                                        <form action="<?php echo e(route('front.profile.viewsuptrans' )); ?>" method="get" id="filterForm" class="xl:flex sm:mr-auto">
                                            <!-- <?php echo csrf_field(); ?> -->
                                            <div class="sm:flex items-center sm:mr-4">
                                                <label style="min-width:80px" class="w-12 flex-none xl:w-auto xl:flex-initial mr-5">Lọc: </label>
                                                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                                    <input type="text" id="date1" name="date1" placeholder="Chọn ngày">
                                                    -
                                                    <input type="text" id="date2" name="date2" placeholder="Chọn ngày">
                                                    <button id="btn_tim" type="submit" class="btn btn-primary w-full sm:w-16">Chọn</button>
                                                </div>
                                               
                                            </div>
                                        </form>
                                    </div>
                                    <div class='col-lg-3  '> 
                                    <!-- Khi bấm vào Xuất Excel, dữ liệu ngày cũng được gửi -->
                                        <a href="#" class="btn btn-success" onclick="submitExport()">Xuất Excel</a>
                                    </div>
                                </div>
                                <div class=" timeline intro-y  ">
                                    <div class="report-table">
                                        <div class="report-header">
                                            <div class="report-cell text-center">Thời gian</div>
                                            <div class="report-cell">Loại</div>
                                            <div class="report-cell">Tăng</div>
                                            <div class="report-cell">Giảm</div>
                                            <div class="report-cell text-center">Số dư</div>
                                        </div>
                                        <?php $__currentLoopData = $suptrans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $classname = ($sp->total < 0) ? "text-danger" : "text-primary";
                                                ?>
                                            <?php
                                            $str_route = "";
                                            $status = "";
                                            $loai = "";
                                            $doc_notpaid= 0;
                                            $ptotal = 0;
                                            $stotal = 0;
                                            if($sp->operation > 0)
                                                $ptotal = Number_format($sp->amount,0,'.',',');
                                            else
                                                $stotal = Number_format($sp->amount,0,'.',',');
                
                                            
                                            
                                            ?>
                                            <div class="report-row"  onclick="toggleDetails(<?php echo e($sp->id); ?>)">
                                                <div class="report-cell"> <?php echo e($sp->created_at); ?></div>
                                                <div class="report-cell"> <?php echo e(\App\Http\Controllers\HelpController::loai_giaodich($sp->doc_type)); ?></div>
                                                <div class="report-cell"> <?php echo e($ptotal); ?> </div>
                                                <div class="report-cell"> <?php echo e($stotal); ?> </div>
                                                <div class="report-cell <?php echo e($classname); ?>"> <?php echo e(number_format($sp->total, 0, '.', ',')); ?> </div>
                                            </div>
                                            <!-- Chi tiết phiếu (ẩn mặc định) -->
                                            <div id="details-<?php echo e($sp->id); ?>" class="report-details hidden">
                                                <div class="detail-content">
                                                    
                                                    <p>
                                                        
                                                        <?php echo \App\Http\Controllers\HelpController::html_chitietgd($sp->doc_type,$sp->document()); ?>

                                                        
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                
                                    <div style='clear:both' class="  ">
                                        &nbsp;
                                    </div>
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        <nav class="w-full sm:w-auto sm:mr-auto">
                                            <?php echo e($suptrans->links('vendor.pagination.tailwind')); ?>

                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- right side content -->
            </div>
        </div>
    </section>
    
  
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://itcctv-soft.s3.us-east-1.amazonaws.com/cdn/mydatepicker.js"></script> 
<script>
    const myDatePicker =  new MyDatepicker("#date1");
     myDatePicker.setDefaultDate("<?php echo e($date1); ?>");
     const myDatePicker2 =  new MyDatepicker("#date2");
     myDatePicker2.setDefaultDate("<?php echo e($date2); ?>");
  </script> 
<script>
    function toggleDetails(id) {
        var detailRow = document.getElementById("details-" + id);
        if (detailRow.classList.contains("hidden")) {
            detailRow.classList.remove("hidden");
        } else {
            detailRow.classList.add("hidden");
        }
    }
</script>
<script>
    function submitExport() {
        let form = document.getElementById("filterForm");

        // Chuyển action để xuất Excel
        form.action = "<?php echo e(route('user.expsup', $user->id)); ?>";

        // Gửi form
        form.submit();
    }
</script>
<script>
    function add_notify(msg, status)
    {
        $.notify({
                    icon: 'fa fa-check',
                    title: status?'Thành Công!':'Thất bại!',
                    message:  msg,
                }, {
                    element: 'body',
                    position: null,
                    type: status?"info":"warning",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 2000,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        '</div>'
                });
    }

    $('.invoice_ra').on('click', function () {
        var invoice_id = $(this).attr("value");
        $.ajax({
            type: 'GET',
            url: '<?php echo e(route("front.address.setinvoice")); ?>',
            data: {
                id: invoice_id,
            },
            success: function(data) {
                add_notify(data.msg,data.status);
            },
        }); 
    });

    $('.ship_ra').on('click', function () {
        var ship_id = $(this).attr("value");
        $.ajax({
            type: 'GET',
            url: '<?php echo e(route("front.address.setship")); ?>',
            data: {
                id: ship_id,
            },
            success: function(data) {
                add_notify(data.msg,data.status);
            },
        }); 
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/frontend/profile/suptrans.blade.php ENDPATH**/ ?>