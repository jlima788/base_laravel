<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\UserPasswordRule;
use App\Services\ProfileService;
use BRCas\Laravel\Traits\Controllers\Api\ApiStore;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    use ApiStore;

    public function service()
    {
        return ProfileService::class;
    }

    public function model()
    {
        return User::class;
    }

    public function resourceCollection()
    {
        return $this->resource();
    }

    public function resource()
    {
        return UserResource::class;
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        return view('admin.profile.edit', compact('user'));
    }

    public function rulesPost()
    {
        $id = auth()->user()->id;

        $retorno = [
            'name' => ['required', 'string', 'max:' . config('default.string')],
            'email' => [
                'required',
                'string',
                'email',
                'max:' . config('default.string'),
                "unique:users,email,{$id},id,deleted_at,NULL"
            ],
            'your_password' => ['required', 'string'],
            'photo' => 'mimes:jpeg,gif,png'
        ];

        if (!empty($this->request->input('password'))) {
            $retorno += [
                'password' => 'required|confirmed|min:8',
            ];
        }
        return $retorno;
    }

    public function route()
    {
        return route('admin.user.profile.index');
    }
}
