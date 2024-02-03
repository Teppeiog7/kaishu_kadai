@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <!-- class:w-50削除 -->
  <div class="m-auto h-75" style="width: 80%;">
    <!-- ▼追加 -->
    <h5><span>{{$formattedDate}}</span><span class="ml-3">{{$part}}部</span></h5>
    <!-- class:h-75削除 -->
    <div class="border reserve_list" style="background:#FFF; border-radius:5px; padding:10px;box-shadow: 0 0 3px gray;">
      <table class="" style="width: 100%;">
        <tr class="text-center" style="background:#03AAD2; color:#fff;" ;>
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        <!-- ▼追加 -->
        @foreach($reservePersons as $reservePerson)
        @foreach($reservePerson -> users as $user)
        <tr class="text-center">
          <td class="w-25">{{$user->id}}</td>
          <td class="w-25">{{$user->ovr_name}}{{$user->under_name}}</td>
          <td class="w-25">{{$remote}}</td>
        </tr>
        @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
