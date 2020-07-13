@extends('layouts.admin')

@section("title", __("Cadastrar - Loja"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.store.store'),
        'model' => null,
        'view' => 'admin.store.form.create'
    ])
@endsection
