<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        //Subjectsモデル(Subjectsデーブル)の情報をすべて抽出する。
        $subjects = Subjects::all();

        return view('auth.register.register', compact('subjects'));
    }

    //=====================================

    //▼バリデーション処理
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'over_name' => 'required|string|min:2|max:10',
            'under_name' => 'required|string|min:2|max:10',
            'over_name_kana' => 'required|string|min:2|max:10',
            'under_name_kana' => 'required|string|min:2|max:10',
            'mail_address' => 'required|string|email|min:5|max:40|unique:users',
            'password' => 'required|string|min:8|max:20|alpha_num|confirmed',
        ]);
    }

    //=====================================

    public function registerPost(Request $request)
    {

        if($request->isMethod('post')){
            $data = $request->input();
            //dd($data);
            $validator = $this->validator($data);
            //dd($validator);
            if($validator->fails()){//もしvalidatorメソッドが失敗したら
            return redirect('/register')//registerへリダイレクト
            ->withErrors($validator)
            ->withInput();
            }
        }

        //▼変数確認
        //dd($request);
        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            //▼変数確認
            //ddd($user_get);
            $user = User::findOrFail($user_get->id);
            //▼変数確認
            //ddd($user);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
