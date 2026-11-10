<?php
$ok = isset($_REQUEST['ok']) && $_REQUEST['ok'] == "1" ? true : false;
if ($ok) {
	echo "PRODUCTO INSERTADO CORRECTAMENTE";
} else {
	echo "ERROR: Producto no insertado";
}
?>
<head>
<meta charset="utf-8">
<title>Resultado inserción</title>
</head>

<body>
	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>

