<?php
include('util.php');

// ---------------FUNCIONES------------------
function datosProducto($ref)
{
	global $bd;
	$query = <<<SQL
		SELECT * FROM productos
		WHERE nombre = :ref
SQL;
	$sentencia = $bd->prepare($query);
	$sentencia->bindParam(':ref', $ref);
	$sentencia->execute();
	return $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

// ---------------COMIENZO------------------

$bd = conectarMySql();

$accion = isset($_REQUEST['accion']) && !empty($_REQUEST['accion']) ? $_REQUEST['accion'] : 'Ninguna';
$ref    = isset($_REQUEST['ref'])    && !empty($_REQUEST['ref'])    ? $_REQUEST['ref']    : null;

if ($accion == 'Ninguna' || $ref == null) {
	header('Location:index.php');
	exit;
}

$datosProducto = datosProducto($ref);
$activo        = $accion == 'R' ? 'readonly="readonly"' : '';
$activoCat     = $accion == 'R' ? 'disabled="disabled"' : '';
$tituloAccion  = $accion == 'R' ? 'Consulta' : 'Edición';

$cats = [
	'electronica'  => 'Electrónica',
	'ropa'         => 'Ropa',
	'alimentacion' => 'Alimentación',
	'hogar'        => 'Hogar',
	'deporte'      => 'Deporte'
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title><?= $tituloAccion ?> de producto</title>
</head>

<body>
	<h2><?= $tituloAccion ?> de producto</h2>

	<?php if (empty($datosProducto)): ?>
		<h3>No existe el producto con referencia '<?= htmlspecialchars($ref) ?>'</h3>
	<?php else:
		$prod = $datosProducto[0];
	?>
		<fieldset>
			<legend>Datos del producto</legend>
			<form action="productoUpost.php" method="post">

				<label>Nombre</label>
				<input type="text" name="nombre" value="<?= htmlspecialchars($prod['nombre']) ?>" <?= $activo ?>><br />

				<label>Precio (€)</label>
				<input type="number" step="0.01" min="0" name="precio" value="<?= htmlspecialchars($prod['precio']) ?>" <?= $activo ?>><br />

				<?php if ($accion == 'U'): ?>
					<button type="submit" class="btn-actualizar">Actualizar</button>
				<?php endif; ?>
			</form>
		</fieldset>
	<?php endif; ?>

	<form action="index.php">
		<input type="submit" value="Menú principal">
	</form>
</body>

</html>