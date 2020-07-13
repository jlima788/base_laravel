@extends('layouts.admin')

@section("title", __("Editar - Loja"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.store.update', $store->id),
        'model' => $store,
        'view' => 'admin.store.form.edit'
    ])
@endsection
