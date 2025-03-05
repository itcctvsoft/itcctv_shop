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
            <li class="menu-item active">
                <a href="{{route('front.profile.order')}}">
                    <i class="icon-history"></i> Lịch sử mua hàng
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('front.wishlist.view')}}">
                    <i class="icon-heart"></i> Danh sách yêu thích
                </a>
            </li>
        </ul>
    </aside>

    <!-- Nội dung chính -->
    <div class="account-details">
        <div class="order-list-container">
            <div class="order-item" onclick="toggleDetails(1)">
                <div class="order-circle">1</div>
                <div class="order-info">
                    <div class="order-date">2025-01-27</div>
                    <div class="order-total">5,875,000</div>
                    <div class="order-status">Pending</div>
                </div>
                <div class="order-toggle">
                    <span class="icon-toggle">▶</span>
                </div>
            </div>
            <div id="order-details-1" class="order-details">
                <div class="order-product">
                    <span>Camera Wifi quay quét trong nhà Hero A1 2MP DAHUA DH-H2AE</span>
                    <span>249,000</span>
                    <span>2</span>
                </div>
                <div class="order-product">
                    <span>Màn hình LCD 24” MSI Pro MP241X FHD VA 75Hz 8Ms</span>
                    <span>1,990,000</span>
                    <span>2</span>
                </div>
                <div class="order-product">
                    <span>Tản Nhiệt Khí Tomato AM6300 RGB</span>
                    <span>299,000</span>
                    <span>3</span>
                </div>
                <div class="order-product">
                    <span>Adapter LCD 19V-2A</span>
                    <span>250,000</span>
                    <span>2</span>
                </div>
            </div>
            
            <!-- Thêm các đơn hàng khác tương tự -->
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


 
 