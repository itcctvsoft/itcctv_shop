<?php
use Illuminate\Support\Str;
    $sql_rand_blog = "SELECT a.* , b.title as cat_title, b.slug as cat_slug from blogs a left join blog_categories b on a.cat_id = b.id where  a.status = 'active' and a.cat_id != 'null' order by id desc LIMIT 4";
    $new_blogs=   \DB::select($sql_rand_blog) ;
    $sql_rand_blog = "SELECT a.* , b.title as cat_title , b.slug as cat_slug from blogs a left join blog_categories b on a.cat_id = b.id where  a.status = 'active' and a.cat_id != 'null' order by hit desc LIMIT 4";
    $hot_blogs=   \DB::select($sql_rand_blog) ;
    // dd($new_blogs);
?>

<div class="news-section">
    <!-- Tiêu đề -->
    <div class="news-header">
        <h2 class="header-title">🍉 Bài viết</h2>   
        <div class="news-categories">
            <!-- Duyệt qua các danh mục -->
            
                <button 
                    class="news-category  active "
                    data-category="new">
                   Bài viết mới
                </button>
            
                
                <button 
                    class="news-category  "
                    data-category="hot">
                   Được quan tâm
                </button>
        </div>
    </div>

    <!-- Container bài viết -->
    <div class="news-container">
        <!-- Duyệt qua bài viết của danh mục mặc định -->
        @foreach ($new_blogs as $post)
            <div class="news-item" data-category="new">
                <div class="news-image">
                    <a href="{{route('front.page.view',$post->slug)}}" alt="{{ $post->cat_title }}"><img src="{{ $post->photo }}" alt="{{ $post->cat_title }}"></a>
                </div>
                <div class="news-badge">  <a href="{{route('front.category.view',$post->cat_slug)}}" >{{ $post->cat_title }}</a></div>
                <a href="{{route('front.page.view',$post->slug)}}" alt="{{ $post->cat_title }}"><h3 class="news-title">{{ Str::limit($post->title, 40)}}</h3></a>
                <p class="news-description">{{ Str::limit($post->summary, 100)}}</p>
            </div>
        @endforeach
        @foreach ($hot_blogs as $post)
        <div class="news-item" data-category="hot">
            <div class="news-image">
                <a href="{{route('front.page.view',$post->slug)}}" alt="{{ $post->cat_title }}"><img src="{{ $post->photo }}" alt="{{ $post->cat_title }}"></a>
            </div>
            <div class="news-badge"><a href="{{route('front.category.view',$post->cat_slug)}}" >{{ $post->cat_title }}</a></div>
            <a href="{{route('front.page.view',$post->slug)}}" alt="{{ $post->cat_title }}"><h3 class="news-title">{{ Str::limit($post->title, 40)}}</h3></a>
         
            <p class="news-description">{{ Str::limit($post->summary, 100)}}</p>
        </div>
        @endforeach
    </div>

    <a href="{{route('front.categories.view')}}" class="view-more">Xem thêm bài viết &raquo;</a>
</div>
