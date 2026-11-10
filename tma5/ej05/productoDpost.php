<?php
include('util.php');

$ref = isset($_POST['ref']) && !empty($_POST['ref']) ? $_POST['ref'] : null;

if ($ref != null) {
	$bd = conectarMySql();
	$query = <<<SQL
		DELETE FROM PRODUCTOS
		WHERE ref = :ref
SQL;

	$sentencia = $bd->prepare($query);
	$sentencia->bindParam(':ref', $ref);
	$ok = $sentencia->execute();
	$ok = ($ok && ($sentencia->rowCount() > 0));
} else {
	$ok = false;
}

// Patrón PRG
header("Location:productoDpostMensaje.php?ok=$ok");
?>

