<?php

namespace App\Http\Controllers\Authenticated\Calendar\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\Admin\CalendarView;
use App\Calendars\Admin\CalendarSettingView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;
use Carbon\Carbon;//追加

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        //dd($calendar);
        return view('authenticated.calendar.admin.calendar', compact('calendar'));
    }

    public function reserveDetail($date, $part){
        //dd($date, $part);
        $reservePersons = ReserveSettings::with('users')->where('setting_reserve', $date)->where('setting_part', $part)->get();
        //▼追加
        $remote = "リモート";
        //▼追加
        $carbonDate = Carbon::parse($date);
        $formattedDate = $carbonDate->isoFormat('YYYY年MM月DD日');
        //dd($formattedDate, $part, $reservePersons);
        return view('authenticated.calendar.admin.reserve_detail', compact('reservePersons', 'formattedDate', 'part','remote'));
    }

    public function reserveSettings(){
        $calendar = new CalendarSettingView(time());
        //dd($calendar);
        return view('authenticated.calendar.admin.reserve_setting', compact('calendar'));
    }

    public function updateSettings(Request $request){
        //dd($request);
        $reserveDays = $request->input('reserve_day');
        //dd($reserveDays);
        foreach($reserveDays as $day => $parts){
            foreach($parts as $part => $frame){
                ReserveSettings::updateOrCreate([
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                ],[
                    'setting_reserve' => $day,
                    'setting_part' => $part,
                    'limit_users' => $frame,
                ]);
            }
        }
        return redirect()->route('calendar.admin.setting', ['user_id' => Auth::id()]);
    }
}
