<?php

namespace App\Service;

use App\Models\ProvisionalUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProvisionalUserService
{
    public function search($data)
    {
        return ProvisionalUser::where('key', $data)->where('status', 0)->first();
    }

    public function createProvisionalUser($data, $key): int
    {
        $user = (new User())->fill($data);
        $user->password = Hash::make($data->password);
        $user->key = $key;

        if (!$user->save()){
            return 500;
        }

        return 200;
    }
}
