<?php

if (!function_exists('btnLinkIcon')) {
    function btnLinkIcon($url, $icon, $title = '', $class = '', $id = '', $disabled = false)
    {
        if ($disabled == true) {
            $disabled = "disabled";
        }
        $html = "<a {$disabled} id='" . $id . "' href='{$url}' class='btn " . $class . "' title='{$title}'>
                    <i class='{$icon}'></i>
                 </a>";
        return $html;
    }
}

if (!function_exists('btnLinkEditIcon')) {
    function btnLinkEditIcon($url, $id = '')
    {
        return btnLinkIcon($url, 'fa fa-edit', 'Editar', 'btn-primary btn-sm btn-edit', $id);
    }
}

if (!function_exists('btnLinkDelIcon')) {
    function btnLinkDelIcon($url, $id = '')
    {
        $form_id = uniqid();
        $html = Form::open([
            'url' => $url,
            'id' => $form_id,
            'method' => 'DELETE',
            'style' => 'display:none;',
            'class' => 'form-delete-confirmation'
        ]);
        $html .= "<button>{$id}</button>";
        $html .= Form::close();
        $html .= btnLinkIcon("#{$form_id}", 'fa fa-trash', 'Excluir', 'btn-danger btn-sm btn-frm-remove');
        return $html;
    }
}

if (!function_exists('numberBrToEn')) {
    function numberBrToEn($number)
    {
        $value = str_replace('.', '', $number);
        return (float)str_replace(',', '.', $value);
    }
}

if (!function_exists('translateInterval')) {
    function translateInterval($interval)
    {
        $interval = str_replace([
            'years',
            'year',
            'months',
            'month',
            'days',
            'day'
        ], [
            'anos',
            'ano',
            'meses',
            'mês',
            'dias',
            'dia'
        ], $interval);
        return $interval;
    }
}

if (!function_exists('numberEnToBR')) {
    function numberEnToBR($number, $onlyGreaterZero = false)
    {
        if ($onlyGreaterZero == true && $number < 0) {
            $number *= -1;
        }
        return number_format($number, 2, ',', '.');
    }
}

if (!function_exists('strCalculate')) {
    function strCalculate($val1, $val2, $operator)
    {
        if ($operator == "+") {
            return $val1 + $val2;
        } elseif ($operator == "-") {
            return $val1 - $val2;
        } elseif ($operator == "*") {
            return $val1 * $val2;
        } elseif ($operator == "/") {
            return $val1 / $val2;
        }
    }
}

if (!function_exists('strMask')) {
    function strMask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#' && isset($val[$k])) {
                $maskared .= $val[$k++];
            } elseif (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}

if (!function_exists('onlyNumber')) {
    function onlyNumber($str)
    {
        return preg_replace("/[^0-9]/", "", $str);
    }
}

if (!function_exists('isEmpty')) {
    function isEmpty($valor)
    {
        return !empty($valor) ? $valor : null;
    }
}
if (!function_exists('getLayout')) {
    function getLayout()
    {
        $page = 'adminlte::page';
        if (request()->ajax()) {
            $page = 'layouts.ajax';
        }
        return request()->input('iframe') ? 'adminlte::iframe' : $page;
    }
}
if (!function_exists('btnForm')) {
    function btnForm($title = "Salvar")
    {
        $title = __($title);
        return "<button class='btn btn-primary' name='btn-save-form'>" . $title . "</button>";
    }
}

if (!function_exists('changeKey')) {
    function changeKey(array &$array, $origin, $destin)
    {
        $array[$destin] = $array[$origin];
        unset($array[$origin]);
    }
}
