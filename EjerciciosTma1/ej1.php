<?php

/*
VERSION ANTERIOR:
$num = (int)readline("Dime un numero: ");
$mayor = $num;
$menor = $num;
while ($num != 0) {
    if ($num > $mayor) {
        $mayor = $num;
    }
    if ($num < $menor) {
        $menor = $num;
    }
    $num = (int)readline("Dime un numero: ");
}
if(is_numeric($num)){

    echo "mayor = $mayor \n";
    echo "menor = $menor \n";
}
else{echo 'no se introdujo numeros';}
*/


$mayor = null;
$menor = null;
$contadorNumeros = 0;

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

    // Actualizamos mayor y menor
    if ($contadorNumeros === 0) {
        $mayor = $num;
        $menor = $num;
    } else {
        if ($num > $mayor) {
            $mayor = $num;
        }
        if ($num < $menor) {
            $menor = $num;
        }
    }

    $contadorNumeros++;
}

//Mostramos los resultados al usuario
if ($contadorNumeros > 0) {
    echo "mayor = $mayor\n";
    echo "menor = $menor\n";
} else {
    echo "No se introdujo ningún número válido.\n";
}

?>