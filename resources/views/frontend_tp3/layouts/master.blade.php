<?php
 
  $setting =\App\Models\SettingDetail::find(1);
  $user = auth()->user();
  if($user)
  {
      $sql  = "select c.quantity, d.* from (SELECT * from shoping_carts where user_id = "
      .$user->id.") as c left join products as d on c.product_id = d.id where d.status = 'active'  ";
      $pro_carts =   \DB::select($sql ) ;
  }
  else
  {
      $pro_carts = [];
  }
  $cart_size= count($pro_carts);
?>
<!DOCTYPE html>
<html lang="vi">
@include('frontend_tp3.layouts.head')
<body>
  @include('frontend_tp3.layouts.header')
    <main class="main-content">
      <div class="sticky-container">
      <div class="banner-left">
          <img src="{{asset('/frontend_tp3/img/header-left.png')}}" alt="Tết Đậm Nét" />
      </div>
    </div>
      <div class="container">

     @yield('content')
      </div>
      
    
      <div class="sticky-container">
        <div class="banner-right">

            <img src="{{asset('/frontend_tp3/img/header-right.png')}}" alt="Trang trí Tết" />
        </div>
      </div>

     
  </main>

@include('frontend_tp3.layouts.footer')

@include('frontend_tp3.layouts.foot')
    
</body>
</html>
