@extends('adminlte::page')

@section('title', 'Meu perfil')

@section('content')
    <div class='ajax'>
        @include('partials.form', [
            'action' => route('admin.user.profile.store'),
            'model' => $user,
            'method' => 'POST',
            'view' => 'admin.profile.form'
        ])
    </div>
@endsection
