<?php
$ok = isset($_REQUEST['ok']) && $_REQUEST['ok'] == "1" ? true : false;
$mensaje = $ok ? "PRODUCTO ACTUALIZADO CORRECTAMENTE" : "ERROR: Error al actualizar el producto";
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado actualización</title></head>
<body>
	<h2><?= $mensaje ?></h2>
	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>
</html>

