<?php


$uri1 = "http://somos.los.mas?listos=del&mundo=entero";
$uri2 = "http://somos.los.mas?listos=del&mundo.entero=";

// Por defecto ejecutamos la primera URI del ejercicio:
header("Location: " . $uri1);
exit();

?>