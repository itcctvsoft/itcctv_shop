<?php
            $cur_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $comments = \DB::select("select * from comments where url ='".$cur_url."' and status = 'active'");
          ?>
    <hr>
    @if (count($comments) > 0)

    <div id="comments" class="section-comment ">
        <h3 class="comment-header">{{count($comments)}} bình luận</h3>
     
            <ol id="singlecomments" class="commentlist">
                @foreach ($comments as $comment )
                <li class="comment ">
                    <div class="comment-header ">
                        <div class="flex items-center">
                            <figure class="rounded">
                                <img class="rounded" alt="image" src="https://via.placeholder.com/130x130">
                            </figure>
                            <div>
                                <h6 ><a href="#" class="title_color">{{$comment->name}}</a></h6>
                                <ul ">
                                    <li><i class="uil"></i>{{$comment->created_at}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p>{{$comment->content}}</p>
                </li>
                @endforeach
            </ol>
       
    </div>
    @endif