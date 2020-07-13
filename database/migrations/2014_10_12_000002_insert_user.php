<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InsertUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $user = config('default.user');
        $user['password'] = Hash::make($user['password']);

        $data = [
            'store_id' => config('default.store.id'),
            'staf' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ] + $user;

        DB::table('users')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('users')->where('id', config('default.user.id'))->delete();
    }
}
