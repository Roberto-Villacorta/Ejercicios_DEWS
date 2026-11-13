<?php
$ok = isset($_REQUEST['ok']) && $_REQUEST['ok'] == "1" ? true : false;
$mensaje = $ok ? "PRODUCTO BORRADO CORRECTAMENTE" : "ERROR: Error al borrar el producto (puede que no exista)";
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado borrado</title></head>
<body>
	<h2><?= $mensaje ?></h2>
	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>
</html>

