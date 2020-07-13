<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\RoleService;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerDestroy;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerIndex;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerStore;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerUpdate;
use BRCas\Laravel\Traits\Queries\ExecuteController;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use ControllerIndex, ControllerUpdate, ControllerDestroy, ExecuteController, ControllerStore;

    public function __construct()
    {
        $this->middleware('can:grupo cadastrar')->only(['create', 'store']);
        $this->middleware('can:grupo editar')->only(['edit', 'update']);
        $this->middleware('can:grupo excluir')->only(['destroy']);
    }

    public function index(Request $request)
    {
        $actions = [];
        $new = null;
        if (auth()->user()->can("grupo cadastrar")) {
            $new = 'admin.user.role.create';
        }

        if (auth()->user()->can("grupo editar")) {
            $actions += [
                "edit" => [
                    'action' => function ($obj) {
                        return route('admin.user.role.edit', $obj->id);
                    },
                ]
            ];
        }

        if (auth()->user()->can("grupo excluir")) {
            $actions += [
                "delete" => [
                    'action' => function ($obj) {
                        return route('admin.user.role.destroy', $obj->id);
                    },
                ]
            ];
        }

        $data = $this->list($request);
        return view('admin.role.index', compact('data', 'actions', 'new'));
    }

    public function resource()
    {
        return $this->resourceCollection();
    }

    public function resourceCollection()
    {
        return RoleResource::class;
    }

    public function model()
    {
        return Role::class;
    }

    public function service()
    {
        return RoleService::class;
    }

    public function edit($role)
    {
        $role = Role::whereUuid($role)->firstOrFail();
        $permissions = $this->getPermissions()->pluck('name', 'id');
        return view("admin.role.edit", compact('role', 'permissions'));
    }

    private function getPermissions()
    {
        return Permission::whereNotIn('name', ['super admin'])
            ->orderBy('name')
            ->get();
    }

    public function create()
    {
        $permissions = $this->getPermissions()->pluck('name', 'id');
        return view("admin.role.create", compact('permissions'));
    }

    public function route()
    {
        return route('admin.user.role.index');
    }

    public function rulesPost()
    {
        return $this->rulesPut();
    }

    public function rulesPut()
    {
        $tableNames = config('permission.table_names');
        $permissionTable = $tableNames['permissions'];

        return [
            'name' => ['required', 'string'],
            'permissions' => ['array'],
            'permissions.*' => ["exists:$permissionTable,id"]
        ];
    }
}
