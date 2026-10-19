<?php
function ponerEnNegrita($texto){
    return "<strong>" . $texto . "</strong>";
} 

function cambiarColor($texto, $color){
    return "<span style='color:" . $color . "'>" . $texto . "</span>";
} 

function cambiarElTamanio($texto, $tamanio){
    return "
    <span style='font-size:" . $tamanio . "px'>" . $texto . "</span>";
} 

function cambiarLaFuente($texto, $fuente){
    return "<span style='font-family:" . $fuente . "'>" . $texto . "</span>";
} 

function resaltar($texto){
    return "<mark>" . $texto . "</mark>";
} 

function pintarRadio($nombre, $arrayValueLabel, $seleccionado = null){
    $html = "";
    foreach ($arrayValueLabel as $valor => $etiqueta) {
        $checked = ($seleccionado !== null && (string)$valor === (string)$seleccionado) ? ' checked="checked"' : '';
        $html .= '<input type="radio" name="' . $nombre . '" value="' . $valor . '" id="' . $valor . '"' . $checked . '>' . "\n";
        $html .= '<label for="' . $valor . '">' . $etiqueta . '</label><br />' . "\n";
    }
    return $html;
}

function pintarCheckboxes($nombre, $arrayValueLabel, $seleccionados = []){
    $html = "";
    $nombreArray = (substr($nombre, -2) === '[]') ? $nombre : $nombre . '[]';
    
    if (!is_array($seleccionados)) {
        $seleccionados = ($seleccionados !== null && $seleccionados !== '') ? [$seleccionados] : [];
    }
    $seleccionadosStr = array_map('strval', $seleccionados);

    foreach ($arrayValueLabel as $valor => $etiqueta) {
        $checked = in_array((string)$valor, $seleccionadosStr, true) ? ' checked="checked"' : '';
        $html .= '<input type="checkbox" name="' . $nombreArray . '" value="' . $valor . '" id="' . $valor . '"' . $checked . '>' . "\n";
        $html .= '<label for="' . $valor . '">' . $etiqueta . '</label><br />' . "\n";
    }
    return $html;
}

function pintarBulletPoints($elementos){
    if (empty($elementos)) {
        return "";
    }
    $html = "<ul>\n";
    foreach ($elementos as $item) {
        $html .= "    <li>" . $item . "</li>\n";
    }
    $html .= "</ul>\n";
    return $html;
}

?>