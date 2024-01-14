<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;
use App\Models\Users\User;
use Auth;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();
    //dd($ymd); //年月日が入っている。
    //dd($one_part,$two_part,$three_part);

    $html[] = '<div class="text-left">';
    if($one_part){
      //▼追加
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => '1']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$url.'>1部:'.$one_part->users->count().'</a></p>';
      //▼下記方法でもカウント可能
      // $html[] = '<p class="day_part m-0 pt-1"><a href="calendar.admin.update">1部:'.ReserveSettings::with('users')->where('setting_reserve',$ymd)->whereHas('users', function ($query) {$query->where('setting_part','=', '1');})->count().'</a></p>';
    }
    if($two_part){
      //▼追加
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => '2']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$url.'>2部:'.$two_part->users->count().'</a></p>';
      //▼下記方法でもカウント可能
      // $html[] = '<p class="day_part m-0 pt-1"><a href="calendar.admin.update">2部:'.ReserveSettings::with('users')->where('setting_reserve',$ymd)->whereHas('users', function ($query) {$query->where('setting_part','=', '2');})->count().'</a></p>';
    }
    if($three_part){
      //▼追加
      $url = route('calendar.admin.detail', ['date' => $ymd, 'part' => '3']);
      $html[] = '<p class="day_part m-0 pt-1"><a href='.$url.'>3部:'.$three_part->users->count().'</a></p>';
      //▼下記方法でもカウント可能
      // $html[] = '<p class="day_part m-0 pt-1"><a href="calendar.admin.update">3部:'.ReserveSettings::with('users')->where('setting_reserve',$ymd)->whereHas('users', function ($query) {$query->where('setting_part','=', '3');})->count().'</a></p>';
    }
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="get" id="reserveParts">'.csrf_field().'</form>';


    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}
