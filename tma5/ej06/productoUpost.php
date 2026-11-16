<?php
include('util.php');

$nombre      = isset($_POST['nombre'])      && !empty($_POST['nombre'])      ? $_POST['nombre']      : '';
$precio      = isset($_POST['precio'])      && !empty($_POST['precio'])      ? $_POST['precio']      : '';

if ($nombre != null && $precio != null) {
	$bd = conectarMySql();
	$query = <<<SQL
		UPDATE productos
		SET nombre      = :nombre,
		    precio      = :precio
		WHERE nombre = :nombre
SQL;
	$sentencia = $bd->prepare($query);
	$sentencia->bindParam(':nombre', $nombre);
	$sentencia->bindParam(':precio', $precio);
	$ok = $sentencia->execute();
} else {
	$ok = false;
}

// Patrón PRG
header("Location:productoUpostMensaje.php?ok=$ok");
