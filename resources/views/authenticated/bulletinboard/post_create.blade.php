@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
        <!-- サブカテゴリー表示 -->
        <!-- ▼追加 -->
        @foreach($sub_categories as $sub_category)
        @if($sub_category->main_category_id === $main_category->id)
        <option value="{{ $sub_category->id }}" label="{{ $sub_category->sub_category }}"></option>
        @endif
        @endforeach
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span><!-- エラーメッセージを表示 -->
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span><!-- エラーメッセージを表示 -->
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
  </div>
  @can('admin')
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      @error('main_category_name')
      <p style="color:red; font-weight:bold;">{{ $message }}</p> <!-- エラーメッセージを表示 -->
      @enderror
      <!-- ▼メインカテゴリー追加 -->
      <p class="" style="margin-top:20px">メインカテゴリー</p>
      <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
      <span style="display:block; height: 20px;"></span>
      <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      <!-- ▼サブカテゴリー追加 -->
      @error('sub_category_name')
      <p style="color:red; font-weight:bold;">{{ $message }}</p> <!-- エラーメッセージを表示 -->
      @enderror
      <p class="" style="margin-top:20px">サブカテゴリー</p>
      <form method="POST" action="/create/sub_category">
        @csrf
        <select name="main_category">
          @foreach($main_categories as $main_category)
          <option value="{{ $main_category->id }}" label="{{ $main_category->main_category }}"></option>
          @endforeach
        </select>
        <span style="display:block; height: 20px;"></span>
        <input type="text" name="sub_category_name">
        <span style="display:block; height: 20px;"></span>
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0">
      </form>
    </div>
  </div>
  @endcan
</div>
@endsection
