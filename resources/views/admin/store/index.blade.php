@extends('layouts.admin')

@section("title", __("Relatório - Loja"))

@section('content')
    @include('partials.table.list', [
        'new' => 'admin.store.create',
        'data' => $data,
        "filter_array" => [
            'like_name' => __("Name")
        ],
        'table' => [
            __("Nome") => [
                'field' => 'name',
            ],
            __("Domínio") => [
                'field' => 'domain',
            ]
        ],
        "actions" => [
            "edit" => [
                'action' => function($obj){
                    return route('admin.store.edit', $obj->id);
                },
            ],
            "delete" => [
                'action' => function($obj){
                    return route('admin.store.destroy', $obj->id);
                },
            ]
        ]
    ])
@endsection
