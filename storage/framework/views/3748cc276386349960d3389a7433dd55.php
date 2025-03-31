
<?php $__env->startSection('content'); ?>

<div class="content">
<?php echo $__env->make('backend.layouts.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <h2 class="intro-y text-lg font-medium mt-10">
        Danh sách tồn kho  
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        
        

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="">SẢN PHẨM</th>
                        <th class="text-center ">KHO</th>
                        <th class="text-center ">SỐ LƯỢNG</th>
                        <th class="text-center ">GIÁ VỐN</th>
                        <th class="text-center ">GIÁ BÁN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="intro-x">
                        <td>
                        <a href="<?php echo e(route('product.show',$product->id)); ?>"> <?php echo e($product->title); ?>  </a>
                        </td>
                        <td>
                             <?php echo e(\App\Models\Warehouse::where('id',$inventory->wh_id)->value('title')); ?>  
                        </td>
                        <td class='text-center'>
                             <?php echo e($inventory->quantity); ?>  
                        </td>
                        <td class='text-center'>
                            <?php echo e(number_format($product->price_avg,0,',','.')); ?>

                        </td>
                        <td class='text-center'>
                            <?php echo e(number_format($product->price_out,0,',','.')); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">SERIES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $series; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="intro-x">
                        <td>
                             <?php echo e($seri->seri); ?>  
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">Mã phiếu</th>
                        <th class="whitespace-nowrap">Nhà cung cấp</th>
                        <th class="whitespace-nowrap">Kho</th>
                        <th class="whitespace-nowrap">Số lượng</th>
                        <th class="whitespace-nowrap">Đơn giá</th>
                        <th class="whitespace-nowrap">Tồn kho</th>
                        <th class="whitespace-nowrap">Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $detail_ins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail_in): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(/*$detail_in->doc_id != 0*/1): ?>
                            <?php
                            // dd($detail_ins);
                                // $class_name = $detail_in->quantity < 0?'text-danger':'text-primary';
                                $class_name = $detail_in->operation < 0?'text-danger':'text-primary';
                            ?>
                            <tr class="intro-x <?php echo e($class_name); ?>">
                                <td> 
                                    <?php
                                    $tengd = \App\Http\Controllers\HelpController::loai_giaodich($detail_in->doc_type);
                                    $url = \App\Http\Controllers\HelpController::url_giaodich($detail_in->doc_type,$detail_in->doc_id);
                                    // dd($tengd,$url);
                                 
 
                                    ?>
                                      <a href="<?php echo e($url); ?>"><?php echo e($tengd); ?></a> 
                                </td>
                                <td>
                                
                                    <?php if($detail_in->doc_type=="wi" || $detail_in->doc_type=="wo"
                                            ||$detail_in->doc_type=="din"  ||$detail_in->doc_type=="wir"  ||$detail_in->doc_type=="wor" || $detail_in->doc_type=="dout"): ?>
                                    <?php
                                    // echo $detail_in->doc_type .'<br/>';
                                    $document = $detail_in->document();
                                    // if( $document)
                                    //     echo $document->id .'<br/>';
                                    // continue;
                                    if (!$document)
                                    continue;
                                    $url_user ='';
                                    $url_name = '';
                                    if ( $document->user)
                                    {
                                        $url_user = route('user.showsup',$document->user->id);
                                        $url_name = $document->user->full_name;
                                    }  
                                    ?> 
                                    <a href="<?php echo e($url_user); ?>">  <?php echo e($url_name); ?>  </a>
                                    <?php endif; ?>
                                    
                                </td>
                                <td>
                                    <?php echo e($detail_in->warehouse->title); ?>  
                                </td>
                                <td>
                                    <?php echo e($detail_in->quantity); ?>  
                                </td>
                                <td>
                                    <?php echo e($detail_in->price); ?>  
                                </td>
                                <td>
                                    <?php echo e($detail_in->prebalance  + $detail_in->quantity*$detail_in->operation); ?>  
                                </td>
                                <td>
                                    <?php echo e($detail_in->created_at); ?>

                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <?php echo e($detail_ins->links('vendor.pagination.tailwind')); ?>

            </nav>
           
        </div>
       
        
    </div>
    <!-- END: HTML Table Data -->
       
</div>
<!-- end content -->
  
   
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('backend/assets/vendor/js/bootstrap-switch-button.min.js')); ?>"></script>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
     
</script>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\itcctv_shop\resources\views/backend/inventories/series.blade.php ENDPATH**/ ?>