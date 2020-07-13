<?php

namespace App\Models;

use App\Traits\StoreTrait;
use BRCas\Laravel\Traits\Entities\Uuid;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    protected static $uuid = "uuid";

    use Uuid, StoreTrait;

    public static function create(array $attributes = [])
    {
        $obj = self::query()->create(['name' => $attributes['name']]);
        $obj->handleRelations($attributes);
        return $obj;
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update(['name' => $attributes['name']], $options);
        $this->handleRelations($attributes);
        return true;
    }

    public function handleRelations(array $data)
    {
        $this->syncPermissions(empty($data['permissions']) ? [] : $data['permissions']);
    }
}
