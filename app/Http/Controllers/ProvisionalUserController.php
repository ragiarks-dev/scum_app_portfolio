<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvisionalUserRequest;
use App\Service\ProvisionalUserService;
use Illuminate\Http\JsonResponse;

class ProvisionalUserController extends BaseController
{
    //アカウントの仮登録
    public function register(ProvisionalUserRequest $request): JsonResponse
    {
        $key = $this->generateCreateAccountKey();

        $status = (new ProvisionalUserService())->createProvisionalUser($request->only('login_id', 'password'), $key);

        if ($status == 200){
            if ($request->get('en') == 1){
                $this->response['messages'] = ['Successfully provisional registration'];
            }else{
                $this->response['messages'] = ['アカウントの仮登録に成功しました。'];
            }
            $this->response['result'] = [
                'key' => $key
            ];
        }else {
            if ($request->get('en') == 1){
                $this->response['errors'] = ['Provisional registration failed'];
            }else{
                $this->response['errors'] = ['アカウントの仮登録に失敗しました。'];
            }
        }

        return response()->json($this->response, $status);
    }

    //アカウント作成用鍵の生成
    private function generateCreateAccountKey(): string
    {
        return 'createaccount!' . substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 24);
    }
}
