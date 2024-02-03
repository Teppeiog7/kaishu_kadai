@extends('layouts.sidebar')

@section('content')
<!-- class m-auto、border削除 -->
<div class="board_area w-100 d-flex" style="margin-top:50px;">
  <!-- class mt-5削除 -->
  <div class="post_view w-75">
    <!-- <p class="w-75 m-auto">投稿一覧</p> -->
    @foreach($posts as $post)
    <!-- ▼追加 -->
    @foreach($post->subCategories as $post_subCategory)
    <!-- class border削除 -->
    <div class="post_area w-75 m-auto p-3" style="margin-top:2px;">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" class="post_title">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
          <div class="sub_category">
            <p><span>{{ $post_subCategory->sub_category }}</span></p>
          </div>
          <div class="count_content">
            <div class="mr-5">
              <div class="comment_area"></div>
              <i class="fa fa-comment" style="color: #999;"></i>
              <span class="">
                <span>{{$post->postComments->count()}}</span>
              </span>
            </div>
            <div>
              @if(Auth::user()->is_Like($post->id))
              <p class="m-0" style="color: #999;"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
              @else
              <p class="m-0" style="color: #999;"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $like->likeCounts($post->id) }}</span></p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <span style="display:block; height: 5px;"></span>
    @endforeach
  </div>
  <!-- css:▼border削除 -->
  <div class="other_area w-25">
    <!-- css:▼border、m-4削除 -->
    <div class="search_all">
      <a href="{{ route('post.input') }}" class="research">投稿</a>
      <div class="search_container">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <ul>
        <li style="display:flex; margin-top: 20px;">
          <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
          <span class="category_btn"></span>
          <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
        </li>
        <li style="margin-top: 20px;">カテゴリー検索</li>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}">
          <span>{{ $category->main_category }}<span>
        </li>
        @foreach($sub_categories as $sub_category)
        <!-- ▼追加 -->
        @if($sub_category->main_category_id === $category->id)
        <div class="category_num{{ $category->id }} sub_categories" style="display: none;">
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
@endsection
