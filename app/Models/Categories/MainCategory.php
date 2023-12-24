<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;//追加



class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
        // リレーションの定義
        return $this->hasMany('App\Models\Categories\SubCategory');
    }

    //追加
    //MainCategoryモデル(main_categoriesテーブル)はUserテーブルに属している。
     public function user(){
         return $this->belongsTo('App\Models\Users\User');
     }

     //追加
     //MainCategoryモデル(main_categoriesテーブル)はPPostテーブルに属している。
     public function posts(){
        return $this->belongsTo('App\Models\Posts\Post');
    }
}
