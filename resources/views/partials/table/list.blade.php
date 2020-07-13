@if(!empty($filter_array))
    <div class='card  filter-array'>
        <div class='card-header'>
            Filtro
        </div>

        <form class='card-body'>
            @foreach ($filter_array as $key => $value)
                <div class='form-group'>
                    {!! Form::label($key, $value) !!}
                    {!! Form::text($key, request($key), ['class' => 'form-control m-input']) !!}

                </div>
            @endforeach
            <button class='btn btn-primary'>{!! __('Filtrar') !!}</button>
        </form>
    </div>

    <hr />
@endif

<div class='card list-default'>
    @hasSection('title')
        <div class='card-header'>
            @yield('title')
        </div>
    @endif

    <div class='card-body'>
        @if (!empty($new))
            <div class='form-group'>
                <a href="{!! route($new) !!}" class='btn btn-secondary'>Cadastrar
                    @if (!empty($title))
                        - {!! $title !!}
                    @endif
                </a>
            </div>
        @endif

        @if(count($data))
            <div class="form-group">
                @include("partials.table.table", [
                    "data" => $data,
                    'table' => $table,
                    "actions" => $actions
                ])
            </div>
            {!! $data->appends(request()->all())->links() !!}

        @else
            <div class='alert alert-info text-center'>{!! __('No register in our database.') !!}</div>
        @endif
    </div>
</div>
