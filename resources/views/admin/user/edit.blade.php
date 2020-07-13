@extends('layouts.admin')

@section("title", __("Editar - Usuário"))

@section('content')
    @include('partials.form', [
        'action' => route('admin.user.user.update', $user->id),
        'model' => $user,
        'view' => 'admin.user.form'
    ])
@endsection
