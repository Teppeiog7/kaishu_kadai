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

    //▼追加
    public function users(){
        // リレーションの定義(多対多)
        //第一引数：相手のモデル
        //第二引数：中間テーブルを記載
        //第三引数：自分の外部キー
        //第四引数：相手の外部キー
        return $this->belongsToMany('App\Models\Users\User','subject_users','subject_id','user_id');// リレーションの定義
    }
}
