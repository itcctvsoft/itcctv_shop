@extends('backend.layouts.master')
@section('content')

<div class="content">
@include('backend.layouts.notification')
    <h2 class="intro-y text-lg font-medium mt-10">
        Danh sách tồn kho  
    </h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        
        

        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">SẢN PHẨM</th>
                        <th class="text-center whitespace-nowrap">KHO</th>
                        <th class="text-center whitespace-nowrap">SỐ LƯỢNG</th>
                        <th class="text-center whitespace-nowrap">Giá vốn</th>
                        <th class="text-center whitespace-nowrap">Giá bán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory )
                    <tr class="intro-x">
                        <td>
                            <a href="{{route('product.show',$product->id)}}"> {{$product->title }}  </a>
                        </td>
                        <td>
                             {{\App\Models\Warehouse::where('id',$inventory->wh_id)->value('title')}}  
                        </td>
                        <td class='text-center'>
                             {{ $inventory->quantity}}  
                        </td>
                        <td class='text-center'>
                            {{number_format($product->price_avg,0,',','.')}}
                        </td>
                        <td class='text-center'>
                            {{number_format($product->price_out,0,',','.')}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
            <table class="table table-report -mt-2">
                <thead>
                    <tr>
                        <td class="whitespace-nowrap">SERIES</td>
                     
                        <td> Kho </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($series as $seri )
                    <tr class="intro-x">
                        <td>
                             {{$seri->seri }}  
                        </td>
                        <td>
                             {{$seri->wh_title }}  
                        </td>
                    </tr>
                    @endforeach
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
                    @foreach ($detail_ins as $detail_in )
                    @if(/*$detail_in->doc_id != 0*/1)
                            <?php
                            // dd($detail_ins);
                                // $class_name = $detail_in->quantity < 0?'text-danger':'text-primary';
                                $class_name = $detail_in->operation < 0?'text-danger':'text-primary';
                            ?>
                            <tr class="intro-x {{ $class_name}}">
                                <td> 
                                    <?php
                                    $tengd = \App\Http\Controllers\HelpController::loai_giaodich($detail_in->doc_type);
                                    $url = \App\Http\Controllers\HelpController::url_giaodich($detail_in->doc_type,$detail_in->doc_id);
                                    // dd($tengd,$url);
                                 
 
                                    ?>
                                      <a href="{{$url}}">{{$tengd}}</a> 
                                </td>
                                <td>
                                
                                    @if ($detail_in->doc_type=="wi" || $detail_in->doc_type=="wo"
                                            ||$detail_in->doc_type=="din" || $detail_in->doc_type=="dout")
                                    <?php
                                    $document = $detail_in->document();
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
                                    <a href="{{$url_user}}">  {{ $url_name  }}  </a>
                                    @endif
                                    
                                </td>
                                <td>
                                    {{$detail_in->warehouse->title }}  
                                </td>
                                <td>
                                    {{$detail_in->quantity }}  
                                </td>
                                <td>
                                    {{$detail_in->price }}  
                                </td>
                                <td>
                                    {{$detail_in->prebalance  + $detail_in->quantity*$detail_in->operation  }}  
                                </td>
                                <td>
                                    {{$detail_in->created_at}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
            <nav class="w-full sm:w-auto sm:mr-auto">
                {{$detail_ins->links('vendor.pagination.tailwind')}}
            </nav>
           
        </div>
       
        
    </div>
    <!-- END: HTML Table Data -->
       
</div>
<!-- end content -->
  
   
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/vendor/js/bootstrap-switch-button.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
     
</script>
  
@endsection