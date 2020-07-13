<?php

namespace App\Models;

use App\Traits\StoreTrait;
use BRCas\Laravel\Traits\Entities\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, StoreTrait, HasRoles, Uuid, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'staf',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function create(array $attributes = [])
    {
        $obj = self::query()->create($attributes);
        $obj->handleRelations($attributes);
        return $obj;
    }

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope('withStore', function (Builder $builder) {
            $builder->with(['store']);
        });
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update($attributes);
        $this->handleRelations($attributes);
        return true;
    }

    private function handleRelations(array $data)
    {
        $superAdmin = $this->hasPermissionTo('super admin');
        $this->syncPermissions(empty($data['permissions']) ? [] : $data['permissions']);
        if ($superAdmin) {
            $this->givePermissionTo('super admin');
        }

        $this->syncRoles(empty($data['roles']) ? [] : $data['roles']);
    }
}
