<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    public function users(){
        //SubjectsモデルはUserモデル(Userテーブル)の情報を属している
        return $this->belongsToMany('App\Models\Users\User');// リレーションの定義
    }
}