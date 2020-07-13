<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use App\Services\MyStoreService;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerIndex;
use BRCas\Laravel\Traits\Controllers\Controller\ControllerUpdate;
use BRCas\Laravel\Traits\Queries\ExecuteController;

class MyStoreController extends Controller
{
    use ControllerIndex, ControllerUpdate, ExecuteController;

    public function service()
    {
        return MyStoreService::class;
    }

    public function index()
    {
        $store = auth()->user()->store;
        return view('admin.mystore.index', compact('store'));
    }

    public function resource()
    {
        return $this->resourceCollection();
    }

    public function resourceCollection()
    {
        return StoreResource::class;
    }

    public function model()
    {
        return Store::class;
    }

    public function edit()
    {
        abort(404);
    }

    public function route()
    {
        return route('admin.mystore.index');
    }

    public function rulesPut()
    {
        return [
            'name' => ['required', 'string'],
            'document' => ['required', 'string', 'max:40'],
        ];
    }
}
