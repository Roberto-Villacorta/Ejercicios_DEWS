<?php
$persona; 
$nombre;
$edad;
do{
    echo "Nombre?";
    $nombre = trim(fgets(STDIN));
    if($nombre == "fin"){
      break;
    }
    echo "¿Cual es la edad de $nombre?";
    $edad = trim(fgets(STDIN));
    $persona[$nombre] = $edad;
} while (true);

echo "Personas:";
echo "
";

foreach ($persona as $nombre => $edad) {
    echo $nombre . " tiene " . $edad . " años" . PHP_EOL;
}
?>