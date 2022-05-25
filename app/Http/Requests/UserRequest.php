<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $rules = [
            'user_name' => 'required|max:255',
            'cash' => 'integer',
        ];

        //更新用
        if ($this->id){
            $rules['steam_id'] = ['required', 'max:255', Rule::unique('users')->ignore($this->id)];
            $rules['login_id'] = ['required', 'max:255', Rule::unique('users')->ignore($this->id)];
            $rules['password'] = 'min:8|max:255|regex:/\A[a-z\d]{8,100}+\z/i';
        //新規登録用
        }else {
            $rules['steam_id'] = 'required|max:255|unique:users';
            $rules['login_id'] = 'required|max:255|unique:users';
            $rules['password'] = 'required|min:8|max:255|regex:/\A[a-z\d]{8,100}+\z/i';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'user_name.required' => 'ユーザー名は必須項目です。',
            'user_name.max' => 'ユーザー名は最大255文字以上まで入力可能です。',
            'steam_id.required' => 'Steam64IDは必須項目です。',
            'steam_id.max' => 'Steam64IDは最大255文字以上まで入力可能です。',
            'steam_id.unique' => 'Steam64IDが既に使用されています。',
            'login_id.required' => 'ログインIDは必須項目です。',
            'login_id.max' => 'ログインIDは最大255文字以上まで入力可能です。',
            'login_id.unique' => 'ログインIDは既に使用されています。',
            'password.required' => 'パスワードは必須項目です',
            'password.regex' => 'パスワードは８文字以上の英数字で登録してください。',
            'password.min' => 'パスワードは８文字以上の英数字で登録してください。',
            'cash.required' => 'ゲーム内キャッシュは数字で入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'message' => $validator->errors(),
        ], 400);
    }
}
