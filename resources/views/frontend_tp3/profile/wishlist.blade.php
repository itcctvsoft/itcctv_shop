@extends('frontend_tp3.layouts.master')
@section('topcss')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
 
<div class="account-container">
    <!-- Menu bên trái -->
    <aside class="account-menu">
        <ul>
            <li class="menu-item ">
                <a href="#">
                      Thông tin tài khoản
                </a>
            </li>
            <li class="menu-item ">
                <a href="{{route('front.profile.addressbook')}}">
                     Địa chỉ mua hàng
                </a>
            </li>
            
            <li class="menu-item">
                <a href="{{route('front.shopingcart.view')}}">
                    <i class="icon-cart"></i> Giỏ hàng
                </a>
            </li>
            <li class="menu-item ">
                <a href="{{route('front.profile.order')}}">
                    <i class="icon-history"></i> Lịch sử mua hàng
                </a>
            </li>
            <li class="menu-item active">
                <a href="#">
                    <i class="icon-heart"></i> Danh sách yêu thích
                </a>
            </li>
        </ul>
    </aside>

    <!-- Nội dung chính -->
    <div class="account-details">
        <div class="wish-list">
            @foreach ($products as $product)
                @php
                    $photos = explode(',', $product->photo);
                @endphp
                <div class="wish-list-item">
                    <img src="{{$photos[0]}}" alt="{{$product->title}}" class="wish-list-image" />
                    <div class="wish-list-info">
                        <a href="{{route('front.product.view', $product->slug)}}" class="wish-list-title">
                            {{$product->title}}
                        </a>
                        <a href="{{route('front.wishlist.remove', $product->id)}}" class="wish-list-remove">
                            Xóa
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
             
    </div>

   
</div>

@endsection
@section('footscript')
<script>
function toggleDetails(orderId) {
    const details = document.getElementById(`order-details-${orderId}`);
    details.classList.toggle("active");

    // Lấy phần tử icon-toggle trong phần tử cha
    const toggleIcon = details.previousElementSibling.querySelector(".icon-toggle");

    // Kiểm tra trạng thái để đổi icon
    if (details.classList.contains("active")) {
        toggleIcon.textContent = "▼"; // Mũi tên xuống
    } else {
        toggleIcon.textContent = "▶"; // Mũi tên phải
    }
}
   
</script>
@endsection


 
 