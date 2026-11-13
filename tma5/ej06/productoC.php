<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Nuevo Producto</title>
</head>

<body>
	<h2>Nuevo producto</h2>
	<fieldset>
		<legend>Introduce los datos</legend>
		<form action="productoCpost.php" method="post">
			<label for="idRef">Referencia</label>
			<input type="text" name="ref" id="idRef"><br />

			<label for="idNombre">Nombre</label>
			<input type="text" name="nombre" id="idNombre"><br />

			<label for="idDescripcion">Descripción</label>
			<input type="text" name="descripcion" id="idDescripcion"><br />

			<label for="idPrecio">Precio (€)</label>
			<input type="number" step="0.01" min="0" name="precio" id="idPrecio"><br />

			<label for="idCategoria">Categoría</label>
			<select name="categoria" id="idCategoria">
				<option value="electronica">Electrónica</option>
				<option value="ropa">Ropa</option>
				<option value="alimentacion">Alimentación</option>
				<option value="hogar">Hogar</option>
				<option value="deporte">Deporte</option>
			</select><br />

			<button type="submit" class="btn-crear">Crear</button>
		</form>
	</fieldset>
	<div class="btn-volver">
		<form action="index.php">
			<input type="submit" value="Menú principal">
		</form>
	</div>
</body>

</html>