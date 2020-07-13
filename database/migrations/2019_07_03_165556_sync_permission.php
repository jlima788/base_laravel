<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SyncPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('model_has_permissions')->insert([
            'permission_id' => 1,
            'model_type' => 'App\\Models\\User',
            'model_uuid' => config('default.user.id')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('id', 'e6acd4c6-c2e0-11ea-b3de-0242ac130004')->delete();
        DB::table('model_has_permissions')
            ->where('permission_id', 1)
            ->where('model_uuid', 'e6acd4c6-c2e0-11ea-b3de-0242ac130004')
            ->delete();
    }
}
