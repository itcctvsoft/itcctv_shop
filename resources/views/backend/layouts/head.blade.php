
<meta charset="utf-8">
<link href="{{$detail->icon}}" rel="shortcut icon">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="GENERATOR" content="{{$detail->short_name}}" />
<meta name="keywords" content= "{{isset($keyword)?$keyword:$detail->keyword}}"/>
<meta name="description" content= "{{isset($description)?strip_tags($description):$detail->memory}}"/>
<meta name="author" content="{{$detail->short_name}}">
<title>{{$detail->company_name}}</title>
<!-- BEGIN: CSS Assets-->
<link rel="stylesheet" href="{{asset('backend/assets/dist/css/app.css')}}" />
<link rel="stylesheet" href="{{asset('backend/assets/vendor/css/bootstrap-switch-button.min.css')}}" > 
<link rel="stylesheet" href="https://itcctv-soft.s3.us-east-1.amazonaws.com/cdn/mydatepicker.css" > 
<!-- END: CSS Assets-->
<!-- <script src="{{asset('backend/assets/vendor/libs/jquery/jquery.js')}}"></script>  -->

 


@yield('css')
@yield('scriptop')