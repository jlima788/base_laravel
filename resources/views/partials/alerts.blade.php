@if(Session::has('success'))
    <script>
        alertSuccess('{!! Session::get("success") !!}');
    </script>
@endif

@if(Session::has('error_validate') && Session::get("error_validate"))
    <script>
        alertErrorValidate('{!! Session::get("error_validate") !!}');
    </script>
    <!--
    @php
        $msg = json_decode(Session::get("error_validate"));
        foreach($msg as $rs){
            foreach($rs as $rs2){
                print ($rs2);
            }
        }
    @endphp
        -->
@endif

@if($errors->any())
    <script>
        @foreach($errors->all() as $error)
        alertError("{!! $error !!}");
        @endforeach
    </script>

    <!--
    @foreach($errors->all() as $error)
        {!! $error !!}
    @endforeach
        -->
@endif
