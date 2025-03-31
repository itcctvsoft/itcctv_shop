
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <!-- left side bar -->
                <?php
                    $menu = 6;
                    ?>

                <?php echo $__env->make('frontend.profile.profilemenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <!-- left side bar -->
                  <!-- right side content -->
                <div class="col-lg-9">
                    <div class="faq-content tab-content" id="top-tabContent">
                        <h4> DANH SÁCH ĐƠN HÀNG HOÀN THÀNH</h4>
                        <div class="report-table">
                            <div class="report-header">
                                <div class="report-cell text-center">Thời gian</div>
                                <div class="report-cell">Giá</div>
                                
                                <div class="report-cell text-center">Trạng thái</div>
                            </div>
                            <?php $__currentLoopData = $wouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $classname = ($order->status =='Paid' ) ? "text-danger" : "text-primary";
                                ?>
                            <?php
                            $ptotal = 0;
                            $ptotal = Number_format($order->amount,0,'.',',');
                            ?>
                            <div class="report-row"  onclick="toggleDetails(<?php echo e($order->id); ?>)">
                                <div class="report-cell"> <?php echo e($order->created_at); ?></div>
                                <div class="report-cell"> <?php echo e($order->final_amount); ?></div>
                                <div class="report-cell <?php echo e($classname); ?>"> <?php echo e($order->status); ?> </div>
                            </div>
                               <!-- Chi tiết phiếu (ẩn mặc định) -->
                            <div id="details-<?php echo e($order->id); ?>" class="report-details hidden">
                                <div class="detail-content">
                                    <p>
                                        <?php
                                        $html = 
                                        ' <div class="details-container">
                                                <!-- Cột 1: Thông tin giao dịch -->
                                                <div class="details-column one">
                                                    <p class="'. $classname .'"><strong>Trạng thái:</strong> '.$order->status .'</p>
                                                    <p><strong>Thời gian:</strong> '.$order->created_at .'</p>
                                                    <p><strong>Số tiền:</strong>  '. number_format($order->final_amount, 0, '.', ',') .' VND</p>
       
                                                </div>
                                                            <!-- Cột 2: Danh sách sản phẩm -->
                                                <div class="details-column two">
                                                    <strong>Chi tiết sản phẩm:</strong>
                                                     <div class="product-list">
                                                        <!-- Tiêu đề cột -->
                                                        <div class="product-item proheader">
                                                            <div class="product-name">Tên sản phẩm</div>
                                                            <div class="product-quantity">Số lượng</div>
                                                            <div class="product-price">Giá</div>
                                                        </div>';
                                                  
                                                    $details = $order->details();
                                                   
                                                    foreach ($details    as $detail)
                                                    {
                                                            $html .= ' <div class="product-item">
                                                                            <div class="product-name">' . $detail->title.
                                                                            '</div>
                                                                        <div class="product-quantity">  '.$detail->quantity.
                                                                        '</div>
                                                                        <div class="product-price">'.number_format($detail->price, 0, '.', ',').
                                                                        '</div>
                                                                    </div>';
                                                                    if ($detail->series) {
                                                                        $html .= 
                                                                        '<div class="product-series">
                                                                            <span>Series: '.$detail->series.'</span>
                                                                        </div>';
                                                                    }                
                                                    }
                                                     
                                                    $html .= 
                                                    '</div>
                                                </div>
                                            </div>';
                                                echo $html;
                                            ?>
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
                              <?php echo e($wouts->links('vendor.pagination.tailwind')); ?>

                          </nav>
                        </div>
                    </div>
                </div>
                 <!-- right side content -->
            </div>
        </div>
    </section>
    
  
 
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
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
<?php echo $__env->make('frontend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/frontend/profile/warehouseout.blade.php ENDPATH**/ ?>