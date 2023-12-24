<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormRequest extends FormRequest
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
    public function rules()
    {
        return [
            'main_category_name' => 'required|max:5|string|unique:main_categories,main_category',
            'main_category_id' => 'required|exists:main_categories,id',
        ];
    }

    public function messages(){
        return [
            'main_category_name.max' => '※最大文字数は100文字です。',
            'main_category_name.unique' => '入力したメインカテゴリーは重複しています。',
        ];
    }
}
