<?php
require_once('../utils.php');

if(isset($_POST['numero']) && isset($_POST['accion'])) {
    $numero = $_POST['numero'];
    $accion = $_POST['accion'];

    if ($accion == 'tabla') {
        echo generarTablas($numero);
    } elseif ($accion == 'info') {
        $esPrimo = esPrimo($numero) ? "El número es primo" : "El número no es primo";
        $esPar = $numero % 2 == 0 ? "El número es par" : "El número es impar";
        $cuadrado = $numero * $numero;
        $cubo = $numero * $numero * $numero;
        echo "<label>Información del número $numero:</label><br>
              <label>$esPrimo</label><br>
              <label>$esPar</label><br>
              <label>El cuadrado del número es: $cuadrado</label><br>
              <label>El cubo del número es: $cubo</label><br>";
    } else {
        echo "Acción no válida";
    }
} else {
    echo "No has introducido todos los valores";
}


function esPrimo($num) {
    if ($num <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) {
            return false;
        }
    }
    return true;
}
