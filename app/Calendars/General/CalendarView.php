<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th class="day-sat">土</th>';
    $html[] = '<th class="day-sun">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    //dd($weeks);


    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      //dd($days);
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");
        //dd($toDay);

        //▼$startDay:01/01
        //▼$toDay:本日の日付
        //▼$day:月の日付すべて
        if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){
          //▼追加:cssの「past-day border」を追加
          $html[] = '<td class="calendar-td past-day border '.$day->getClassName().'">';
        }else{
          $html[] = '<td class="border '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){ //予約していたら
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          //dd($reservePart);
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }
          if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){//過去だったら
            $html[] = '<p class="m-auto p-0 w-75 day-sat day-sun" style="font-size:12px"></p>';
            //▼追加
            $html[] = '<p class="text-black">'.$reservePart.'参加</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }else{//未来だったら ▼追加 属性:part
            $html[] = '<button type="submit" class="btn btn-danger p-0 w-75" name="reserve_date" style="font-size:12px" value01="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'" part='.$reservePart.' value02="'.$day->authReserveDate($day->everyDay())->first()->id.'">'.$reservePart.'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value02="'.$day->authReserveDate($day->everyDay())->first()->id.'" form="reserveParts">';
            //▼追加:モーダル機能、追加:80行目、82行目
            $html[] = '<div class="modal js-modal">';
            $html[] = '<div class="modal__bg js-reserve-close"></div>';
            $html[] = '<div class="modal__content">';
            $html[] = '<div style="display: block; text-align: left; width: 60%; margin: 0 auto;" >';
            $html[] = '<div class="text-black" style="">';
            $html[] = '<div form="deleteParts" class="modal_reserve_date"></div>';
            $html[] = '<br>';
            $html[] = '<div form="deleteParts" class="modal_part"></div>';
            $html[] = '<br>';
            // $html[] = '<div form="deleteParts" class="modal_id_date"></div>';
            $html[] = '<p>上記の予約をキャンセルしてもよろしいですか？</p>';
            $html[] = '</div>';
            $html[] = '</div>';
            $html[] = '<div style="display:flex; width: 60%; margin: 0 auto; position: relative;">';
            $html[] = '<button class="js-reserve-close btn btn-primary d-block" href="">閉じる</button>';
            $html[] = '<input type="submit" name="delete_date" style="" class="btn_cancel" value="キャンセル" form="deleteParts">';
            $html[] = '</div>';
            //▼追加 属性:class
            $html[] = '<input type="hidden" name="cancel" form="deleteParts" class="modal_id_date">';
            $html[] = '</div>';
            $html[] = '</div>';
          }
        }else{
          //▼追加
          //予約していないエリア
           if($startDay <= $day->everyDay() && $toDay > $day->everyDay()){//過去だったら
           $html[] = '<p class="text-black">受付終了</p>';
           $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
           }else{//未来だったら
           $html[] = $day->selectPart($day->everyDay());
           }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }

  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
