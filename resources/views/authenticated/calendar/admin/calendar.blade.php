@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto" style="border-radius:5px; background:#FFF;">
  <div class="w-100" style="padding: 20px; margin-top: 30px; border-radius:10px; box-shadow: 0 0 3px gray;">
    <p style="text-align: center; padding-top:30px;">{{ $calendar->getTitle() }}</p>
    <p>{!! $calendar->render() !!}</p>
  </div>
</div>
@endsection
