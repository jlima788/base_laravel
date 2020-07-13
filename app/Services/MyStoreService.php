<?php

namespace App\Services;

use App\Models\Store;

class MyStoreService
{

    public static function put(Store $store, $data)
    {
        if ($store->id != auth()->user()->store_id) {
            throw new \Exception(__('Você não tem permissão para alterar essa loja'));
        }

        $store->update($data);
        if (class_exists('Modules\\RegisterStore')) {
            \Modules\RegisterStore::register($store);
        }

        return $store;
    }
}
