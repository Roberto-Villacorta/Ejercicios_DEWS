<?php
$accion = isset($_REQUEST['accion']) && !empty($_REQUEST['accion']) ? $_REQUEST['accion'] : 'Ninguna';

if ($accion == 'Ninguna') {
	header('Location:index.php');
} else {
	switch ($accion) {
		case 'R': $mensaje = 'consultar'; break;
		case 'U': $mensaje = 'editar';    break;
		case 'D': $mensaje = 'borrar';    break;
	}
	$script = $accion == 'D' ? "productoDpost.php" : "productoRUpost.php";
}

echo <<<HTML
<head>
<meta charset="utf-8">
<title>Introducir referencia</title>
</head>

<body>
	<fieldset>
		<legend>Introduce la referencia del producto a $mensaje</legend>
		<form action="$script" method="post">
			<label for="idRef">Referencia del producto</label>
			<input type="text" name="ref" id="idRef">
HTML;

$mensaje = ucwords($mensaje);
echo <<<HTML
			<button type="submit" name="accion" value="$accion">$mensaje</button>
		</form>
		<form action="index.php">
			<input type="submit" value="Menú principal">
		</form>
	</fieldset>
</body>
HTML;
?>

