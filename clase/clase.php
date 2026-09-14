<?php
// Todo código fuente de php comienza con esas etiquetas y termina con ellas.
// Las sentencias de php terminan en punto y coma.
// Los comentarios son con // o /**/ 

// Imprimir datos en pantalla
echo "Lo que sea \n";

// Declarar variables
$variable = "algo";
$var2 = 12;
$var3 = false;
$var4 = 12.13;

// Convertimos el booleano a texto ('true' o 'false') en caso de no hacerlo se hadcodea true como 1 
// y false como 0
$var3_texto = $var3 ? 'true' : 'false';

$var1_bool = $variable == "algo" ;

// Añadimos \n al final para que el siguiente echo baje a la otra línea
echo $variable . "\n"; 

// Usamos comillas dobles e incluimos el booleano formateado
echo "El valor de las variables son: $variable, $var2, $var3_texto, $var4, $var1_bool \n"; 

// a diferencia de java no es necesario seguir la regla de escribir las variables en mayusculas,
// aunque se suele hacer por convencion.
const pi = 3.1416;

echo "el valor de pi es: $pi \n";

//Operadores
//Aritmeticos
// + - * / % **
//suma, resta, multiplicacion, division, modulo, potencia
//Incremento y decremento
// ++ --

//ejemplo pre
$num = 3;
echo ++$num; // 4
//ejemplo post
$num2 = 3;
echo $num2++; // 3

//suma uno, resta uno
//Comparacion
// == != < > <= >= === !==
//igual, distinto, menor que, mayor que, menor o igual que, mayor o igual que, igual y diferente, diferente
//Logicos
// && || ! ^
//y, o, negacion, o exclusivo

//ternario

$num1 = 5;
$num2 = 10;
$num3 = $num1 > $num2 ? $num1 : $num2;
echo $num3 . "\n";

//Concatenacion
// .
//une cadenas de texto

$cad1 = "hola";
$cad2 = "adios";
$cad3 = $cad1 . $cad2;
echo $cad3 . "\n";

//variables por referencia
//$bCopiaReferencia = &$b hace que bCopiaReferencia sea una referencia a b
// si modificamos una, modificamos la otra.
//$aCopiaValor = $a hace que aCopiaValor sea una copia de a
// si modificamos una, no modificamos la otra.

$a = 1;
$b = 3;
$aCopiaValor = $a;
$bCopiaReferencia = &$b;
$aCopiaValor ++;
$bCopiaReferencia ++;
echo "$a $aCopiaValor $b $bCopiaReferencia" . "\n";

//sentencias de control
$a = 3;
$b = 7;
//if,elseif,else
if ($a>$b) {
    # code...
} elseif ($a<$b) {
    # code...
} else {
    # code...
}

//switch
switch ($variable) {
    case 'value':
        # code...
        break;
    
    default:
        # code...
        break;
}

//bucles

//while
//do-while
//for

while ($a>$b) {
    echo $a . "\n";
    $a--;
}
do {
    echo $b . "\n";
    $b--;
} while ($a>$b);

for ($i=0; $i < 10; $i++) {
    echo $i . "\n";
}

//Entrada estandar
$nombre = fgets(STDIN);
echo "El nombre es: $nombre \n";

fscanf(STDIN, "%s",$apellido);
echo "El apellido es: $apellido \n";

$cadena = readline("Dime tu nombre: ");
echo "El nombre es: $cadena \n";

?>