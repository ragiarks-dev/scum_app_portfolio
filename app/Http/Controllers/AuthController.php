<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;

class AuthController extends BaseController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'login_id' => $request->get('login_id'),
            'password' => $request->get('password'),
        ];

        if (Auth::attempt($credentials)) {
            $status = 200;
            if ($request->get('en') == 1){
                $this->response['messages'] = ['Login successfully'];
            }else{
                $this->response['messages'] = ['ログインに成功しました。'];
            }
        } else {
            $status = 401;
            if ($request->get('en') == 1){
                $this->response['errors'] = ['Login Failed'];
            }else{
                $this->response['errors'] = ['ログインに失敗しました。'];
            }
        }

        return response()->json($this->response, $status);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            Session::flush();
            $status = 200;
            if ($request->get('en') == 1){
                $this->response['messages'] = ['Successfully logged out'];
            }else{
                $this->response['messages'] = ['ログアウトに成功しました。'];
            }
        } catch (Exception $ex) {
            $status = 500;
            if ($request->get('en') == 1){
                $this->response['errors'] = ['Logout failed'];
            }else{
                $this->response['errors'] = ['ログアウトに失敗しました。'];
            }
        }

        return response()->json($this->response, $status);
    }
}
