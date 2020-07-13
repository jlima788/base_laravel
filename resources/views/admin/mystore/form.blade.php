<div class='row'>
    <div class='col-md-6 form-group'>
        {!! Form::label('name', __('Nome')) !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
    </div>

    <div class='col-md-6 form-group'>
        {!! Form::label('domain',  __('Domínio')) !!}
        {!! Form::text('domain', null, ['disabled', 'class' => 'form-control m-input', 'required']) !!}
    </div>
</div>

@if (Route::has('admin.servico.loja.index'))
    <p>
        <a href="{!! route('admin.servico.loja.index') !!}">Editar informação de nota para serviço</a>
    </p>
@endif
