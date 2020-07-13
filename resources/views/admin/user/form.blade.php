<div class='row'>
    <div class='col-md-6 form-group'>
        {!! Form::label('name', __('Nome')) !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
    </div>

    <div class='col-md-6 form-group'>
        {!! Form::label('email',  __('E-mail')) !!}
        {!! Form::email('email', null, ['class' => 'form-control m-input', 'required']) !!}
    </div>
</div>

<div class='row'>
    <div class='col-md-6 form-group'>
        {!! Form::label('roles[]',  __('Grupos')) !!}
        {!! Form::select('roles[]', $roles, null, [
            'disabled' => (bool) !count($roles),
            'class' => 'form-control',
            'multiple' => 'multiple'
         ]) !!}
    </div>

    <div class='col-md-6 form-group'>
        {!! Form::label('permissions[]',  __('Permissões')) !!}
        {!! Form::select('permissions[]', $permissions, null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
    </div>
</div>
