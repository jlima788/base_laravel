@extends('layouts.admin')

@section("title", __("Cadastrar - Usuário"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.user.user.store'),
        'model' => null,
        'view' => 'admin.user.form'
    ])
@endsection
