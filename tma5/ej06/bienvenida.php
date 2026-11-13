<?php
include('util.php');

$bd = conectarMySql();

$sentencia = $bd->prepare("SELECT * FROM PRODUCTOS ORDER BY 1");
$sentencia->execute();
$productos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Detectar columnas reales y usar la primera como clave primaria
$columnas = !empty($productos) ? array_keys($productos[0]) : [];
$colClave  = !empty($columnas) ? $columnas[0] : null; // primera columna = PK
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>CRUD de Productos</title>
</head>

<body>
	<h1>CRUD de PRODUCTOS</h1>

	<div class="acciones">
		<form action="productoC.php" method="get" style="display:inline;">
			<button type="submit" class="btn-crear">+ Crear nuevo producto</button>
		</form>
	</div>

	<table>
		<thead>
			<tr>
				<?php foreach ($columnas as $col): ?>
					<th><?= htmlspecialchars($col) ?></th>
				<?php endforeach; ?>
				<th>Editar</th>
				<th>Borrar</th>
			</tr>
		</thead>
		<tbody>
			<?php if (empty($productos)): ?>
				<tr>
					<td colspan="<?= count($columnas) + 2 ?>" class="sin-datos">No hay productos registrados.</td>
				</tr>
			<?php else: ?>
				<?php foreach ($productos as $prod):
					$valorClave = $colClave ? $prod[$colClave] : '';
				?>
					<tr>
						<?php foreach ($columnas as $col): ?>
							<td><?= htmlspecialchars($prod[$col] ?? '') ?></td>
						<?php endforeach; ?>
						<td>
							<form action="productoRUpost.php" method="post">
								<input type="hidden" name="ref" value="<?= htmlspecialchars($valorClave) ?>">
								<input type="hidden" name="accion" value="U">
								<button type="submit" class="btn-editar">Editar</button>
							</form>
						</td>
						<td>
							<form action="productoDpost.php" method="post">
								<input type="hidden" name="ref" value="<?= htmlspecialchars($valorClave) ?>">
								<button type="submit" class="btn-borrar"
									onclick="return confirm('¿Borrar el registro <?= htmlspecialchars($valorClave) ?>?')">
									Borrar
								</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</body>

</html>