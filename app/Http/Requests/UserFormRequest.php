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

    public function getValidatorInstance()
    {
        //プルダウンで選択された値(= 配列)を取得
        //デフォルト値は空の配列
        $datetime = $this->input('datetime', array());
        //dd($datetime);

        //日付を作成(ex. 2020-1-20)
        $datetime_validation = implode('-', $datetime);
        //dd($datetime_validation);

        // rules()に渡す値を追加する。
        //merge()とは、Requestデータを追加・上書きすること。
        $this->merge([
            'birth_day' => $datetime_validation,
        ]);

        //カスタムのバリデーションロジックの実行が成功し、その後にデフォルトのバリデーションロジックを実行するためのコード
        return parent::getValidatorInstance();
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
            'mail_address' => 'required|email|unique:users,mail_address|max:100',
            'sex' => 'required|in:1,2,3',
            'birth_day' => 'required|after:2000/1/1|before_or_equal:today|date',
            'role' => 'required|in:1,2,3,4',
            // 'subject' => 'required|in:1,2,3',
            'password' => 'required|min:8|max:30|alpha_num|confirmed',
        ];
    }

    public function messages() {
        return [
            'birth_day.date'  => "存在しない日付です。",
            'birth_day.after'  => "2000年1月1日以降の日付にしてください。",
            'birth_day.before_or_equal' => "今日よりも前の日付にしてください。",
        ];
    }
}
