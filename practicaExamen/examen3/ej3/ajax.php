<?php
require_once 'util.php';

// 1. Comprobar que la sesión está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (session_status() !== PHP_SESSION_ACTIVE) {
    echo "La sesión no está iniciada";
    exit;
}

// 2. Comprobar que la acción solicitada es válida
if (!isset($_POST['accion'])) {
    echo "Faltan parámetros";
    exit;
}

$accion = $_POST['accion'];
if ($accion !== 'consultar' && $accion !== 'estadisticas') {
    echo "Acción no válida";
    exit;
}

// 3. Comprobar que la lista de productos existe
if (!isset($_SESSION['productos'])) {
    echo "La lista de productos no existe";
    exit;
}

// 4. Comprobar que los datos almacenados tienen el formato esperado
if (!is_array($_SESSION['productos'])) {
    echo "Los datos almacenados no tienen el formato esperado";
    exit;
}

foreach ($_SESSION['productos'] as $p) {
    if (!is_array($p) || !isset($p['nombre'], $p['precio'], $p['ud'])) {
        echo "Los datos almacenados no tienen el formato esperado";
        exit;
    }
}

// Apartado 2: Consultar producto
if ($accion === 'consultar') {
    // Comprobar que el nombre del producto está presente
    if (empty($_POST['pr'])) {
        echo "El nombre del producto es obligatorio";
        exit;
    }

    $nombre = trim($_POST['pr']);
    $encontrado = null;

    foreach ($_SESSION['productos'] as $p) {
        if (strcasecmp($p['nombre'], $nombre) === 0) {
            $encontrado = $p;
            break;
        }
    }

    if ($encontrado) {
        echo generarFicha($encontrado['nombre'], $encontrado['precio'], $encontrado['ud']);
    } else {
        echo "No se ha encontrado el producto solicitado";
    if ($productoEncontrado !== null) {
        echo generarFicha(
            $productoEncontrado['nombre'],
            $productoEncontrado['precio'],
            $productoEncontrado['ud'] ?? $productoEncontrado['unidades'] ?? 0
        );
    } else {
        echo "No se ha encontrado el producto solicitado";
    }
}
}

// Apartado 3: Estadísticas
if ($accion === 'estadisticas') {
    $numDiferentes = count($_SESSION['productos']);
    $totalUnidades = 0;
    $importeTotal = 0;
    $max = null;
    $min = null;

    foreach ($_SESSION['productos'] as $p) {
        $totalUnidades += $p['ud'];
        $importeTotal += $p['precio'] * $p['ud'];

        if ($max === null || $p['precio'] > $max['precio']) {
            $max = $p;
        }
        if ($min === null || $p['precio'] < $min['precio']) {
            $min = $p;
        }
    }

    $prodMax = $max ? $max['nombre'] . " (" . number_format($max['precio'], 2) . " €)" : "Ninguno";
    $prodMin = $min ? $min['nombre'] . " (" . number_format($min['precio'], 2) . " €)" : "Ninguno";

    echo "<p>Número total de productos diferentes: $numDiferentes</p>";
    echo "<p>Número total de unidades: $totalUnidades</p>";
    echo "<p>Importe total de la compra: " . number_format($importeTotal, 2) . " €</p>";
    echo "<p>Producto con el precio más alto: $prodMax</p>";
    echo "<p>Producto con el precio más bajo: $prodMin</p>";
}
