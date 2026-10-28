<?php
require_once('utils.php');
$conexion = conectarMySql();

function crearTabla(PDO $conexion)
{
    $query = 'CREATE TABLE IF NOT EXISTS productos (
        nombre varchar(100) not null primary key,
        precio float not null
    )';

    if ($conexion->exec($query) === false) {
        echo "Error al crear la tabla";
        print_r($conexion->errorInfo());
        return false;
    }
    return true;
}
function insertar(PDO $conexion, array $productos)
{
    foreach ($productos as $producto) {
        $query = 'INSERT INTO productos VALUES(:nombre, :precio)';
        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombre', $producto['nombre']);
        $stmt->bindParam(':precio', $producto['precio']);
        $stmt->execute();
    }
}

function obtenerProductos(PDO $conexion)
{
    $query = 'SELECT * FROM productos';
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
}
