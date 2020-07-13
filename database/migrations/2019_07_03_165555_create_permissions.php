<?php

use App\Traits\RegisterPermissionTrait;
use Illuminate\Database\Migrations\Migration;

class CreatePermissions extends Migration
{
    use RegisterPermissionTrait;

    private function permissions()
    {
        return [
            'super admin',
            'usuario',
            'usuario cadastrar',
            'usuario editar',
            'usuario excluir',
            'grupo',
            'grupo cadastrar',
            'grupo editar',
            'grupo excluir',
            'loja',
        ];
    }
}
