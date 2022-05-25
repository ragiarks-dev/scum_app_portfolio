<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;

class UserController extends BaseController
{
    private UserService $userService;

    #[Pure] public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function index(Request $request): JsonResponse
    {
        $users = $this->userService->getUsers($request->get('search'));
        $this->response['result'] = [
            'users' => $users
        ];

        return response()->json($this->response);
    }

    public function store(UserRequest $request): JsonResponse
    {
        $status = $this->userService->createUser($request->all());

        return response()->json($this->response, $status);
    }

    public function update(User $user, UserRequest $request): JsonResponse
    {
        $status = $this->userService->updateUser($user, $request->all());

        return response()->json($this->response, $status);
    }

    public function grantCash(User $user, Request $request): JsonResponse
    {
        //ゲーム内キャッシュの付与
        $status = $this->userService->grantCash($user, $request->get('cash'));

        return response()->json($this->response, $status);
    }

    public function revive(User $user): JsonResponse
    {
        //ユーザーステータスを正常に更新
        $status = $this->userService->updateUserStatus($user, 0);

        return response()->json($this->response, $status);
    }

    public function restrict(User $user): JsonResponse
    {
        //ユーザーステータスを制限に更新
        $status = $this->userService->updateUserStatus($user, -1);

        return response()->json($this->response, $status);
    }

    public function ban(User $user): JsonResponse
    {
        //ユーザーステータスをBANに更新
        $status = $this->userService->updateUserStatus($user, -2);

        return response()->json($this->response, $status);
    }

    //スカムサーバーからBAN
    private function banFromScumServer(): bool
    {

    }

    //スカムサーバーからBAN解除
    private function unBanFromScumServer(): bool
    {

    }
}
