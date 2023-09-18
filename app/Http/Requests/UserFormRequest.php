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
            'over_name' => 'required|string|min:2|max:10',
            'under_name' => 'required|string|min:2|max:10',
            'over_name_kana' => 'required|string|min:2|max:30',
            'under_name_kana' => 'required|string|min:2|max:30',
            'mail_address' => 'required|string|email|min:5|max:100|unique:users',
            'password' => 'required|string|min:8|max:30|alpha_num|confirmed',
        ];
    }

}