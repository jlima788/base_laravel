@extends('layouts.admin')

@section("title", __("Cadastrar - Grupo"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.user.role.store'),
        'model' => null,
        'view' => 'admin.role.form'
    ])
@endsection
