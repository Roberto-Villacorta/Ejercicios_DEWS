<?php
$ok = isset($_REQUEST['ok']) && $_REQUEST['ok'] == "1" ? true : false;
if ($ok) {
	$mensaje = "PRODUCTO BORRADO CORRECTAMENTE";
} else {
	$mensaje = "ERROR: Error al borrar el producto (puede que no exista)";
}
echo <<<HTML
<head>
<meta charset="utf-8">
<title>Resultado borrado</title>
</head>

<body>
	<h2>$mensaje</h2>
	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>
HTML;
?>

