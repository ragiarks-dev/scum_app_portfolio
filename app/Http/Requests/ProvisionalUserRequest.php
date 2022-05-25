<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProvisionalUserRequest extends FormRequest
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
            'login_id' => 'required|unique:users|max:255',
            'password' => 'required|regex:/\A[a-z\d]{8,100}+\z/i|min:8|max:255|confirmed',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        //英語対応
        if ($this->request->get('en') == 1){
            return [
                'login_id.required' => 'Login ID is required',
                'login_id.unique' => 'Login ID is already use',
                'login_id.max' => 'Login ID can be up to 255 alphanumerical characters',
                'password.required' => 'Password is required',
                'password.regex' => 'Please register the password with at least 8 alphanumerical characters',
                'password.min' => 'Please register the password with at least 8 alphanumerical characters',
                'password.max' => 'Password can be up to 255 alphanumerical characters',
                'password.confirmed' => 'Passwords do not match',
                'password_confirmation.required' => 'Confirmation password is required',
            ];
        }
        return [
            'login_id.required' => 'ログインIDは必須項目です。',
            'login_id.unique' => 'ログインIDは既に使用されています。',
            'login_id.max' => 'ログインIDは255文字までの英数字登録してください。',
            'password.required' => 'パスワードは必須項目です',
            'password.regex' => 'パスワードは８文字以上の英数字で登録してください。',
            'password.min' => 'パスワードは８文字以上の英数字で登録してください。',
            'password.max' => 'パスワードは255文字までの英数字登録してください。',
            'password.confirmed' => 'パスワードが一致していません。',
            'password_confirmation.required' => '確認用パスワードは必須項目です。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'message' => $validator->errors(),
        ], 400);
    }
}
