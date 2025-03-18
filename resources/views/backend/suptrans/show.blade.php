@extends('backend.layouts.master')
@section('css')
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
@endsection
@section('content')
    <div class = 'content'>
@include('backend.layouts.notification')

      <div class="intro-y flex items-center mt-8">
          <h2 class="text-lg font-medium mr-auto">
              Thông tin công nợ 
          </h2>
      </div>
      <div class="grid grid-cols-12 gap-12 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
          <div class="lg:flex intro-y box py-5 px-5">
            <div class='relative'> 
              <div class= "mt-3">
                  <label class="font-medium"> Đối tác: </label>
                  {{$user->full_name}}
              </div>
              <div class= "mt-3">
                  <label class="font-medium"> Tổng công nợ: </label>
                  <span class="{{$user->budget > 0?'text-danger':'text-success'}}">{{Number_format($user->budget,0,'.',',')}}</span>
                  <br/><span class="form-help"> (-) đối tác nợ tiền , (+) cửa hàng nợ tiền </span>
              </div>
            </div>
            <div class="mt-3 lg:w-auto   lg:mt-0 ml-auto">
              <a href="{{route('user.usertostore',$user->id)}}" class="btn btn-primary shadow-md mr-2 primary-btn lg:w-auto   lg:mt-0 ml-auto" > nhận tiền từ đối tác </a>
              <a href="{{route('user.storetouser',$user->id)}}" class="btn btn-primary shadow-md mr-2 primary-btn lg:w-auto   lg:mt-0 ml-auto" > chuyển tiền cho đối tác </a>
           
            </div>
          </div>
          <div class="intro-y flex items-center mt-8">
              <h2 class="text-lg font-medium mr-auto">
                  Chi tiết tài khoản đối tác
              </h2>
          </div>

          <div class="intro-y col-span-12 flex flex-col sm:flex-row sm:items-end xl:items-start">
            <form action="{{ route('user.showsup', $user->id) }}" method="get" id="filterForm" class="xl:flex sm:mr-auto">
                <!-- @csrf -->
                <div class="sm:flex items-center sm:mr-4">
                    <label style="min-width:80px" class="w-12 flex-none xl:w-auto xl:flex-initial mr-5">Lọc: </label>
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <input type="text" id="date1" name="date1" placeholder="Chọn ngày">
                        -
                        <input type="text" id="date2" name="date2" placeholder="Chọn ngày">
                    </div>
                    <button id="btn_tim" type="submit" class="btn btn-primary w-full sm:w-16">Chọn</button>
                </div>
            </form>
        
            <!-- Khi bấm vào Xuất Excel, dữ liệu ngày cũng được gửi -->
            <a href="#" class="btn btn-success" onclick="submitExport()">Xuất Excel</a>
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
              @foreach ($suptrans as $sp)
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
                  <div class="report-row"  onclick="toggleDetails({{$sp->id}})">
                      <div class="report-cell"> {{$sp->created_at}}</div>
                      <div class="report-cell"> {{\App\Http\Controllers\HelpController::loai_giaodich($sp->doc_type)}}</div>
                      <div class="report-cell"> {{$ptotal}} </div>
                      <div class="report-cell"> {{$stotal}} </div>
                      <div class="report-cell {{$classname}}"> {{number_format($sp->total, 0, '.', ',')}} </div>
                  </div>
                   <!-- Chi tiết phiếu (ẩn mặc định) -->
                  <div id="details-{{$sp->id}}" class="report-details hidden">
                    <div class="detail-content">
                        
                        <p>
                          
                          {!!\App\Http\Controllers\HelpController::html_chitietgd($sp->doc_type,$sp->document())!!}
                          
                        </p>
                    </div>
                  </div>
              @endforeach
          </div>
          
            <div style='clear:both' class="  ">
            &nbsp;
            </div>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
              <nav class="w-full sm:w-auto sm:mr-auto">
                  {{$suptrans->links('vendor.pagination.tailwind')}}
              </nav>
            </div>
          </div>
        </div>
     
      </div>
    </div>
@endsection

@section ('scripts')

<script>
  const myDatePicker =  new MyDatepicker("#date1");
   myDatePicker.setDefaultDate("{{$date1}}");
   const myDatePicker2 =  new MyDatepicker("#date2");
   myDatePicker2.setDefaultDate("{{$date2}}");
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
        form.action = "{{ route('user.expsup', $user->id) }}";

        // Gửi form
        form.submit();
    }
</script>
@endsection
                                      