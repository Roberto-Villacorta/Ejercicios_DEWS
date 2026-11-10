<?php
require_once('util.php');

if (isset($_POST['mes'])&&isset($_POST['anyo'])&&$_POST['accion']=='info') {
    $mes = $_POST['mes'];
    $anyo = $_POST['anyo'];
    $numDias = saberDias($mes,$anyo);
    $isBisiesto = saberDias(2,$anyo) == 29;
    
    $nombresMeses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];
    $nombreMes = $nombresMeses[$mes];
    $mensaje = $isBisiesto ? "El Año es bisiesto" : "El año no es bisiesto";
    echo "<label>$nombreMes</label><br>
    <label>$anio</label><br>
    <label>$numDias</label><br>
    <label>$mensaje</label><br>
    ";
}elseif(isset($_POST['mes'])&&isset($_POST['anyo'])&&$_POST['accion']=='select'){
    $mes = $_POST['mes'];
    $anyo = $_POST['anyo'];
    echo generarSelectDias($mes,$anyo);
}
else{
    echo "No has introducido todos los valores";
}