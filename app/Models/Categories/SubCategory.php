<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Posts\Post;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
        'sub_category_id',
        'post_id',
    ];
    public function mainCategory(){
        // リレーションの定義
        return $this->belongsTo('App\Models\Categories\mainCategory');
    }

    //▼追加
    public function posts(){
        // リレーションの定義(多対多)
        //第一引数：相手のモデル
        //第二引数：中間テーブルを記載
        //第三引数：自分の外部キー
        //第四引数：相手の外部キー
        return $this->belongsToMany('App\Models\Posts\Post','post_sub_categories','sub_category_id','post_id');
    }

    // public function post(){
    //     return $this->posts()->attach();
    // }

    //
    // public function postsSubcategories()
    // {
    //     //多対多
    //     return $this->belongsToMany(Post::class,);
    // }
}
