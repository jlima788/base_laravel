@extends('layouts.admin')

@section("title", __("Relatório - Grupo"))

@section('content')
    @include('partials.table.list', [
        'new' => auth()->user()->can("grupo cadastrar") ? 'admin.user.role.create' : null,
        'data' => $data,
        "filter_array" => [
            'like_name' => __("Name")
        ],
        'table' => [
            __("Nome") => [
                'field' => 'name',
            ],
        ],
        "actions" => $actions
    ])
@endsection
