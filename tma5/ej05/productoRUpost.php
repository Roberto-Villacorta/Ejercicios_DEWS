<?php
include('util.php');

function datosProducto($ref)
{
	global $bd;
	$query = <<<SQL
		SELECT * FROM PRODUCTOS
		WHERE ref = :ref
SQL;
	$sentencia = $bd->prepare($query);
	$sentencia->bindParam(':ref', $ref);
	$sentencia->execute();
	return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

$bd = conectarMySql();

$accion = isset($_REQUEST['accion']) && !empty($_REQUEST['accion']) ? $_REQUEST['accion'] : 'Ninguna';
$ref    = isset($_REQUEST['ref'])    && !empty($_REQUEST['ref'])    ? $_REQUEST['ref']    : null;

if ($accion == 'Ninguna' || $ref == null) {
	header('Location:index.php');
} else {
	$mensaje = $accion == 'R' ? 'Consulta' : 'Edición';
	echo <<<HTML
	<head>
		<meta charset="utf-8">
		<title>$mensaje de producto</title>
	</head>

	<body>
		<h2>$mensaje de productos</h2>
		<fieldset><legend>Datos del producto</legend>
HTML;

	$datosProducto = datosProducto($ref);
	$activo = $accion == 'R' ? 'readonly="readonly"' : '';

	if ($datosProducto != []) {
		echo <<<HTML

		<form action="productoUpost.php" method="post">

HTML;
		foreach ($datosProducto as $prod) {
			echo <<<HTML

			Referencia    <input type="text"   name="ref"         value="{$prod['ref']}"         readonly="readonly"><br/>
			Nombre        <input type="text"   name="nombre"      value="{$prod['nombre']}"      $activo><br/>
			Descripción   <input type="text"   name="descripcion" value="{$prod['descripcion']}" $activo><br/>
			Precio (€)    <input type="number" name="precio" step="0.01" min="0" value="{$prod['precio']}" $activo><br/>
HTML;

			$cats = [
				'electronica' => 'Electrónica',
				'ropa' => 'Ropa',
				'alimentacion' => 'Alimentación',
				'hogar' => 'Hogar',
				'deporte' => 'Deporte'
			];
			$activoCat = $accion == 'R' ? 'disabled="disabled"' : '';

			$opcionesHTML = '';
			foreach ($cats as $val => $etiqueta) {
				$sel = $prod['categoria'] == $val ? 'selected="selected"' : '';
				$opcionesHTML .= "\t\t\t\t<option value=\"$val\" $sel>$etiqueta</option>\n";
			}

			echo <<<HTML

			Categoría <select name="categoria" $activoCat>
$opcionesHTML
			</select><br/>
HTML;
		}

		if ($accion == 'U') {
			echo <<<HTML
			<input type="submit" value="Actualizar">
HTML;
		}

		echo <<<HTML
			</form>
			</fieldset>
HTML;
	} else {
		echo "<h3>No existe el producto con referencia '$ref'</h3>";
	}

	echo <<<HTML
		<form action="index.php">
			<input type="submit" value="Menú principal">
		</form>
	</body>

HTML;
}
