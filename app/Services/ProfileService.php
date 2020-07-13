<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;

class ProfileService
{
    public static function store(User $user, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = app('hash')->make($data['password']);
        }

        if (request()->file('photo')) {
            $data += [
                "photo" => request()->file('photo'),
            ];
        }

        $objUser = $user->find(auth()->user()->id);
        $objUser->update($data);

        return new UserResource($objUser);
    }
}
