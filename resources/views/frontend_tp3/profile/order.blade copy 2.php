
@extends('frontend_tp3.layouts.master')
@section('topcss')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
<div class="order-list-container">
    <div class="order-item">
        <div class="order-circle">2</div>
        <div class="order-info">
            <div class="order-date">2025-01-27</div>
            <div class="order-total">5,875,000</div>
            <div class="order-status">Pending</div>
        </div>
        <div class="order-toggle">></div>
    </div>
    <div class="order-item">
        <div class="order-circle">3</div>
        <div class="order-info">
            <div class="order-date">2025-01-26</div>
            <div class="order-total">3,150,000</div>
            <div class="order-status">Shipped</div>
        </div>
        <div class="order-toggle">></div>
    </div>
    <!-- Thêm các đơn hàng khác tương tự -->
</div>
@endsection
@section('footscript')
<script>
    function toggleDetails(element) {
        const details = element.nextElementSibling;
        details.classList.toggle('active');
        const toggleIcon = element.querySelector('.order-toggle');
        toggleIcon.textContent = details.classList.contains('active') ? '⮝' : '⮟';
    }
</script>
@endsection
