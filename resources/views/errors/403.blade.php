@extends(getLayout())

<style>
    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
        color: #444;
    }

    .position-ref {
        position: relative;
    }

    .code {
        border-right: 2px solid;
        font-size: 26px;
        padding: 0 15px 0 15px;
        text-align: center;
    }

    .message {
        font-size: 18px;
        text-align: center;
    }
</style>

@section('content')
    <div class="flex-center position-ref full-height">
        <div class="code">
            403
        </div>

        <div class="message" style="padding: 10px;">{!! __('Você não tem permissão para acessar essa página') !!}</div>
    </div>
@endsection
