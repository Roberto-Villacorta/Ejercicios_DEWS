<?php
$ref         = isset($_POST['ref'])         ? $_POST['ref']         : null;
$nombre      = isset($_POST['nombre'])      ? $_POST['nombre']      : null;
$descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
$precio      = isset($_POST['precio'])      ? $_POST['precio']      : null;
$categoria   = isset($_POST['categoria'])   ? $_POST['categoria']   : null;

include('util.php');
$bd = conectarMySql();

$query = <<<SQL
	INSERT INTO PRODUCTOS(ref, nombre, descripcion, precio, categoria)
	VALUES (:ref, :nombre, :descripcion, :precio, :categoria)
SQL;

$sentencia = $bd->prepare($query);

$sentencia->bindParam(':ref',         $ref);
$sentencia->bindParam(':nombre',      $nombre);
$sentencia->bindParam(':descripcion', $descripcion);
$sentencia->bindParam(':precio',      $precio);
$sentencia->bindParam(':categoria',   $categoria);

$ok = $sentencia->execute();

// Patrón PRG
header("Location:productoCpostMensaje.php?ok=$ok");
?>

