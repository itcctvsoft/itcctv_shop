<div class="section-header">
    <span class="header-icon">🍉</span>
    <h2 class="header-title">Có thể bạn quan tâm</h2>   
   
</div>
<div class="product-section">
    <div class="product-list">
            @foreach ($randpros as $pro)
                <?php
                $pros = \DB::select('select a.*, b.old_price from (select * from products where id = '.$pro->id.') as a left join productextends b on a.id = b.product_id  ') ;
                $product = $pros[0];
                $cat = \App\Models\Category::find($product->cat_id); 
                $photos = explode( ',', $product->photo);
                $word = 0;
                if ($product->price < $product->old_price )
                    $word = round(($product->old_price - $product->price)*100 /$product->old_price);
                ?>
                <div class="product-item" data-category="{{$product->cat_id}}">
                    @if($word > 0)
                    <div class="discount-badge">-{{$word}}%</div> 
                    @endif
                    <a href="{{route('front.product.view',$product->slug)}}">
                        <img src="{{$photos[0]?$photos[0]:asset('frontend/assets/images/electronics/pro/26.jpg')}}" alt="{{$product->title}}">
                    </a>
                    <h3>{{$product->title}}</h3>
                
                    <div class="pro_actions">
                        <div class="price "><del> {{$product->old_price?number_format($product->old_price,0,".",",") :'' }}</del> 
                            {{number_format($product->price,0,".",",")  }}
                        </div>
                        <a href="javascript:void(0)" class="btn   ti-shopping-cart" data-id="{{ $product->id}}" >🛒</a>
                        <a href="javascript:void(0)" class="btn ti-heart" data-id="{{ $product->id}}"
                            aria-hidden="true">❤️</a>
                    </div>
                </div>

            @endforeach
       
    </div>
</div>
 