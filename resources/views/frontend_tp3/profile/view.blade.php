@extends('frontend_tp3.layouts.master')
@section('topcss')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
 
<div class="account-container">
    <!-- Menu bên trái -->
    <aside class="account-menu">
        <ul>
            <li class="menu-item active">
                <a href="#">
                      Thông tin tài khoản
                </a>
            </li>
            <li class="menu-item ">
                <a href="{{route('front.profile.addressbook')}}">
                     Địa chỉ mua hàng
                </a>
            </li>
            
            <li class="menu-item">
                <a href="#">
                    <i class="icon-cart"></i> Giỏ hàng
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('front.profile.order')}}">
                    <i class="icon-history"></i> Lịch sử mua hàng
                </a>
            </li>
            <li class="menu-item">
                <a href="#">
                    <i class="icon-heart"></i> Danh sách yêu thích
                </a>
            </li>
        </ul>
    </aside>

    <!-- Nội dung chính -->
    <div class="account-details">
        <h3>Thông tin tài khoản</h3>
        <form method="POST" action = "{{route('front.profile.update')}}">
            @csrf
             <!-- Khu vực ảnh đại diện -->
            <div class="form-group" >
                <div class="avatar-preview">
                    <img src="{{auth()->user()->photo}}" alt="Avatar">
                </div>
                <div class="px-4 pb-4 mt-5 flex items-center  cursor-pointer relative">
                    <div data-single="true" id="mydropzone" class="dropzone"    url="{{route('upload.avatar')}}" >
                        <div class="fallback"> 
                            <input name="file" type="file" /> 
                        </div>
                        <div class="dz-message" data-dz-message>
                            <div class=" font-medium">
                                Kéo thả hoặc chọn ảnh.
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="photo" name="photo" value="{{$profile->photo}}"/>
                <div class="mx-auto cursor-pointer relative mt-5">
                    Cập nhật ảnh đại diện. Bổ trống nếu bạn không muốn thay đổi.
                </div>
            </div>
            <div class="form-group">
                <label for="fullName">Tên đầy đủ *</label>
                <input name="full_name"   type="text"  value="{{$profile->full_name}}" required />
            </div>
            <div class="form-group">
                <label for="phone">Điện thoại *</label>
                <input name="phone"    type="text"  value="{{$profile->phone}}" required />
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input name="email" disabled  type="email"  value="{{$profile->email}}" required />
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ *</label>
                <input name="address"   type="text"  value="{{$profile->address}}" required />
            </div>
            <div class="form-group full-width">
                <label for="bio">Mô tả *</label>
                <textarea id="bio" name="description" placeholder="Mô tả">{{$profile->description}}</textarea>
            </div>
            <button type="submit" class="btn-submit">Cập nhật</button>
        </form>
    </div>

   
</div>

@endsection
@section('footscript')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;
       
       // Dropzone class:
       var myDropzone = new Dropzone("div#mydropzone", { url: "{{route('front.upload.avatar')}}"});
           // previewsContainer: ".dropzone-previews",
           // Dropzone.instances[0].options.url = "{{route('upload.avatar')}}";
           Dropzone.instances[0].options.multiple = false;
           Dropzone.instances[0].options.autoQueue= true;
           Dropzone.instances[0].options.maxFilesize =  1; // MB
           Dropzone.instances[0].options.maxFiles =1;
           Dropzone.instances[0].options.dictDefaultMessage = 'Drop images anywhere to upload (6 images Max)';
           Dropzone.instances[0].options.acceptedFiles= "image/jpeg,image/png,image/gif";
           Dropzone.instances[0].options.previewTemplate =  '<div class=" d-flex flex-column  position-relative">'
                                           +' <img    data-dz-thumbnail >'
                                           
                                       +' </div>';
           // Dropzone.instances[0].options.previewTemplate =  '<li><figure><img data-dz-thumbnail /><i title="Remove Image" class="icon-trash" data-dz-remove ></i></figure></li>';      
           Dropzone.instances[0].options.addRemoveLinks =  true;
           Dropzone.instances[0].options.headers= {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')};
   
           Dropzone.instances[0].on("addedfile", function (file ) {
           // Example: Handle success event
           console.log('File addedfile successfully!' );
           });
           Dropzone.instances[0].on("success", function (file, response) {
           // Example: Handle success event
           // file.previewElement.innerHTML = "";
           if(response.status == "true")
           $('#photo').val(response.link);
           console.log('File success successfully!' +response.link);
           });
           Dropzone.instances[0].on("removedfile", function (file ) {
           $('#photo').val('');
           console.log('File removed successfully!'  );
           });
           Dropzone.instances[0].on("error", function (file, message) {
           // Example: Handle success event
           file.previewElement.innerHTML = "";
           console.log(file);
   
           console.log('error !' +message);
           });
           console.log(Dropzone.instances[0].options   );
   
           // console.log(Dropzone.optionsForElement);
   
   </script>
   

@endsection


 