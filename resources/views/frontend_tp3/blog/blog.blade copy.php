@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
<section class="section-blog">
    <article  >
        <div class='blog'>
            <div class='blog-center'>
                <div class="blog-detail">
                     <h3>{{$blog->title}}</h3> 
                
                    <?php 
                    // echo $blog->content;
                    ?>
                </div>

               <div > 
                    <div >
                        <?php
                            if($preblog && count ($preblog) > 0)
                            {
                            echo '  <h5>  <a class=" btn-solid me-3 page-link"
                            href="'.route('front.page.view',$preblog[0]->slug).'"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;'.$preblog[0]->title.'</a></h5> ';
                            }
                            ?>
                    </div>
                    <div >
                            <?php
                            if($nextblog && count ($nextblog) > 0)
                            {
                            echo '  <a class="btn-solid me-3 page-link"
                            href="'.route('front.page.view',$nextblog[0]->slug).'">'.$nextblog[0]->title.' &nbsp;&nbsp;<i class="fa fa-chevron-right"
                            aria-hidden="true"></i></a> ';
                            }
                        ?>
                    </div>
                </div>
               
                    
                @include('frontend.layouts.tag')
                @include('frontend.layouts.comment')
                @include('frontend.layouts.comment_form')
            </div>
            <div class="right-bar">
                <div class="blog-sidebar">
                    <div class="recent-blog-container">
                        <h4>Bài viết mới</h4>
                        <ul class="recent-blog">
                            @foreach ($newblogs as $newblog)
                            <li>
                                <a href="{{ route('front.page.view', $newblog->slug) }}">
                                    <div class="recent-item">
                                        <img src="{{ $newblog->photo ? $newblog->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $newblog->title }}">
                                        <h6>{{ $newblog->title }}</h6>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="theme-card" >
                        <h4>Bài viết nổi bật</h4>
                        <ul class="recent-blog">
                            @foreach ($popblogs as $newblog)
                            <li>
                                <a href="{{ route('front.page.view', $newblog->slug) }}">
                                    <div class="recent-item">
                                        <img src="{{ $newblog->photo ? $newblog->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $newblog->title }}">
                                        <h6>{{ $newblog->title }}</h6>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </article>
       
</section>
@endsection
@section('footscript')
@endsection
 