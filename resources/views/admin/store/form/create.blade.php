@include('admin.store.form.edit')

<fieldset>
    <legend>Primeiro usuário</legend>

    <div class='row'>
        <div class='col-md-4 form-group'>
            {!! Form::label('user[name]', __('Name')) !!}
            {!! Form::text('user[name]', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
        </div>

        <div class='col-md-4 form-group'>
            {!! Form::label('user[email]', __('E-Mail Address')) !!}
            {!! Form::email('user[email]', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
        </div>

        <div class='col-md-4 form-group'>
            {!! Form::label('user[password]',  __('Password')) !!}
            {!! Form::text('user[password]', null, ['class' => 'form-control m-input', 'required']) !!}
        </div>
    </div>
</fieldset>
