<?php
function generarHTML($nombre,$precio,$ud) {
    $html = "<div>";
    $html .= "<h2>$nombre</h2>";
    $html .= "<p>Precio: ".number_format($precio,2,".",",")."</p>";
    $html = ($ud != 0) ? "<p> Unidades disponible: $ud</p>" : "<p> Unidades Agotadas </p>" ;
    $html .= "</div>";
    return $html;
}