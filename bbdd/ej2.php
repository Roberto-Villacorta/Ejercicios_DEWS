<?php
require_once('ej1.php');

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';

    if (!empty($nombre) && !empty($precio)) {
        try {
            $conexion = conectarMySql();
            crearTabla($conexion);
            // insertar() espera un array de productos, por lo que pasamos un array con el producto
            insertar($conexion, [
                ['nombre' => $nombre, 'precio' => $precio]
            ]);
            $mensaje = "Producto insertado correctamente";
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    } else {
        $mensaje = "Rellenar todos los campos";
    }
}
?>
<h1>Formulario de producto</h1>

<form action="ej2.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">

    <label for="precio">Precio:</label>
    <input type="text" name="precio" id="precio">

    <input type="submit" value="Enviar">
</form>

<?php if (!empty($mensaje)): ?>
    <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
<?php endif; ?>

<div id="Mostrar Productos">
    <?php
    $productos = obtenerProductos(conectarMySql());
    $contador = 0;
    foreach ($productos as $producto) {
        echo "Producto numero: " . $contador . "<br>";
        echo "Nombre: " . htmlspecialchars($producto['nombre']) . "<br>";
        echo "Precio: " . htmlspecialchars($producto['precio']) . "<br><br>";
        $contador++;
    }
    ?>
</div>