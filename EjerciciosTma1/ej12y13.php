<?php
$censura = ["tonto", "calvo", "avecrem"];
$patron = '/' . implode('|', $censura) . '/i';

echo "escribe algo: ";
$texto = trim(fgets(STDIN));

echo "Tú texto despues de la censura se ve así: ". preg_replace($patron,"*****",$texto);

?>