<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        //dd($calendar);
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            //dd($getPart,$getDate);

            $reserveDays = array_filter(array_combine($getDate, $getPart));
            //dd($reserveDays);
            foreach($reserveDays as $key => $value){
                //▼$keyは選択した日付、$valueは選択したリモ部(1～3)
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                //dd($reserve_settings);
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    //=====================================
    //▼下記追加
    public function delete(Request $request){
        $cancel = $request->input('cancel');
        //dd($cancel);
        ReserveSettings::where('id', $cancel)->increment('limit_users', 1);
        $delete = ReserveSettings::find($cancel);
        //dd($delete);
        $delete->users()->detach(Auth::id());
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}
