<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

trait RegisterPermissionTrait
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions() as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    abstract public function permissions();

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(with(new Permission)->getTable())->whereIn('name', $this->permissions())->delete();
    }
}
