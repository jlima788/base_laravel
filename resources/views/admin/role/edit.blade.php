@extends('layouts.admin')

@section("title", __("Editar - Grupos"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.user.role.update', $role->id),
        'model' => $role,
        'view' => 'admin.role.form'
    ])
@endsection
