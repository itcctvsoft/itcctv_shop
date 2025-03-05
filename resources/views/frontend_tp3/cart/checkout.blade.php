@extends('frontend_tp3.layouts.master')
@section('topcss')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<form method="POST" action ="{{route('front.shopingcart.order')}}">
    @csrf
<div class="checkout-container">
  
    <!-- Left Section: Địa chỉ -->
    <div class="checkout-address">
        <h3>Địa chỉ nhận hóa đơn</h3>
        <div id = "invoice_div_detail">
            @if ($defaut_setting && isset($invoiceaddress))
                            
            <input type="hidden" name="invoice_id" value="{{$invoiceaddress->id}}" />
            <div style="padding-left:30px">  
                <h3> {{$invoiceaddress->full_name}} </h3>
                <h3> {{$invoiceaddress->phone}} </h3>
                <h3> {{$invoiceaddress->address}} </h3>
            </div>
            @endif
        </div>
        <div style="margin-top:10px">
            <a href="javascript:void(0)" class="add-address" onclick="openAddAddressModal()">Thêm</a> | 
            <a href="javascript:void(0)" class="select-address" onclick="openSelectAddressModal()">Chọn địa chỉ khác</a>
        </div>
        <h3>Địa chỉ giao hàng</h3>
        <div id = "ship_div_detail">
            @if ($defaut_setting && isset($shipaddress))
            <input type="hidden" name="ship_id" value="{{$shipaddress->id}}" />
            <div style="padding-left:30px">  
                <h3> {{$shipaddress->full_name}} </h3>
                <h3> {{$shipaddress->phone}} </h3>
                <h3> {{$shipaddress->address}} </h3>
            </div>
            @endif
        </div>

        <p>
            <a href="javascript:void(0)" class="add-address" onclick="openAddAddressModal()">Thêm</a> | 
            <a href="javascript:void(0)" class="select-address" onclick="openSelectAddressModal2()">Chọn địa chỉ khác</a>
        </p>
    </div>

    <!-- Right Section: Đơn hàng -->
    <div class="checkout-summary">
        <h3>Đơn hàng</h3>
     
            <ul class="order-list">
                <?php $tong = 0;?>
                @foreach ( $products as $pro)
                <?php
                    $photos = explode( ',', $pro->photo);
                ?>
                <li class="order-item">
                    <div class="item-details">
                        <img src="{{$photos[0]}}"  >
                        <div>
                            <h4>{{$pro->title}}</h4>
                            <p>{{number_format($pro->quantity*$pro->price,0,'.',',')}}</p>
                        </div>
                    </div>
                </li>
                <?php $tong += $pro->quantity * $pro->price;?>
                @endforeach
                
            </ul>

            <h3>Chi phí vận chuyển</h3>
            <p>Thông báo sau cho khách hàng</p>

            <div class="checkout-total">
                <span>Tổng:</span>
                <strong>{{number_format($tong,0,'.',',')}} ₫</strong>
            </div>
            <div class="payment-options">
                <?php echo $paymentinfo ?>
            </div>
            
            <button type="submit"  class="checkout-btn">Đặt hàng</button>
       
        </div>
 
</div>
</form>
<!-- Modal Thêm Địa Chỉ -->
<div id="addAddressModal" class="modal">
    <div class="modal-content">
        <h4>Thêm địa chỉ</h4>
        <form id="addAddressForm">
            <label for="fullName">Tên đầy đủ</label>
            <input type="text" id="fullName" name="fullName" required>
            <label for="phone">Số điện thoại</label>
            <input type="text" id="phone" name="phone" required>
            <label for="address">Địa chỉ</label>
            <textarea id="address" name="address" required></textarea>
            <button type="submit">Lưu</button>
            <button type="button" onclick="closeModal('addAddressModal')">Hủy</button>
        </form>
    </div>
</div>

<!-- Modal Chọn Địa Chỉ -->
<div id="selectAddressModal" class="modal">
    <div class="modal-content">
        <h4>Chọn địa chỉ</h4>
        <ul id="addressList">
            <!-- Danh sách địa chỉ sẽ được tải từ PHP -->
            @foreach ($addressbooks as $address )
            <li>
                <input style="width:auto" type="radio" name="selectedAddress" value="{{$address->id}}" 
                data-name="{{$address->full_name}}" data-phone="{{$address->phone}}" data-address="{{$address->address}}" 
                id="i{{$address->id}}">
                <label for="i{{$address->id}}">{{$address->full_name}} - {{$address->phone}} - {{$address->address}}</label>
            </li>
            @endforeach
        </ul>
        <button type="submit" class="btn-save" onclick="saveSelectedAddress()">Lưu</button>
        <button type="button" class="btn-cancel" onclick="closeModal('selectAddressModal')">Hủy</button>
    </div>
</div>
<!-- Modal Chọn Địa Chỉ -->
<div id="selectAddressModal2" class="modal">
    <div class="modal-content">
        <h4>Chọn địa chỉ</h4>
        <ul id="addressList">
            <!-- Danh sách địa chỉ sẽ được tải từ PHP -->
         
          
            @foreach ($addressbooks as $address )
            <li>
                <input style="width:auto" type="radio" name="selectedAddress2" value="{{$address->id}}" data-name="{{$address->full_name}}" data-phone="{{$address->phone}}" 
                data-address="{{$address->address}}" id="s{{$address->id}}">
                <label for="s{{$address->id}}">{{$address->full_name}} - {{$address->phone}} - {{$address->address}}</label>
            </li>
           
            @endforeach  
           
        </ul>
        <button type="submit" class="btn-save" onclick="saveSelectedAddress2()">Lưu</button>
        <button type="button" class="btn-cancel" onclick="closeModal('selectAddressModal2')">Hủy</button>
    </div>
</div>
@endsection
@section('footscript')
<script>
   
        function openAddAddressModal() {
            document.getElementById('addAddressModal').style.display = 'flex';
        }

        function openSelectAddressModal() {
            document.getElementById('selectAddressModal').style.display = 'flex';
        }
        function openSelectAddressModal2() {
            document.getElementById('selectAddressModal2').style.display = 'flex';
        }
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        function closeModal2(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function saveSelectedAddress() {
            const selectedAddress = $('input[name="selectedAddress"]:checked');
            if (selectedAddress) {
                // alert(`Đã chọn địa chỉ: ${selectedAddress.value}`);
                // Gửi AJAX lưu địa chỉ đã chọn, sau đó reload lại trang
                
                var invoice_id = selectedAddress.attr("value");
                
                var inner = '<input type="hidden" name="invoice_id" value="' + invoice_id+'"  />'
                    + '<div style="padding-left:30px"><h3>'+selectedAddress.attr("data-name")+'  </h3>'
                    + '<h3> '+selectedAddress.attr("data-phone")+' </h3>'
                    +'<h3> '+selectedAddress.attr("data-address")+' </h3> </div>';
                $('#invoice_div_detail').html(inner);
                closeModal('selectAddressModal');
            } else {
                alert('Vui lòng chọn một địa chỉ!');
            }
        }
        function saveSelectedAddress2() {
         
            const selectedAddress = $('input[name="selectedAddress2"]:checked');
            if (selectedAddress) {
                // alert(`Đã chọn địa chỉ: ${selectedAddress.value}`);
                // Gửi AJAX lưu địa chỉ đã chọn, sau đó reload lại trang

                var ship_id = selectedAddress.attr("value");
                var inner = '<input type="hidden" name="ship_id" value="' + ship_id+'"  />'
                    + '<div style="padding-left:30px"><h3>'+selectedAddress.attr("data-name")+'  </h3>'
                    + '<h3> '+selectedAddress.attr("data-phone")+' </h3>'
                    +'<h3> '+selectedAddress.attr("data-address")+' </h3> </div>';
                $('#ship_div_detail').html(inner);
                closeModal('selectAddressModal2');
            } else {
                alert('Vui lòng chọn một địa chỉ!');
            }
        }
        // Form submit để lưu địa chỉ mới
        document.getElementById('addAddressForm').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Địa chỉ đã được thêm!');
            closeModal('addAddressModal');
        });


</script>
@endsection