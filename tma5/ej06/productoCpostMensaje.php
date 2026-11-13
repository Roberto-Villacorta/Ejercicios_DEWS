<?php
$ok = isset($_REQUEST['ok']) && $_REQUEST['ok'] == "1" ? true : false;
$mensaje = $ok ? "PRODUCTO INSERTADO CORRECTAMENTE" : "ERROR: Producto no insertado";
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado inserción</title></head>
<body>
	<h2><?= $mensaje ?></h2>
	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>
</html>

