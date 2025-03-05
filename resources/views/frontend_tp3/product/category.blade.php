@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
<div class="product-container">
    <!-- Sidebar: Categories -->
    <?php
    $slug = $cat->slug;
    ?>

  
    <section class='catproduct-module'>
        
            <div class="product-list">
              
                    <?php
                        ?>
                    @foreach ($products as $pro)
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
            <nav class="flex pagination-container" aria-label="pagination" class="">
                <!-- /.pagination -->
                {{$products->links('vendor.pagination.simple-new')}}
            </nav>
    </section>
    <aside class="category-menu">
        @include('frontend_tp3.layouts.catpromenu')
        @include('frontend_tp3.layouts.sideproduct')
        @include('frontend_tp3.layouts.sidehotproduct')
    </aside>
    <!-- Main Content: Products -->
    {{-- <section class="product-list">
        <h2>Sản phẩm</h2>
        <div class="products">
            <div class="product-item" data-category="laptop">
                <img src="https://via.placeholder.com/150" alt="Laptop">
                <h4>Laptop A</h4>
                <p>10,000,000 VNĐ</p>
            </div>
            <div class="product-item" data-category="smartphone">
                <img src="https://via.placeholder.com/150" alt="Smartphone">
                <h4>Smartphone B</h4>
                <p>7,000,000 VNĐ</p>
            </div>
            <div class="product-item" data-category="accessory">
                <img src="https://via.placeholder.com/150" alt="Phụ kiện">
                <h4>Phụ kiện C</h4>
                <p>500,000 VNĐ</p>
            </div>
            <div class="product-item" data-category="tablet">
                <img src="https://via.placeholder.com/150" alt="Tablet">
                <h4>Tablet D</h4>
                <p>8,000,000 VNĐ</p>
            </div>
        </div>
    </section> --}}
</div>


@endsection
@section('footscript')
 
@endsection


 