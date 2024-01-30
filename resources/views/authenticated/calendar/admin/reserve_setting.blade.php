@extends('layouts.sidebar')
@section('content')
<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center; border-radius:5px; margin: 0 auto; margin-top: 30px;">
  <div class="w-100 vh-100 border p-5" style="padding: 20px;">
    <div style="text-align: center; padding-top:30px; background:#FFF;  border-radius:10px; box-shadow: 0 0 3px gray; width: 80%;
  margin: 0 auto;">
      {{ $calendar->getTitle() }}
      {!! $calendar->render() !!}
      <div class="adjust-table-btn m-auto text-right">
        <input type="submit" class="btn btn-primary" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>
    </div>
  </div>
</div>
@endsection
