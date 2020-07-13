<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\StoreService;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerIndex;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerStore as ControllerStoreController;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerUpdate;
use BRCas\Laravel\Traits\Queries\ExecuteController;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use ControllerIndex, ControllerStoreController, ControllerUpdate, ExecuteController;

    public function service()
    {
        return StoreService::class;
    }

    public function index(Request $request)
    {
        if (auth()->user()->staf == false) {
            abort(403);
        }

        $data = $this->list($request);
        return view('admin.store.index', compact('data'));
    }

    public function create()
    {
        if (auth()->user()->staf == false) {
            abort(403);
        }

        return view('admin.store.create');
    }

    public function edit(Store $store)
    {
        if (auth()->user()->staf == false) {
            abort(403);
        }

        return view('admin.store.edit', compact('store'));
    }

    public function model()
    {
        return Store::class;
    }

    public function resource()
    {
        return $this->resourceCollection();
    }

    public function resourceCollection()
    {
        return StoreResource::class;
    }

    public function rulesPost()
    {
        return $this->rulesPut() + [
                'user.name' => ['required', 'string'],
                'user.email' => ['required', 'string'],
                'user.password' => ['required', 'string'],
            ];
    }

    public function rulesPut()
    {
        return [
            'name' => ['required', 'string'],
            'domain' => ['required', 'string'],
        ];
    }

    public function route()
    {
        return route('admin.store.index');
    }
}
