<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\App;

class LoginRequest extends FormRequest
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
            'login_id' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        //英語対応
        if ($this->request->get('en') == 1){
            return [
                'login_id.required' => 'Login ID is required',
                'password.required' => 'Password is required',
            ];
        }
        return [
            'login_id.required' => 'ログインIDは必須です。',
            'password.required' => 'パスワードは必須です。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'message' => $validator->errors(),
        ], 400);
    }
}
