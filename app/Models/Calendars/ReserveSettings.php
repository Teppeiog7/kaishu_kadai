<?php

namespace App\Models\Calendars;

use Illuminate\Database\Eloquent\Model;

class ReserveSettings extends Model
{
    const UPDATED_AT = null;
    public $timestamps = false;

    protected $fillable = [
        'setting_reserve',
        'setting_part',
        'limit_users',
    ];

    public function users(){
        // リレーションの定義(多対多)
        //第一引数：相手のモデル
        //第二引数：中間テーブルを記載
        //第三引数：自分の外部キー
        //第四引数：相手の外部キー
        return $this->belongsToMany('App\Models\Users\User', 'reserve_setting_users', 'reserve_setting_id', 'user_id')->withPivot('reserve_setting_id', 'id');
    }
}
