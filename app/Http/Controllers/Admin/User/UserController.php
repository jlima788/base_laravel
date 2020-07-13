<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerDestroy;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerIndex;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerStore;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerUpdate;
use BRCas\Laravel\Traits\Queries\ExecuteController;
use Illuminate\Http\Request;
use Modules\Log\Services\LogService;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    use ControllerIndex, ControllerStore, ControllerDestroy, ControllerUpdate, ExecuteController;

    public function __construct()
    {
        $this->middleware('can:usuario cadastrar')->only(['create', 'store']);
        $this->middleware('can:usuario editar')->only(['edit', 'update']);
        $this->middleware('can:usuario excluir')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $actions = [];
        $new = null;
        if (auth()->user()->can("usuario cadastrar")) {
            $new = 'admin.user.user.create';
        }

        if (auth()->user()->can("usuario editar")) {
            $actions += [
                "edit" => [
                    'action' => function ($obj) {
                        return route('admin.user.user.edit', $obj->id);
                    },
                ]
            ];
        }

        if (auth()->user()->can("usuario excluir")) {
            $actions += [
                "delete" => [
                    'action' => function ($obj) {
                        return route('admin.user.user.destroy', $obj->id);
                    },
                ]
            ];
        }

        $data = $this->list($request);
        return view('admin.user.index', compact('data', 'actions', 'new'));
    }

    public function edit(User $user)
    {
        $permissions = $this->getPermissions()->pluck('name', 'id');
        $roles = $this->getRoles()->pluck('name', 'id');
        return view('admin.user.edit', compact('user', 'permissions', 'roles'));
    }

    private function getPermissions()
    {
        return Permission::whereNotIn('name', ['super admin'])
            ->orderBy('name')
            ->get();
    }

    private function getRoles()
    {
        return Role::orderBy('name')
            ->get();
    }

    public function create()
    {
        $permissions = $this->getPermissions()->pluck('name', 'id');
        $roles = $this->getRoles()->pluck('name', 'id');
        return view('admin.user.create', compact('permissions', 'roles'));
    }

    public function route()
    {
        return route('admin.user.user.index');
    }

    public function rulesPut()
    {
        $id = $this->request->route('user');
        $store = auth()->user()->store_id;

        return $this->rule() + [
                'email' => ['required', 'email', "unique:users,email,{$id},id,deleted_at,NULL,store_id,{$store}"],
            ];
    }

    private function rule()
    {
        $tableNames = config('permission.table_names');
        $permissionTable = $tableNames['permissions'];
        $roleTable = $tableNames['roles'];

        return [
            'name' => ['required', 'string'],
            'permissions' => ['array'],
            'permissions.*' => ["exists:$permissionTable,id"],
            'roles' => ['array'],
            'roles.*' => ["exists:$roleTable,id"],
        ];
    }

    public function rulesPost()
    {
        $store = auth()->user()->store_id;

        return $this->rule() + [
                'email' => ['required', 'email', "unique:users,email,NULL,id,deleted_at,NULL,store_id,{$store}"],
            ];
    }

    public function resource()
    {
        return $this->resourceCollection();
    }

    public function resourceCollection()
    {
        return UserResource::class;
    }

    public function model()
    {
        return User::class;
    }
}
