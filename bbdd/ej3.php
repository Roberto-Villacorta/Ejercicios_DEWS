<?php
require_once('ej1.php');
session_start();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    if ($_POST['accion'] === 'guardar') {
        $nombre = trim($_POST['nombre'] ?? '');
        $precio = trim($_POST['precio'] ?? '');

        if (!empty($nombre) && !empty($precio)) {
            if (!isset($_SESSION['memoria'])) {
                $_SESSION['memoria'] = [];
            }
            $_SESSION['memoria'][] = [
                'nombre' => $nombre,
                'precio' => $precio
            ];
            $mensaje = "Producto añadido a la memoria temporal.";
        } else {
            $mensaje = "Debes rellenar nombre y precio para guardar en memoria.";
        }
    } else if ($_POST['accion'] === 'enBBDD') {
        if (!empty($_SESSION['memoria'])) {
            try {
                $conexion = conectarMySql();
                insertar($conexion, $_SESSION['memoria']);
                $_SESSION['memoria'] = []; // Vaciamos la memoria tras guardarlos en la BBDD
                $mensaje = "Productos guardados correctamente en la base de datos.";
            } catch (PDOException $e) {
                $mensaje = "Error al insertar en la base de datos: " . $e->getMessage();
            }
        } else {
            $mensaje = "No hay productos en memoria para guardar en la base de datos.";
        }
    }
}
?>
<h1>Formulario de producto</h1>

<form action="ej3.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre">

    <label for="precio">Precio:</label>
    <input type="text" name="precio" id="precio">

    <button type="submit" name="accion" value="guardar">Guardar</button>
    <button type="submit" name="accion" value="enBBDD">Guardar en BBDD</button>
</form>

<?php if (!empty($mensaje)): ?>
    <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
<?php endif; ?>

<div id="mostrarMemoria">
    <h2>Productos en Memoria</h2>
    <?php
    if (!empty($_SESSION['memoria'])) {
        $contador = 0;
        foreach ($_SESSION['memoria'] as $producto) {
            echo "Producto numero: " . $contador . "<br>";
            echo "Nombre: " . htmlspecialchars($producto['nombre']) . "<br>";
            echo "Precio: " . htmlspecialchars($producto['precio']) . "<br><br>";
            $contador++;
        }
    } else {
        echo "<p>No hay productos en memoria.</p>";
    }
    ?>
</div>

<div id="Mostrar Productos en BBDD">
    <h2>Productos en BBDD</h2>
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
