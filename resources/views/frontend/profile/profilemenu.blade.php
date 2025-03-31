<div class="col-lg-3">
    <div class="dashboard-sidebar">
        <div class="profile-top">
            <div class="profile-image">
                <img src="{{isset($profile->photo)?$profile->photo:asset('frontend/assets/images/avtar.jpg')}}" alt="" class="img-fluid">
            </div>
            <div class="profile-detail">
                
                <h5>{{$profile->full_name}}</h5>
                <h6>{{$profile->email}}</h6>
            </div>
        </div>
        <div class="faq-tab">
            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $menu ==1? 'active':''}}" href="{{route('front.profile')}}"
                        >Thông tin tài khoản</a></li>
                <li class="nav-item">
                    <a  href="{{route('front.shopingcart.view')}}"
                        class="nav-link  {{ $menu ==2? 'active':''}}">Giỏ hàng</a></li>
                <li class="nav-item ">
                    <a  class="nav-link {{ $menu ==3? 'active':''}}" href="{{route('front.profile.addressbook')}}"
                        >Danh sách địa chỉ</a></li>
                <li class="nav-item ">
                    <a class="nav-link {{ $menu ==4? 'active':''}}" href="{{route('front.wishlist.view')}}">SP Yêu thích</a></li>
                <li class="nav-item">
                    <a class="nav-link {{ $menu ==5? 'active':''}} " href="{{route('front.profile.order')}}">Đơn hàng chờ xử lý</a></li>
                <li class="nav-item">
                    <a class="nav-link {{ $menu ==6? 'active':''}}" href="{{route('front.profile.warehouseout')}}">Đơn hàng hoàn thành</a></li>
                <li class="nav-item ">
                    <a   class="nav-link {{ $menu ==7? 'active':''}}" href="{{route('front.profile.viewsuptrans')}}">Công nợ</a></li>
                
            </ul>
        </div>
    </div>
</div>