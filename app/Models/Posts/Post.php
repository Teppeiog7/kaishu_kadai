<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

use App\Models\Posts\Like;

use App\Models\Posts\postComments;

use App\Models\Categories\MainCategory;//追加

use App\Models\Categories\SubCategory;//追加



class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
        'created_at', //追加
        'sub_category',//追加
        'post_id',
        'sub_category_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    //   public function mainCategories() {
    //       return $this->hasMany('App\Models\Categories\MainCategory');
    //   }

    //▼追加
    public function subCategories(){
        // リレーションの定義(多対多)
        //第一引数：相手のモデル
        //第二引数：中間テーブルを記載
        //第三引数：自分の外部キー
        //第四引数：相手の外部キー
        return $this->belongsToMany('App\Models\Categories\SubCategory','post_sub_categories','post_id','sub_category_id');
    }

    // public function subCategory(){
    //     return $this->subCategories()->attach();
    // }


    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }

     //追加
       public function mainCategories() {
           return $this->hasMany('App\Models\Categories\MainCategory');
       }
}
