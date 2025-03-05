@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
<section class="blog-container">
    <!-- Nội dung chính -->
    <div class="blog-main">
        <article class="blog-content">
            <h3>{{$blog->title}}</h3> 
            <div class="blog-detail">
                <?php 
                echo $blog->content;
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
           
                
            @include('frontend_tp3.layouts.mod_tags')
            @include('frontend_tp3.layouts.comment')
            @include('frontend_tp3.layouts.comment_form')
        </article>
    </div>

    <!-- Sidebar -->
    <aside class="blog-sidebar">
        <h3 class="sidebar-title">🍉 Bài viết mới</h3>
        <ul class="recent-posts">
            @foreach ($newblogs as $newblog)
            <li class="recent-post-item">
                <a href="{{ route('front.page.view', $newblog->slug) }}">
                    
                        <img src="{{ $newblog->photo ? $newblog->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $newblog->title }}">
                        <span class="recent-post-title">{{ $newblog->title }}</span>
                     
                </a>
            </li>
            @endforeach
           
        </ul>
        <br/>
        <h3 class="sidebar-title">🍉 Bài viết phổ biến</h3>
        <ul class="recent-posts">
            @foreach ($popblogs as $newblog)
            <li class="recent-post-item">
                <a href="{{ route('front.page.view', $newblog->slug) }}">
                    
                        <img src="{{ $newblog->photo ? $newblog->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $newblog->title }}">
                        <span class="recent-post-title">{{ $newblog->title }}</span>
                     
                </a>
            </li>
            @endforeach
        </ul>
        <br/>
        <h3 class="sidebar-title">🍉 Bài viết liên quan</h3>
        <ul class="recent-posts">
            @if($preblog && count ($preblog) > 0)
            <li class="recent-post-item">
                <a href="{{ route('front.page.view',$preblog[0]->slug) }}">
                    
                        <img src="{{ $preblog[0]->photo ?$preblog[0]->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $preblog[0]->title }}">
                        <span class="recent-post-title">{{ $preblog[0]->title }}</span>
                     
                </a>
            </li>
            @endif
            @if($nextblog && count ($nextblog) > 0)
            <li class="recent-post-item">
                <a href="{{ route('front.page.view',$nextblog[0]->slug) }}">
                    
                        <img src="{{ $nextblog[0]->photo ?$nextblog[0]->photo : asset('frontend/assets/images/blog/2.jpg') }}" alt="{{ $nextblog[0]->title }}">
                        <span class="recent-post-title">{{ $nextblog[0]->title }}</span>
                     
                </a>
            </li>
            @endif
        </ul>
    </aside>
</section>

@endsection
@section('footscript')
@endsection
 