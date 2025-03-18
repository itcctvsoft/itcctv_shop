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
                <li class="menu-item "><a href="#">Thông tin tài khoản</a></li>
                <li class="menu-item "><a href="{{ route('front.profile.addressbook') }}">Địa chỉ mua hàng</a></li>
                <li class="menu-item"><a href="{{ route('front.shopingcart.view') }}"><i class="icon-cart"></i> Giỏ hàng</a>
                </li>
                <li class="menu-item active"><a href="{{ route('front.profile.order') }}"><i class="icon-history"></i> Lịch
                        sử mua hàng</a></li>
                <li class="menu-item"><a href="{{ route('front.wishlist.view') }}"><i class="icon-heart"></i> Danh sách yêu
                        thích</a></li>
            </ul>
        </aside>

        <!-- Nội dung chính -->
        <div class="account-details">
            <div class="order-list-container">
                @foreach ($orders as $order)
                    <div class="order-item" onclick="toggleDetails({{ $order->id }})">
                        <div class="order-circle">{{ $order->id }}</div>
                        <div class="order-info">
                            <div class="order-date">{{ date('Y-m-d', strtotime($order->created_at)) }}</div>
                            <div class="order-total">{{ number_format($order->final_amount, 0, '.', ',') }} VND</div>
                            <div class="order-status">{{ $order->status }}</div>
                        </div>
                        <div class="order-toggle"><span class="icon-toggle">▶</span></div>
                    </div>
                    <div id="order-details-{{ $order->id }}" class="order-details" style="display: none;">
                        @foreach ($order->details as $detail)
                            <div class="order-product">
                                <span>{{ $detail->title }}</span>
                                <span>{{ number_format($detail->price, 0, '.', ',') }} VND</span>
                                <span>{{ $detail->quantity }}</span>
                            </div>
                        @endforeach
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
            details.style.display = details.style.display === "none" ? "block" : "none";

            const toggleIcon = details.previousElementSibling.querySelector(".icon-toggle");
            toggleIcon.textContent = details.style.display === "block" ? "▼" : "▶";
        }
    </script>
@endsection
