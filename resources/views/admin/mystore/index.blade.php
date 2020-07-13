@extends('layouts.admin')

@section("title", __("Editar minha loja"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.mystore.update', $store->id),
        'model' => $store,
        'view' => 'admin.mystore.form'
    ])
@endsection
