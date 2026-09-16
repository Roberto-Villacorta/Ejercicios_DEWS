<?php
echo "Día: ";
$dia = trim(fgets(STDIN));
echo "Mes: ";
$mes = trim(fgets(STDIN));
echo "Año: ";
$ano = trim(fgets(STDIN));

$fecha = new DateTime("$ano-$mes-$dia");

$hoy = new DateTime();
$diferencia = $fecha->diff($hoy);

echo "Han pasado " . $diferencia->y . " Años " . $diferencia->m . " Meses " . $diferencia->d . " Días\n";
?>