<div class='row'>
    <div class='col-md-12 form-group'>
        {!! Form::label('name', __('Nome')) !!}
        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required', 'maxlength' => '150']) !!}
    </div>
</div>

@if(!empty($role))

    <div class='row'>
        <div class='col-md-12 form-group'>
            {!! Form::label('permissions[]',  __('Permissões')) !!}
            {!! Form::select('permissions[]', $permissions, null, ['class' => 'form-control', 'multiple' => 'multiple']) !!}
        </div>
    </div>

@endif