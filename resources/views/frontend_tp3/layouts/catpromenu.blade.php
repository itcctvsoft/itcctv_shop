<?php
    $cats = \App\Models\Category::where('status','active')->where('parent_id',null)->orderBy('title','asc')->get();
    if(!isset($slug))
        $slug = '';  
?>
<?php
  
  foreach ($cats as $cat)
  {
      $sql = "select count(id) as tong from products where cat_id = ".$cat->id;
      $re = \DB::select($sql);
      $cat->sobai = $re[0]->tong;
  }
  ?>


    <h3>Danh mục sản phẩm</h3>
    <ul class="category-list">
       
        <li><a href="{{route('front.product.hot')}}" data-category="all" class="{{$slug==''?'active':''}}">Tất cả</a></li>
        @foreach ($cats as $cat )
        <li><a href="{{route('front.product.cat',$cat->slug)}}" class="{{$slug==$cat->slug?'active':''}}" >{{$cat->title}}</a></li>
        @endforeach
       
    </ul>


 