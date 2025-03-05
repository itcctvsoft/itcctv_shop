<footer class="footer">
  <div class="footer-container">
      <div class="footer-top">
          <div class="footer-section">
            <div class="footer-title footer-mobile-title">
              <h4>Thông tin công ty</h4>
          </div>
          <div class="footer-contant">
              <div class="footer-logo"><img src="{{$detail->logo}}" alt=""></div>
              <h3>{{$detail->company_name}} </h3>
              <p>{{$detail->memory}}</p>
             
          </div>
          </div>
          <div class="footer-section">
              <h4 class="widget-title text-white !mb-3">THÔNG TIN CHI TIẾT</h4>
              <ul class="contact-list">
               
                <li><i class="fa fa-map-marker"></i>{{$detail->address}}
                </li>
                <li><i class="fa fa-phone"></i>
                Điện thoại: {{$detail->phone}}</li>
                <li><i class="fa fa-envelope"></i>Email: {{$detail->email}}</li>
                <li><i class="fa fa-book"></i>Mã số doanh nghiệp: {{$detail->mst}}</li>
                <li><i class="fa fa-book"></i>{{$detail->thoigiandk}}</li>
                <li><i class="fa fa-book"></i>{{$detail->nguoilienhe}}</li>
              </ul>
          </div>
          <div class="footer-section">
            <h4 class="widget-title text-white !mb-3">LIÊN KẾT HỮU ÍCH</h4>
            <ul class="pl-0 list-none   !mb-0">
                <li><a class="text_light_color" href="{{route('front.chinhsach.view','chinh-sach-bao-mat')}}">Chính sách bảo mật</a></li>
                <li><a class="text_light_color" href="{{route('front.chinhsach.view','dieu-khoan-va-quy-dinh')}}">Điều khoản và quy định</a></li>
                <li><a class="text_light_color" href="{{route('front.chinhsach.view','chinh-sach-hoan-tra')}}">Chính sách hoàn trả</a></li>
                <li><a class="text_light_color" href="{{route('front.chinhsach.view','chinh-sach-bao-hanh')}}">Chính sách bảo hành</a></li>
                <li><a class="text_light_color" href="{{route('front.chinhsach.view','chinh-sach-giao-van')}}">Chính sách giao vận</a></li>
                <li><a class="text_light_color"href="{{route('front.chinhsach.view','tai-khoan-cong-ty')}}">Tài khoản công ty</a></li>

            </ul>
          </div>
          <div class="footer-section">
            <h4 class="widget-title text-white !mb-3">Thông tin khác</h4>
            <ul class="pl-0 list-none   !mb-0">
              <li><a   href="{{route('front.profile')}}">Cập nhật hồ sơ</a></li>
              <li><a  href="{{route('front.shopingcart.view')}}">Giỏ hàng</a></li>
              <li><a   href="#">Đơn hàng</a></li>
              <li><a   href="#">Công nợ</a></li>
              <li><a class="text_light_color" href="{{route('front.contact')}}">Liên hệ</a></li>
            </ul>
            <div class="py-5 newsletter-wrapper">
                <nav class="nav social social-white " style="display: flex">
                  <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{$setting->facebook}}">
                    <img src="{{asset('frontend/assets/images/icon/facenho.png')}}" class=" "/>
                  </a>
                  <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{$setting->shopee}}">
                    <img src="{{asset('frontend/assets/images/icon/shopeenho.png')}}" class=" "/>
                  </a>
                  <a class="text-[#cacaca] text-[1rem] transition-all duration-[0.2s] ease-in-out translate-y-0 motion-reduce:transition-none hover:translate-y-[-0.15rem] m-[0_.7rem_0_0]" href="{{$setting->lazada}}">
                    <img src="{{asset('frontend/assets/images/icon/laznho.png')}}" class=" "/>
                  </a>
                </nav> 
            </div>
          </div>
      </div>
      <div class="footer-bottom">
          <p>&copy; 2025 BANME - đang xây dựng  </p>
      </div>
  </div>
</footer>