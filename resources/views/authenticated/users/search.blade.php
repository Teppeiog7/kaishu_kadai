@extends('layouts.sidebar')

@section('content')
<!-- <p>ユーザー検索</p> -->
<div class="search_content w-100 d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <!-- class:border削除 -->
    <div class="one_person">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div>
        <span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}" id="search_name">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @else
        <span>性別 : </span><span>女</span>
        @endif
      </div>
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        <span>選択科目 :</span>
        <span>
          @if($user->role == 4)
          <!-- ▼追加 -->
          @foreach($user->subjects as $subject_name)
          {{ $subject_name->subject }}
          @endforeach
          @endif
        </span>
      </div>
    </div>
    @endforeach
  </div>
  <!-- class:border削除 -->
  <div class="search_area w-25">
    <div class="" style="width: 80%; margin: 50px auto 0;">
      <h3>検索</h3>
      <div>
        <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">
      </div>
      <div style="margin-top: 20px;">
        <h5>カテゴリ</h5>
        <select form="userSearchRequest" name="category">
          <option value="name">名前</option>
          <option value="id">社員ID</option>
        </select>
      </div>
      <div style="margin-top: 20px;">
        <h5>並び替え</h5>
        <select name="updown" form="userSearchRequest">
          <option value="ASC">昇順</option>
          <option value="DESC">降順</option>
        </select>
      </div>
      <div class="add_search" style="margin-top: 20px;">
        <h5><p class="m-0 search_conditions">検索条件の追加</p></h5>
        <div class="search_conditions_inner">
          <div style="padding-top: 5%;">
            <label>性別</label>
            <div>
              <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest">
              <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest">
              <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
            </div>
          </div>
          <div style="padding-top: 5%;">
            <label>権限</label>
            <br>
            <select name="role" form="userSearchRequest" class="engineer">
              <option selected disabled>----</option>
              <option value="1">教師(国語)</option>
              <option value="2">教師(数学)</option>
              <option value="3">教師(英語)</option>
              <option value="4" class="">生徒</option>
            </select>
          </div>
          <div class="selected_engineer" style="padding-top: 5%;">
            <label>選択科目</label>
            <!-- ▼追加 -->
            <ul>
              <li style="display: flex;">
                @foreach($subjects as $subject)
                <div class="selected_subjects">
                  <label>{{ $subject->subject }}</label>
                  <input type="checkbox" name="subject[]" value="{{ $subject->id }}" form="userSearchRequest">
                </div>
                @endforeach
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div>
        <input type="submit" name="search_btn" value="検索" form="userSearchRequest" class="research_btn">
      </div>
      <div class="search_reset">
        <a href="" form="userSearchRequest">リセット</a>
      </div>
    </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>
@endsection
