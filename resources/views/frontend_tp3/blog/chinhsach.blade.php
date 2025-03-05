@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
<section class="section-blog">
    <article  >
        <div  >
            <h2 class="blog-title">{{$blog->title}}</h2>
            <?php
                echo $blog->content;
            ?>
        </div>
    </article>
       
</section>
@endsection
@section('footscript')
@endsection