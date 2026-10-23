<?php
require_once "funciones.php";

if (isset($_POST["verbo"], $_POST["param2"])) {
    $verbo = trim($_POST["verbo"]);
    $accion = $_POST["param2"];

    if ($accion === "conjugar") {
        echo conjugar($verbo);
    } elseif ($accion === "conjugacion") {
        echo conjugacion($verbo);
    } else {
        echo "Acción no reconocida.";
    }
} else {
    echo "Faltan parámetros requeridos.";
}
?>
