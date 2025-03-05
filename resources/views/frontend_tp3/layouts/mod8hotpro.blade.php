<?php
    $rand_pros = \DB::select("SELECT * from products where   status = 'active' and `is_sold`=1 order by hit LIMIT 5");;
    
?>
  <section class='product-module'>
    <div class="section-header">
        <span class="header-icon">🍉</span>
        <h2 class="header-title">Sản phẩm yêu thích</h2>   
        
    </div>
    <div class="product-section">

        <div class="product-list">
           
                @foreach ($rand_pros as $product)
                     
                    <div class="product-item">
                        <?php
                            $photos = explode( ',', $product->photo);
                        ?>
                        <a href="{{route('front.product.view',$product->slug)}}">
                            <img src="{{$photos[0]?$photos[0]:asset('frontend/assets/images/electronics/pro/26.jpg')}}" alt="{{$product->title}}">
                        </a>
                        <h3>{{$product->title}}</h3>
                    
                        <div class="pro_actions">
                            <div class="price "> 
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
</section>
 