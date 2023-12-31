<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;//バリデーション処理の為追加
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

    //=====================================

    public function registerView()
    {
        //Subjectsモデル(Subjectsデーブル)の情報をすべて抽出する。
        $subjects = Subjects::all();

        return view('auth.register.register', compact('subjects'));
    }

    //=====================================

    public function registerPost(UserFormRequest $request)
    {
        //dd($request);
        //UserFormRequestでバリデーション処理後の情報を配列として用意する。
        $validated = $request->validated();
        //dd($validated);

        DB::beginTransaction();//Transactionメソッドとは。複数の処理を一個にまとめもの
        try{
            // $old_year = $request->old_year;
            // $old_month = $request->old_month;
            // $old_day = $request->old_day;
            $birth_day =$validated['birth_day'];//$validatedのキー名:birth_dayにある値を抽出する。
            // $birth_day = date('Y-m-d', strtotime($data));
            //dd($birth_day);

            $subjects = $request->subject;
            //dd($subjects);


            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                // 'subject' => $request->subject,
                'password' => bcrypt($request->password)
            ]);
            //ddd($user_get);
            $user = User::findOrFail($user_get->id);
            //ddd($user);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }

    //=====================================
}
