<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getUsers($search): array
    {
        return User::search($search)->get()->toArray();
    }

    public function searchWithLogin_Id($loginId)
    {
        return User::where('login_id', $loginId)->first();
    }

    public function searchWithSteam64Id($steam64Id)
    {
        return User::where('steam_id', $steam64Id)->first();
    }

    public function createUser($data): int
    {
        $user = (new User())->fill($data);

        if (isset($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        if (!$user->save()){
            return 500;
        }

        return 200;
    }

    public function updateUser(User $user, $data): int
    {
        if (!$user){
            return 404;
        }

        $user = $user->fill($data);

        if (isset($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        if (!$user->save()){
            return 500;
        }

        return 200;
    }

    public function updateUserStatus(User $user, $userStatus): int
    {
        if (!$user){
            return 404;
        }

        if ($userStatus == 0){
            $user->status = 0;
        }elseif ($userStatus == -1){
            $user->status = -1;
        }else {
            $user->status = -2;
        }

        if (!$user->save()){
            return 500;
        }

        return 200;
    }

    public function grantCash(User $user, int $cash): int
    {
        if (!$user){
            return 404;
        }

        $user->cash += $cash;

        if (!$user->save()){
            return 500;
        }

        return 200;
    }
}
