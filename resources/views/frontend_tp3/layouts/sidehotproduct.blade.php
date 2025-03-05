 


<div class="new-products-sidebar">
    <h4>Sản nổi bật</h4>
    <ul class="new-products-list">
        <!-- Mỗi sản phẩm -->
        @foreach ($poppros as $pro )
            <?php
                $photos = explode( ',', $pro->photo);
            ?>
            <li class="new-product-item">
                <a href="{{route('front.product.view',$pro->slug)}}">
                    <img src="{{$photos[0]}}" alt="{{$pro->title}}">
                    <div class="product-info">
                        <span class="product-title">{{$pro->title}}</span>
                        <span class="product-price">{{number_format($pro->price,0,'.',',')}}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
