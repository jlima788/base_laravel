<?php

namespace App\Traits;

use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

trait StoreTrait
{

    protected static function bootStoreTrait()
    {
        static::creating(function ($obj) {
            self::setStore($obj);
        });

        static::addGlobalScope('byStore', function (Builder $builder) {
            $host = str_replace(['http://', 'https://'], '', Request::root());
            $id = Cache::get($host);

            if (empty($id)) {
                list($domain,) = explode(":", $host);
                $store = self::getStore($domain);
                if (empty($store)) {
                    list($domain) = explode('.', $domain);
                    $store = self::getStore($domain);
                }
                if (!empty($store)) {
                    $id = $store->id;
                }
                Cache::set($host, $id);
            }
            $table = (new self)->getTable();
            $builder->where("{$table}.store_id", $id);
        });
    }

    protected static function setStore($obj)
    {
        if ($user = auth()->user()) {
            $obj->store_id = $user->store_id;
        }
    }

    private static function getStore(string $domain): ?Store
    {
        return Store::whereDomain($domain)->first();
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
