<?php
echo "pon una cadena de texto: ";

//formato cadena “Nombre:Apellido:Telefono//OtroNombre:OtroApellido:OtroTelefono// ....... ”

$cadena = trim(fgets(STDIN));

$personas = explode("//",$cadena);

$cosa = [];

foreach($personas as $persona){
    $datos = explode(":", $persona);
    if (count($datos) >= 3) {
        $cosa[] = [
            "nombre" => $datos[0],
            "apellido" => $datos[1],
            "telefono" => $datos[2]
        ];
    }
}

foreach ($cosa as $contacto) {
    echo "Nombre: " . $contacto["nombre"] . "\n";
    echo "\tApellido: " . $contacto["apellido"] . "\n";
    echo "\tTeléfono: " . $contacto["telefono"] . "\n";
    echo "\t============\n";
}
?>
