@extends('frontend_tp3.layouts.master')
@section('topcss')
@endsection
@section('content')
@include('frontend_tp3.layouts.breadcrumb')
 
<div class="news-category-container">
    <!-- News Content Section -->
    <div class="news-main">
  
        <div class="news-list">
            @foreach ($blogs as $blog)
            <article class="news-item">
                <a href="{{route('front.page.view',$blog->slug)}}"  > 
                    <img src="{{$blog->photo}}" alt="{{$blog->title}}">
                </a>
                <div class="news-info">
                    <h2>{{$blog->title}}</h2>
                    <p>{{$blog->summary}}</p>
                    <a href="{{route('front.page.view',$blog->slug)}}" class="read-more">Đọc thêm</a>
                </div>
            </article>
            @endforeach
        </div>
        <nav class="flex pagination-container" aria-label="pagination" class="">
            <!-- /.pagination -->
            {{$blogs->links('vendor.pagination.simple-new')}}
        </nav>
    </div>

    <!-- Sidebar Section -->
    <aside class="news-sidebar">
        <div class="sidebar-section">
            <h3>🍉 Danh mục tin tức</h3>
            <ul class="sidebar-section-br">
                @foreach($cats as $cat)
                <li><a href="{{route('front.category.view',$cat->slug)}}">{{$cat->title}}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="sidebar-section">
            <h3>🍉 Bài viết mới</h3>
            <div class="featured-posts">
                <ul class="featured-post-list">
                    <!-- Bài viết 1 -->
                    @foreach($newblogs as $blog)
                    <li class="featured-post-item">
                        <a href="#">
                            <img src="{{$blog->photo}}" alt="{{$blog->title}}">
                            <span class="featured-post-title">{{$blog->title}}</span>
                        </a>
                    </li>
                   @endforeach
                </ul>
            </div>
            <h3>🍉 Bài viết nổi bật</h3>
            <div class="featured-posts">
                <ul class="featured-post-list">
                    <!-- Bài viết 1 -->
                    @foreach($popblogs as $blog)
                    <li class="featured-post-item">
                        <a href="#">
                            <img src="{{$blog->photo}}" alt="{{$blog->title}}">
                            <span class="featured-post-title">{{$blog->title}}</span>
                        </a>
                    </li>
                   @endforeach
                </ul>
            </div>
        </div>
    </aside>
</div>

@endsection
@section('footscript')
 

@endsection


  