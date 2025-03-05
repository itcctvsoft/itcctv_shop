 

    <nav class="breadcrumb-container">
      <ul class="breadcrumb">
          <li><a href="{{ route('home') }}">Trang chủ</a></li>
          @foreach ($links as $link )
            <li>
              @if ($link->url != '#')
                <a   href="{{$link->url}}">
              @endif
                {{$link->title}}
              @if ($link->url != '#')
                </a>
              @endif
              
            </li>
          @endforeach
      </ul>
    </nav>