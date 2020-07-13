<div class='row'>
    <div class='col-md-6 form-group'>
        {!! Form::label('name', __('Nome da Loja')) !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
    </div>

    <div class='col-md-6 form-group'>
        {!! Form::label('domain',  __('Domínio')) !!}
        {!! Form::text('domain', null, ['class' => 'form-control m-input', 'required']) !!}
    </div>
</div>
