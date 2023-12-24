<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // ▼追加
    public function rules()
    {
        return [
             'sub_category_name' => 'required|max:100|string|unique:sub_categories,sub_category',
        ];
    }

     public function messages(){
        return [
            'sub_category_name.max' => '※最大文字数は100文字です。',
            'sub_category_name.unique' => '入力したサブカテゴリーは重複しています。',
        ];
    }
}
