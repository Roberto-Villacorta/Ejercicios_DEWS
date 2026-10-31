<?php

function generarSelectDias($mes,$anyo){
    $html = '<select name="dia">'. PHP_EOL;
    $diasMes = cal_days_in_month(CAL_GREGORIAN,$mes,$anyo);
    for($i=1; $i<$diasMes; $i++){
        $html .= '<option value="'.$i.'">'.$i.'</option>'.PHP_EOL  ;  
    }
    return $html."</select>";
}