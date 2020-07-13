<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertStore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $store = [
            'id' => config('default.store.id'),
            'name' => config('app.name'),
            "domain" => app()->environment('local') ? "localhost" : "erp.pessoaweb.com.br",
            'client_id' => sha1(time()),
            'secret_id' => sha1(time() . time()),
            'document' => '99999999999',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('stores')->insert($store);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('stores')->where('id', config('app.default.store.id'))->delete();
    }
}
