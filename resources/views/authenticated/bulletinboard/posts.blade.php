@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <!-- ▼追加 -->
    @foreach($post->subCategories as $post_subCategory)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post_subCategory->sub_category }}</span></p>
      @endforeach
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="mr-5">
            <div class="comment_area border-top"></div>
            <i class="fa fa-comment"></i>
            <span class="">
              <span>{{$post->postComments->count()}}</span>
            </span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <ul>
        <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
        @foreach($sub_categories as $sub_category)
        <!-- ▼追加 -->
        @if($sub_category->main_category_id === $category->id)
        <div class="category_num{{ $category->id }}" style="display: none;">
          <a href="{{ route('post.show', ['sub_category_word' => $sub_category->sub_category]) }}" name="sub_category_word" form="postSearchRequest">{{ $sub_category->sub_category }}</a>
        </div>
        <!-- <li class="main_categories" category_id="{{ $category->id }}" name="category_word">{{ $sub_category->sub_category }}</li> -->
        @endif
        @endforeach
        @endforeach
        <!-- <input type="submit" name="my_posts" class="category_btn" value="参考書" form="postSearchRequest"> -->
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
<!-- <script>
//初期表示は非表示
document.getElementById("sub").style.display = "none";

function clickBtn1() {
  const sub = document.getElementById("sub");

  if (sub.style.display == "block") {
    // noneで非表示
    sub.style.display = "none";
  } else {
    // blockで表示
    sub.style.display = "block";
  }
}
</script> -->
@endsection
