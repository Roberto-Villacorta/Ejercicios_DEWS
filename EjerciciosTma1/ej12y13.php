<?php
$censura = ["tonto", "calvo", "avecrem"];
$patron = '/' . implode('|', $censura) . '/i';

echo "Escribe algo: ";
$texto = trim(fgets(STDIN));

echo "Tu texto después de la censura se ve así: ". preg_replace($patron,"*****",$texto);

?>