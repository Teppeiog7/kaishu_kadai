<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30',
            'under_name_kana' => 'required|string|max:30',
            'mail_address' => 'required|mail|unique:users,mail|max:100',
            // 'sex' => 'required',
            // 'birth_day' => 'required|date',
            // 'role' => 'required',
            'password' => 'required|min:8|max:30|alpha_num|confirmed',
        ];
    }

}
