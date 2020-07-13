<div class='row'>
    <div class='col-md-6 form-group'>
        {!! Form::label('name', __('Name')) !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input', 'id' => 'name', 'required', 'maxlength' => '150']) !!}
    </div>

    <div class='col-md-6 form-group'>
        {!! Form::label('email',  __('E-Mail Address')) !!}
        {!! Form::email('email', null, ['class' => 'form-control m-input', 'required']) !!}
    </div>

    {{-- <div class='col-md-4 form-group'>
        {!! Form::label('photo',  __('My photo')) !!}
        {!! Form::file('photo', ['class' => 'form-control m-input', 'required', 'accept' => 'image/png,image/jpeg,image/gif']) !!}
    </div> --}}
</div>

<div class='row'>
    <div class='col-md-4 form-group'>
        {!! Form::label('your_password', __('Password Actual')) !!}
        {!! Form::password('your_password', ['class' => 'form-control m-input', 'id' => 'your_password', 'required', 'maxlength' => '150']) !!}
    </div>

    <div class='col-md-4 form-group'>
        {!! Form::label('password', __('New Password')) !!}
        {!! Form::password('password', ['class' => 'form-control m-input', 'id' => 'password', 'maxlength' => '30']) !!}
    </div>

    <div class='col-md-4 form-group'>
        {!! Form::label('password_confirmation',  __('Confirm Password')) !!}
        {!! Form::password('password_confirmation', ['class' => 'form-control m-input']) !!}
    </div>
</div>
