<head>
<meta charset="utf-8">
<title>CRUD de Productos</title>
</head>
<body>
	<h1>CRUD de PRODUCTOS</h1>
	<fieldset>
		<legend>Selecciona operación</legend>
		<form action="productoC.php">
			<input type="submit" value="Crear">
		</form>
		<form action="productoIntroRef.php">
			<input type="submit" value="Recuperar">
			<input type="hidden" name="accion" value="R">
		</form>
		<form action="productoIntroRef.php">
			<input type="submit" value="Editar">
			<input type="hidden" name="accion" value="U">
		</form>
		<form action="productoIntroRef.php">
			<input type="submit" value="Borrar">
			<input type="hidden" name="accion" value="D">
		</form>
	</fieldset>
</body>

