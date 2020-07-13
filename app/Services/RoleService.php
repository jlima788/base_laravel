<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public static function find($id)
    {
        return Role::where(["uuid" => $id])->firstOrFail();
    }
}
