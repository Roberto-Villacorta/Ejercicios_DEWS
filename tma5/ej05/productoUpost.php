<?php
include('util.php');

$ref         = isset($_POST['ref'])         && !empty($_POST['ref'])         ? $_POST['ref']         : null;
$nombre      = isset($_POST['nombre'])      && !empty($_POST['nombre'])      ? $_POST['nombre']      : '';
$descripcion = isset($_POST['descripcion'])                                  ? $_POST['descripcion'] : '';
$precio      = isset($_POST['precio'])      && !empty($_POST['precio'])      ? $_POST['precio']      : 0;
$categoria   = isset($_POST['categoria'])   && !empty($_POST['categoria'])   ? $_POST['categoria']   : '';

if ($ref != null) {
	$bd = conectarMySql();
	$query = <<<SQL
		UPDATE PRODUCTOS
		SET nombre      = :nombre,
		    descripcion = :descripcion,
		    precio      = :precio,
		    categoria   = :categoria
		WHERE ref = :ref
SQL;

	$sentencia = $bd->prepare($query);

	$sentencia->bindParam(':ref',         $ref);
	$sentencia->bindParam(':nombre',      $nombre);
	$sentencia->bindParam(':descripcion', $descripcion);
	$sentencia->bindParam(':precio',      $precio);
	$sentencia->bindParam(':categoria',   $categoria);

	$ok = $sentencia->execute();
} else {
	$ok = false;
}

// Patrón PRG
header("Location:productoUpostMensaje.php?ok=$ok");
?>

