<?php
$tags = \DB::select('select * from tags where status = "active" order by hit desc limit 25');

?>

<div class="tag-section">
    <h3 class="tag-title">
        <span class="tag-icon">🍉</span>
        Mọi người cũng tìm kiếm
    </h3>
    <div class="tag-container">
        @foreach ($tags as $tag)
            <a href="{{route('front.tag.view',$tag->slug)}}" class="tag-item">{{$tag->title}}</a>
       @endforeach
    </div>
</div>