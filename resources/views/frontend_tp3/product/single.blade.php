@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
 
<div class="product-detail-container">
    <div class="product-images">
        <?php
           
            $photos = explode( ',', $product->photo);
            $word = 0;
            if ($productdata->price < $productdata->old_price )
              $word = round(($productdata->old_price - $productdata->price)*100 /$productdata->old_price);
       
        ?>
        
        <div class="main-image">
            <img src="{{$photos[0]}}" alt="{{$product->title}}">
        </div>
        <div class="thumbnail-images">
            @foreach ($photos as $photo )
                <img src="{{$photo}}" alt="{{$product->title}}">
             @endforeach
        </div>
    </div>
    <div class="product-details">
       
        <h1 class="product-title">{{$product->title}}</h1>
        <p class="product-price">Giá: <span>{{number_format($product->price,0,'.',',')}}₫</span></p>
        <p class="product-code">Mã sản phẩm: <span>ABC123</span></p>
        <div class="product-specs">
            {!! $product->summary !!}
        </div>
        <div class="product-actions">
            <h6 class="product-quantity-title">Số lượng</h6>
            <div class="qty-box">
                <div class="input-group">
                    <button type="button" class="btn quantity-left-minus" data-type="minus" data-field="">
                       - 
                    </button>
                    <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1">
                    <button type="button" class="btn quantity-right-plus" data-type="plus" data-field="">
                       +
                    </button>
                </div>
            </div>
            <div class="product-buttons">
                <a href="javascript:void(0)" id="cartEffect" data-id="{{$product->id}}" class="btn btn-buy">
                    🛒 Thêm giỏ hàng
                </a>
                <a href="javascript:void(0)" data-id="{{$product->id}}" id="addWishlist" class="btn btn-like ti-shopping-cart">
                    ❤️ Thêm yêu thích
                </a>
            </div>
        </div>
    </div>
    
</div>
<div class='product-detail-description'>
   
    <div class='product-description'>
        <div class="tab-content">
           
            <h1  >{{$product->title}}</h1>
            <?php
                echo $product->description;
            ?>
        </div>
        @include('frontend_tp3.layouts.mod_4_pro')
        @include('frontend_tp3.layouts.comment')
        @include('frontend_tp3.layouts.comment_form')
        @include('frontend_tp3.layouts.mod_tags')
    </div>
    <aside  class='product-aside' style="padding-top:10px">
       
        @include('frontend_tp3.layouts.catpromenu')
        @include('frontend_tp3.layouts.sidehotproduct')
    </aside>
</div>
@endsection
@section('footscript')
<script>
document.addEventListener("DOMContentLoaded", () => {
    // Lấy các thành phần DOM
    const mainImage = document.querySelector(".main-image img");
    const thumbnailImages = document.querySelectorAll(".thumbnail-images img");

    // Thêm sự kiện click vào từng hình ảnh thumbnail
    thumbnailImages.forEach((thumbnail) => {
        thumbnail.addEventListener("click", () => {
            // Cập nhật hình ảnh chính khi bấm vào thumbnail
            mainImage.src = thumbnail.src;

            // Xóa class 'active' từ tất cả thumbnail
            thumbnailImages.forEach((img) => img.classList.remove("active"));

            // Thêm class 'active' vào thumbnail được chọn
            thumbnail.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Lấy các phần tử cần thiết
    const quantityInput = document.getElementById("quantity");
    const btnMinus = document.querySelector(".quantity-left-minus");
    const btnPlus = document.querySelector(".quantity-right-plus");

    // Xử lý khi bấm nút trừ
    btnMinus.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value) || 1; // Lấy giá trị hiện tại, mặc định là 1
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1; // Giảm giá trị
        }
    });

    // Xử lý khi bấm nút cộng
    btnPlus.addEventListener("click", function () {
        let currentValue = parseInt(quantityInput.value) || 1; // Lấy giá trị hiện tại, mặc định là 1
        quantityInput.value = currentValue + 1; // Tăng giá trị
    });

    // Ngăn không cho nhập ký tự không hợp lệ
    quantityInput.addEventListener("input", function () {
        quantityInput.value = quantityInput.value.replace(/[^0-9]/g, ""); // Chỉ cho phép nhập số
        if (quantityInput.value === "" || parseInt(quantityInput.value) <= 0) {
            quantityInput.value = 1; // Đặt giá trị mặc định là 1 nếu giá trị không hợp lệ
        }
    });
});

</script>

@endsection


 