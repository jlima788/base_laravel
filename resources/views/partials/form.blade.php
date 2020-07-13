<div class='card list-default'>
    @hasSection('title')
        <div class='card-header'>
            @yield('title')
        </div>
    @endif

    <div class='card-body'>
        @if(empty($model))
            {!! Form::open([
                    'url' => $action,
                    'method' => empty($method) ? 'POST' : $method,
            ]) !!}
        @else
            {!! Form::model($model, [
                'url' => $action,
                'method' => empty($method) ? 'PUT' : $method
            ]) !!}
        @endif

        @include($view)

        {!! btnForm() !!}
        {!! Form::close() !!}
    </div>
</div>
