<?php

namespace App\Http\Controllers\Authenticated\Top;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TopsController extends Controller
{
    public function show(){
        //ログインユーザーの情報を抽出する。
        $user = Auth::user();
        //dd($user);
        return view('authenticated.top.top',['user'=>$user]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
