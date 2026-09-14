<?php

$suma = 0;
$mult = 1;

echo "Introduce números (0 para terminar):\n";

while (true) {
    echo "Dime un número: ";
    $linea = fgets(STDIN);
    
    // Si fgets devuelve false significa (EOF o error de lectura)
    if ($linea === false) {
        break;
    }

    $entrada = trim($linea);

    // Control de errores: verificamos si la entrada es numérica
    if (!is_numeric($entrada)) {
        echo "Error: Debe introducir un número válido.\n";
        continue;
    }

    // Convertimos la entrada numérica (soporta enteros y decimales)
    $num = $entrada + 0;

    // Condición de parada
    if ($num == 0) {
        break;
    }
    
    $suma += $num;
    $mult *= $num;

}
echo "¿Que operación quieres (suma, multiplicación)?";
$opcion = fgets(STDIN);
switch ($opcion) {
    case 'suma':
        echo $suma;
        break;
    case 'multiplicacion':
        echo $mult;
        break;
    default:
        echo "Operación no válida";
        break;
 }

?>