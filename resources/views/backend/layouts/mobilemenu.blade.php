<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="" class="flex mr-auto">
            <img alt="Midone - HTML Admin Template" class="w-6" src="{{asset('backend/assets/dist/images/logo.svg')}}">
        </a>
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
    </div>
    <div class="scrollable">
        <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
                
    
<ul>
        <li>
            <a href="{{route('admin')}}" class="menu menu{{$active_menu=='dashboard'?'--active':''}}">
                <div class="menu__icon"> <i data-lucide="home"></i> </div>
                <div class="menu__title"> Dashboard </div>
            </a>
        </li> 
       <!-- Blog -->
        <li>
          <a href="javascript:;.html" class="menu menu{{($active_menu=='tag_list'|| $active_menu=='tag_add'||$active_menu=='blog_list'|| $active_menu=='blog_add'||$active_menu=='blogcat_list'|| $active_menu=='blogcat_add' )?'--active':''}}">
              <div class="menu__icon"> <i data-lucide="align-center"></i> </div>
              <div class="menu__title">
                  Bài viết
                  <div class="menu__sub-icon transform"> <i data-lucide="chevron-down"></i> </div>
              </div>
          </a>
          <ul class="{{($active_menu=='tag_list'|| $active_menu=='tag_add'||$active_menu=='blog_list'|| $active_menu=='blog_add'||$active_menu=='blogcat_list'|| $active_menu=='blogcat_add')?'menu__sub-open':''}}">
              <li>
                  <a href="{{route('blog.index')}}" class="menu {{$active_menu=='blog_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="compass"></i> </div>
                      <div class="menu__title">Danh sách bài viết </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('blog.create')}}" class="menu {{$active_menu=='blog_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm bài viết</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('tag.index')}}" class="menu {{$active_menu=='tag_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="anchor"></i> </div>
                      <div class="menu__title">Tags </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('blogcategory.index')}}" class="menu {{$active_menu=='blogcat_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="hash"></i> </div>
                      <div class="menu__title">Danh mục bài viết </div>
                  </a>
              </li>
        </ul>
    </li>
    <li>
            <a href="{{route('comment.index')}}" class="menu {{$active_menu=='comment_list'||$active_menu=='comment_add'?'menu--active':''}}">
                <div class="menu__icon"> <i data-lucide="package"></i> </div>
                <div class="menu__title"> Bình luận</div>
            </a>
        
      </li> 
   
      <li>
        <?php
            $reg_totals = \DB::select("select count(id) as tong from orders where status = 'pending'");
            $reg_total = $reg_totals[0]->tong;
        ?>
          <a href="javascript:;" class="menu  class="menu {{($active_menu=='or_list' || $active_menu=='customer_list'|| $active_menu=='wo_list'|| $active_menu=='wo_add'|| $active_menu=='delivery_list'    )?'menu--active':''}}">
              <div class="menu__icon"> <i data-lucide="shopping-cart"></i> </div>
              <div class="menu__title">
                  Quản lý bán hàng
                  @if ($reg_total > 0)
                            <div style="margin-top:-0.5rem"> &nbsp;
                                <span class="text-xs px-1 rounded-full bg-success text-white mr-1">{{$reg_total}}</span>
                            </div>
                        @endif

                  <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
              </div>
          </a>
          <ul class="{{($active_menu=='or_list'  )?'menu__sub-open':''}}">
               
             
              <li>
                  <a href="{{route('order.index')}}" class="menu {{$active_menu=='or_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="shopping-cart"></i> </div>
                      <div class="menu__title"> Đơn đặt hàng
                        @if ($reg_total > 0)
                        <div style="margin-top:-0.5rem"> &nbsp;
                            <span class="text-xs px-1 rounded-full bg-success text-white mr-1">{{$reg_total}}</span>
                        </div>
                        @endif

                      </div>
                  </a>
              </li>
             
             
          </ul>
      </li>
 
      <!-- product category menu -->
      <li>
          <a href="javascript:;" class="menu {{($active_menu =='pro_add'|| $active_menu=='pro_list' || $active_menu =='brand_list' || $active_menu == 'brand_list' || $active_menu=='cat_add'|| $active_menu=='cat_list')?'menu--active':''}}">
              <div class="menu__icon"> <i data-lucide="box"></i> </div>
              <div class="menu__title">
                  Hàng hóa 
                  <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
              </div>
          </a>
            <ul class="{{($active_menu =='pro_add'|| $active_menu=='pro_list' || $active_menu =='cat_add'|| $active_menu=='cat_list' || $active_menu =='brand_list' || $active_menu == 'brand_list')?'menu__sub-open':''}}">
              <li>
                  <a href="{{route('product.index')}}" class="menu {{$active_menu=='pro_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="list"></i> </div>
                      <div class="menu__title">Danh sách hàng hóa</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('product.create')}}" class="menu {{$active_menu=='pro_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm hàng hóa</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('category.index')}}" class="menu {{$active_menu=='cat_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="archive"></i> </div>
                      <div class="menu__title"> Danh sách danh mục </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('category.create')}}" class="menu {{$active_menu=='cat_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm danh mục </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('brand.index')}}" class="menu {{$active_menu=='brand_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="package"></i> </div>
                      <div class="menu__title"> Ds nhà sản xuất </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('brand.create')}}" class="menu {{$active_menu=='brand_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm nhà sản xuất </div>
                  </a>
              </li>
          </ul>
      </li>
      <!-- Nguoi dung menu  -->
      <li>
          <a href="javascript:;" class="menu  class="menu {{($active_menu =='ugroup_add'|| $active_menu=='ugroup_list' || $active_menu =='ctm_add'|| $active_menu=='ctm_list'  )?'menu--active':''}}">
              <div class="menu__icon"> <i data-lucide="user"></i> </div>
              <div class="menu__title">
                  Người dùng 
                  <div class="menu__sub-icon "> <i data-lucide="chevron-down"></i> </div>
              </div>
          </a>
          <ul class="{{($active_menu =='ugroup_add'|| $active_menu=='ugroup_list' || $active_menu =='ctm_add'|| $active_menu=='ctm_list')?'menu__sub-open':''}}">
              <li>
                  <a href="{{route('user.index')}}" class="menu {{$active_menu=='ctm_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="users"></i> </div>
                      <div class="menu__title">Danh sách người dùng</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('user.create')}}" class="menu {{$active_menu=='ctm_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm người dùng</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('ugroup.index')}}" class="menu {{$active_menu=='ugroup_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="circle"></i> </div>
                      <div class="menu__title">Ds nhóm người dùng</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('ugroup.create')}}" class="menu {{$active_menu=='ugroup_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm nhóm người dùng</div>
                  </a>
              </li>
          </ul>
      </li>
    
 
   
    <!-- setting menu -->
    <li>
        <a href="javascript:;.html" class="menu menu{{($active_menu=='cmdfunction_list'||$active_menu=='cmdfunction_add'||$active_menu=='role_list'||$active_menu=='role_add'||$active_menu=='kiot'|| $active_menu=='setting_list'|| $active_menu=='log_list'||$active_menu=='banner_add'|| $active_menu=='banner_list')?'--active':''}}">
              <div class="menu__icon"> <i data-lucide="settings"></i> </div>
              <div class="menu__title">
                  Cài đặt
                  <div class="menu__sub-icon transform"> <i data-lucide="chevron-down"></i> </div>
              </div>
        </a>
        <ul class="{{($active_menu=='cmdfunction_list'||$active_menu=='cmdfunction_add'||$active_menu=='role_list'||$active_menu=='role_add'||$active_menu=='kiot'|| $active_menu=='setting_list'|| $active_menu=='banner_add'|| $active_menu=='banner_list')?'menu__sub-open':''}}">
              <li>
                  <a href="{{route('banner.index')}}" class="menu {{$active_menu=='banner_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="image"></i> </div>
                      <div class="menu__title">Danh sách banner </div>
                  </a>
              </li>
              <li>
                  <a href="{{route('banner.create')}}" class="menu {{$active_menu=='banner_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Thêm banner</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('role.index',1)}}" class="menu {{$active_menu=='role_list'||$active_menu=='role_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="octagon"></i> </div>
                      <div class="menu__title"> Roles</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('cmdfunction.index',1)}}" class="menu {{$active_menu=='cmdfunction_list'||$active_menu=='cmdfunction_add'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="moon"></i> </div>
                      <div class="menu__title"> Chức năng</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('setting.edit',1)}}" class="menu {{$active_menu=='setting_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="key"></i> </div>
                      <div class="menu__title"> Thông tin công ty</div>
                  </a>
              </li>
              <li>
                  <a href="{{route('log.index')}}" class="menu {{$active_menu=='log_list'?'menu--active':''}}">
                      <div class="menu__icon"> <i data-lucide="plus"></i> </div>
                      <div class="menu__title"> Nhật ký</div>
                  </a>
              </li>
              
          </ul>
    </li>
</ul>
    </div>
</div>