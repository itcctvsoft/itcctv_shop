@extends('frontend_tp3.layouts.master')
@section('topcss')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="cart-container">
    <div class="cart-header">
        <div class="header-item">Sản phẩm</div>
        <div class="header-item">Giá</div>
        <div class="header-item">Số lượng</div>
        <div class="header-item">Tổng</div>
        <div class="header-item">Xóa</div>
    </div>
    <?php
        $tong = 0;
    ?>
    @foreach($products as $product)
       
         <?php
            $photos = explode( ',', $product->photo);
            $tong += $product->price * $product->quantity;
        ?>
        <div class="cart-item">
            <div class="item-product">
                <img src="{{$photos[0]}}" >
                <span>{{$product->title}}</span>
            </div>
            <div class="item-price">{{number_format($product->price,0,'.',',')}}</div>
            <div class="item-quantity">
                <button class="btn-qty" onclick="updatePriceAndQuantity({{$product->id}}, 'decrease')">-</button>
                <input type="hidden" id="price{{$product->id}}" value="{{$product->price}}" />
                <input type="text" class="input-qty" id="input-qty{{$product->id}}" value="{{$product->quantity}}" readonly>
                <button class="btn-qty" onclick="updatePriceAndQuantity({{$product->id}}, 'increase')">+</button>
            </div>
            
            <div class="item-total"><span id="spanprice{{$product->id}}">{{number_format($product->price*$product->quantity,0,'.',',')}}</span></div>
            <div class="item-remove">
                <button class="btn-delete">🗑️</button>
            </div>
        </div>
    @endforeach
   
    <!-- Thêm sản phẩm khác tương tự -->

    <div class="cart-footer">
        <div class="cart-total">
            <span>Tổng:</span>
            <span class="grand-total">{{ number_format($tong, 0, '.', ',') }}</span>
        </div>
        <a href="{{route('front.shopingcart.checkout')}}" class="btn-checkout">Đặt hàng</a>
    </div>
    
</div>

@endsection
@section('footscript')
<script>
  function updatePriceAndQuantity(id, operation) {
    const qtyInput = document.getElementById(`input-qty` + id);
    const spanPrice = document.getElementById(`spanprice` + id);
    const price = parseInt(document.getElementById(`price` + id).value);
    const grandTotalElement = document.querySelector(".grand-total"); // Tổng tiền hiển thị ở footer

    let currentQty = parseInt(qtyInput.value);

    if (operation === "increase") {
        currentQty++;
    } else if (operation === "decrease" && currentQty > 1) {
        currentQty--;
    }

    qtyInput.value = currentQty;

    // Cập nhật giá trị tổng tiền cho sản phẩm
    const total = currentQty * price;
    spanPrice.textContent = total.toLocaleString("en-US");

    // Gọi AJAX để cập nhật số lượng trên server
    updateQuantityOnServer(id, currentQty);

    // Cập nhật tổng tiền cho toàn bộ giỏ hàng
    updateGrandTotal();
}

function updateGrandTotal() {
    const spanPrices = document.querySelectorAll("[id^='spanprice']");
    let grandTotal = 0;

    // Tính tổng giá trị từ tất cả các sản phẩm
    spanPrices.forEach(spanPrice => {
        const price = parseInt(spanPrice.textContent.replace(/,/g, ""));
        grandTotal += price;
    });

    // Hiển thị tổng giá trị giỏ hàng
    const grandTotalElement = document.querySelector(".grand-total");
    grandTotalElement.textContent = grandTotal.toLocaleString("en-US");
}

function updateQuantityOnServer(id, quantity) {
    fetch("{{route('front.shopingcart.update')}}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ product_id: id, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            console.log("Cập nhật số lượng thành công");
        } else {
            console.error("Lỗi khi cập nhật số lượng:", data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi kết nối:", error);
    });
}



</script>
@endsection