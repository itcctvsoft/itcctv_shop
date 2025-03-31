@extends('frontend.layouts.master')
@section('css')
    
     
@endsection
@section('content')

    <!--  dashboard section start -->
    <section class="dashboard-section section-b-space user-dashboard-section">
        <div class="container">
            <div class="row">
                <!-- left side bar -->
                <?php
                    $menu = 4;
                ?>
                @include('frontend.profile.profilemenu')
                  <!-- left side bar -->
                  <!-- right side content -->

                <div class="col-lg-9">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">
                               
                                <div class="collection-product-wrapper">
                                     <!--filter-->
                                    <div class="product-top-filter">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="filter-main-btn"><span
                                                        class="filter-btn btn btn-theme"><i class="fa fa-filter"
                                                            aria-hidden="true"></i> Filter</span></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-filter-content">
                                                    <div class="search-count">
                                                        <h5> Danh sách sản phẩm được ưu chuộng</h5>
                                                    </div>
                                                    <div class="collection-view">
                                                        <ul>
                                                            <li><i class="fa fa-th grid-layout-view"></i></li>
                                                            <li><i class="fa fa-list-ul list-layout-view"></i></li>
                                                        </ul>
                                                    </div>
                                                    <div class="collection-grid-view">
                                                        <ul>
                                                            <li><img src="{{asset('frontend/assets/images/icon/2.png')}}" alt=""
                                                                    class="product-2-layout-view"></li>
                                                            <li><img src="{{asset('frontend/assets/images/icon/3.png')}}" alt=""
                                                                    class="product-3-layout-view"></li>
                                                            <li><img src="{{asset('frontend/assets/images/icon/4.png')}}" alt=""
                                                                    class="product-4-layout-view"></li>
                                                            <li><img src="{{asset('frontend/assets/images/icon/6.png')}}" alt=""
                                                                    class="product-6-layout-view"></li>
                                                        </ul>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <!--filter-->
                                     <!-- sub category start -->
                                    
                                    <!-- sub category start -->

                                    <div class="product-wrapper-grid">
                                        <div class="row margin-res">
                                            @if(count($products)==0)
                                                <h5 style="margin-top:20px"> Không có sản phẩm </h5>
                                            @endif

                                            @foreach ($products as $product )
                                            <?php $photos = explode( ',', $product->photo); ?>
                                            <div class="col-xl-3 col-6 col-grid-box">
                                                <div class="product-box">
                                                    <div class="img-wrapper">
                                                        <div class="front">
                                                            <a href="{{route('front.product.view',$product->slug)}}"><img src="{{count($photos)>0?$photos[0]:asset('frontend/assets/images/pro3/35.jpg')}}"
                                                                    class="img-fluid blur-up lazyload bg-img"
                                                                    alt="{{$product->title}}"></a>
                                                        </div>
                                                        @if (count($photos)> 1  )
                                                            <div class="back">
                                                                <a href="{{route('front.product.view',$product->slug)}}"><img src="{{$photos[1]}}"
                                                                        class="img-fluid blur-up lazyload bg-img"
                                                                        alt="{{$product->title}}"></a>
                                                            </div>
                                                        @endif
                                                       
                                                        <div class="cart-info cart-wrap">
                                                        <button onclick="openCart()" title="Add to cart"><i
                                                                class="ti-shopping-cart" data-id="{{ $product->id}}"></i></button>
                                                        <a href="javascript:void(0)" title="Add to Wishlist"><i class="ti-heart" data-id="{{ $product->id}}"
                                                                aria-hidden="true"></i></a>
                                                                    <!-- <a  href="#" data-bs-toggle="modal"
                                                                data-bs-target="#quick-view" title="Quick View"><i
                                                                    class="ti-search" aria-hidden="true"></i></a> 
                                                                    <a       href="compare.html" title="Compare"><i
                                                                    class="ti-reload" aria-hidden="true"></i></a> -->
                                                        </div>
                                                    </div>
                                                    <div class="product-detail">
                                                        <div>
                                                            
                                                            <a href="{{route('front.product.view',$product->slug)}}">
                                                                <h6>{{$product->title}}</h6>
                                                            </a>
                                                           <?php //echo substr( strip_tags($product->summary),0,100)?>
                                                            <h4>{{number_format($product->price,0,".",",")}}</h4>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                          
                                            
                                        </div>
                                    </div>
                                    <div class="product-pagination">
                                        <div class="theme-paggination-block">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                <nav  aria-label="Page navigation">
                                                    {{$products->links('vendor.pagination.simple-new')}}
                                                </nav>
                                                    
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-12">
                                                    <div class="product-search-count-bottom">
                                                        <h5>Sản phẩm từ {{($products->currentPage()-1)*$products->perPage() + 1}}-{{($products->currentPage())*$products->perPage()}} trong tổng số {{$products->total()}} </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- right side content -->
            </div>
        </div>
    </section>
    <!--  dashboard section end -->
   
 
 
@endsection
@section('scripts')
<script>
    function add_notify(msg, status)
    {
        $.notify({
                    icon: 'fa fa-check',
                    title: status?'Thành Công!':'Thất bại!',
                    message:  msg,
                }, {
                    element: 'body',
                    position: null,
                    type: status?"info":"warning",
                    allow_dismiss: false,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 1031,
                    delay: 2000,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                        '<button type="button" aria-hidden="true" class="btn-close" data-notify="dismiss"></button>' +
                        '<span data-notify="icon"></span> ' +
                        '<span data-notify="title">{1}</span> ' +
                        '<span data-notify="message">{2}</span>' +
                        '<div class="progress" data-notify="progressbar">' +
                        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                        '</div>' +
                        '<a href="{3}" target="{4}" data-notify="url"></a>' +
                        '</div>'
                });
    }

    $('.invoice_ra').on('click', function () {
        var invoice_id = $(this).attr("value");
        $.ajax({
            type: 'GET',
            url: '{{route("front.address.setinvoice")}}',
            data: {
                id: invoice_id,
            },
            success: function(data) {
                add_notify(data.msg,data.status);
            },
        }); 
    });

    $('.ship_ra').on('click', function () {
        var ship_id = $(this).attr("value");
        $.ajax({
            type: 'GET',
            url: '{{route("front.address.setship")}}',
            data: {
                id: ship_id,
            },
            success: function(data) {
                add_notify(data.msg,data.status);
            },
        }); 
    });
</script>
@endsection