<?php

namespace Tests\Traits;

use App\Entity\Store;
use App\Entity\User;

trait UserTest
{
    public function registerBrowser(): \stdClass
    {
        $nome = str_repeat('a', 250);

        $this->visit('/')
            ->dontSee('Rails')
            ->see('Register')
            ->click('Register')
            ->seeRouteIs('register')
            ->type($nome, 'store')
            ->type($nome, 'name')
            ->type('contato@gmail.com', 'email')
            ->type('bruno5124828', 'password')
            ->type('bruno5124828', 'password_confirmation')
            ->press(__('adminlte::adminlte.register'))
            ->seePageIs('/admin');

        $objUser = User::whereEmail('contato@gmail.com')->first();
        $objStore = Store::whereName($nome)->first();

        $this->seeInDatabase('users', [
            'email' => 'contato@gmail.com',
            'store_id' => $objStore->id
        ]);

        $this->seeInDatabase('stores', [
            'name' => $nome
        ]);

        $obj = new \stdClass();
        $obj->user = $objUser;
        $obj->store = $objStore;

        return $obj;
    }
}
