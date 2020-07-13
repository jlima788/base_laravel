<?php

namespace App\Services;

use App\Models\Store;

class StoreService
{
    public static function store($data)
    {
        if (auth()->user()->staf == false) {
            abort(403);
        }

        return Store::create($data);
    }

    public static function put(Store $obj, $data)
    {
        if (auth()->user()->staf == false) {
            abort(403);
        }

        return $obj->update($data);
    }
}
