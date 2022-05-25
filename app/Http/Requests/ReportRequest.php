<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
        $types = ['cheat', 'banned'];
        $rules = [
            'type' => 'required',
            'detail' => 'required|max:200',
        ];

        //to_id必須
        if (in_array($this->type, $types)){
            $rules['to_id'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => 'カテゴリは必須項目です。',
            'detail.required' => '内容は必須項目です。',
            'detail.max' => '内容は最大200文字まで入力可能です。',
            'to_id.required' => '対象者を選択してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        return response()->json([
            'message' => $validator->errors(),
        ], 400);
    }
}
