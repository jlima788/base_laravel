@if(count($data))
    <table class='{!! $class ?? "table table-striped table-hover table-list-default" !!}'>
        <thead>
        <tr>
            @foreach ($table as $k => $rs)
                @php $class = !empty($rs['class']) ? $rs['class'] : ""; @endphp
                <th class="{!! $class !!}">{!! $k !!}</th>
            @endforeach
            @if(!empty($actions))
                <th colspan="{!! count($actions) !!}"></th>
            @endif
        </tr>
        </thead>

        <tbody>
        @foreach ($data as $k => $rs)
            @php $rs->_i = $k + 1;  @endphp
            <tr class="{!! !empty($class_line) ? $class_line($rs) : "" !!}">
                @foreach ($table as $j => $column)
                    @php $field = !empty($column['field']) ? $column['field'] : null; @endphp
                    @php $class = !empty($column['class']) ? $column['class'] : ""; @endphp
                    <td class="{!! $class !!}">{!! empty($column['action']) ? $rs->$field : $column['action']($rs) !!}</td>
                @endforeach

                @if(!empty($actions))
                    @foreach ($actions as $k => $action)
                        @if(!empty($action['can']))
                            @can($action['can'])
                                <td class='action-{!! $k !!}'>
                                    @if (!empty($action['action']))
                                        @php
                                            $id = $action['action']($rs);
                                            switch($k){
                                                case 'edit':
                                                echo btnLinkEditIcon($action['action']($rs), "edit-" . $id);
                                                break;

                                                case 'delete':
                                                echo btnLinkDelIcon($action['action']($rs), "del-" . $id);
                                                break;
                                                default:
                                                    echo $action['action']($rs);
                                            }
                                        @endphp
                                    @endif
                                </td>
                            @endif
                        @else
                            <td class='action-{!! $k !!}'>
                                @if (!empty($action['action']))
                                    @php
                                        $id = $action['action']($rs);
                                        switch($k){
                                            case 'edit':
                                            echo btnLinkEditIcon($action['action']($rs), "edit-" . $id);
                                            break;

                                            case 'delete':
                                            echo btnLinkDelIcon($action['action']($rs), "del-" . $id);
                                            break;
                                            default:
                                                echo $action['action']($rs);
                                        }
                                    @endphp
                                @endif
                            </td>
                        @endif
                    @endforeach
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
