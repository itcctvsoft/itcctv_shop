<?php
    $mod_pros = \App\Models\FrontProMod::where('status','active')->orderBy('order_id','asc')->get();
?>
 
@foreach($mod_pros as $mod_pro)
    <?php
        $mod_pro_details = \App\Models\FrontProModDetail::where('mod_id',$mod_pro->id)->orderBy('order_id','asc')->get();
    ?>
    <section class='product-module'>
        <div class="section-header">
            <span class="header-icon">🍉</span>
            <h2 class="header-title">{{$mod_pro->title}}</h2>   
            @if($mod_pro->mod_type == 1)
                <div class="timer">
                    <p id="demo"></p>
                </div>
            @endif
        </div>
        <div class="product-section">

            <div class="product-list">
                @foreach ($mod_pro_details as $pro_detail)
                    <?php
                        $products = \DB::select('select a.*, b.old_price from (select * from products where id = '.$pro_detail->pro_id.') as a left join productextends b on a.id = b.product_id  ') ;
                    ?>
                    @foreach ($products as $product)
                        <?php
                        $photos = explode( ',', $product->photo);
                        $word = 0;
                        if ($product->price < $product->old_price )
                            $word = round(($product->old_price - $product->price)*100 /$product->old_price);
                        ?>
                        <div class="product-item">
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
                @endforeach
            </div>
        </div>
    </section>
@endforeach