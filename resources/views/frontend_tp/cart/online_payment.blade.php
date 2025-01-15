@extends('frontend_tp.layouts.master')

@section('content')
    <section class="payment-section py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #333; font-weight: bold;">Thanh toán đơn hàng</h2>

            <!-- Chi tiết đơn hàng -->
            <div class="order-details mx-auto mb-4"
                style="max-width: 500px; background: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px;">
                <h4 class="text-center" style="color: #007bff; font-weight: bold;">Thông tin đơn hàng</h4>
                <p class="text-center mb-1" style="font-size: 16px; color: #555;">Tổng số tiền:
                    <span style="color: #28a745; font-weight: bold;">
                        {{ number_format($totalAmount, 0, '.', ',') }} đ
                    </span>
                </p>
                <p class="text-center" style="font-size: 16px; color: #555;">Mô tả:
                    <span style="font-weight: bold;">{{ $orderDescription }}</span>
                </p>
            </div>

            <!-- Form Thanh Toán -->
            <div class="text-center">
                <form action="{{ route('process_vnpay_payment') }}" method="POST">
                    @csrf
                    <!-- Hidden Inputs -->
                    <input type="hidden" name="order_id" value="{{ $orderId }}">
                    <input type="hidden" name="amount" value="{{ $totalAmount }}">
                    <input type="hidden" name="order_desc" value="{{ $orderDescription }}">

                    <!-- Button -->
                    <button type="submit" class="btn btn-primary text-white"
                        style="background-color: #007bff; padding: 10px 20px; font-size: 16px; border-radius: 5px; border: none;">
                        Thanh toán qua VNPay
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
