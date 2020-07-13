@extends('layouts.admin')

@section("title", __("Relatório - Usuário"))

@section('content')
    @include('partials.table.list', [
        'new' => auth()->user()->can("usuario cadastrar") ? 'admin.user.user.create' : null,
        'data' => $data,
        "filter_array" => [
            'like_name' => __("Name")
        ],
        'table' => [
            __("Nome") => [
                'field' => 'name',
            ],
            __("E-mail") => [
                'field' => 'email',
            ]
        ],
        "permission" => [
            "edit" => "usuario editar",
            "delete" => "usuario excluir",
        ],
        "actions" => $actions,
    ])
@endsection
