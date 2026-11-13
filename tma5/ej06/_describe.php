<?php
// Script de diagnóstico - ver columnas de la tabla PRODUCTOS
include('util.php');
$bd = conectarMySql();
$st = $bd->query("DESCRIBE PRODUCTOS");
$cols = $st->fetchAll(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($cols);
echo "</pre>";
?>

