<?php
$productos = [
    "cod" => ["P001", "P002", "P003", "P004"],
    "Producto" => ["Ram", "SSD", "GPU", "PSU"],
    "categoria" => ["Componentes", "Almacenamiento", "Componentes", "Componentes"],
    "precio" => [35, 75, 299, 65],
    "unidades" => [12, 8, 0, 5]
];

$categoriasPermitidas = ["Componentes", "Almacenamiento", "Periféricos", "Monitores"];

$errores = [];
$datosForm = [
    "cod" => "",
    "nombre" => "",
    "categoria" => "",
    "precio" => "",
    "unidades" => "",
    "disponibilidad" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $datosForm["cod"] = trim($_POST["cod"] ?? "");
    $datosForm["nombre"] = trim($_POST["nombre"] ?? "");
    $datosForm["categoria"] = $_POST["categoria"] ?? "";
    $datosForm["precio"] = trim($_POST["precio"] ?? "");
    $datosForm["unidades"] = trim($_POST["unidades"] ?? "");
    $datosForm["disponibilidad"] = $_POST["disponibilidad"] ?? "";

    if ($datosForm["cod"] === "" || $datosForm["nombre"] === "" || $datosForm["categoria"] === "" || 
        $datosForm["precio"] === "" || $datosForm["unidades"] === "" || $datosForm["disponibilidad"] === "") {
        $errores[] = "Todos los campos del formulario son obligatorios.";
    }

    if ($datosForm["precio"] !== "" && (!is_numeric($datosForm["precio"]) || $datosForm["precio"] <= 0)) {
        $errores[] = "El precio debe ser un número mayor que 0.";
    }

    if ($datosForm["unidades"] !== "" && (!filter_var($datosForm["unidades"], FILTER_VALIDATE_INT, ["options" => ["min_range" => 0]]) && $datosForm["unidades"] !== "0")) {
        $errores[] = "Las unidades deben ser un número entero no negativo.";
    }

    if (in_array(strtoupper($datosForm["cod"]), array_map('strtoupper', $productos["cod"]))) {
        $errores[] = "El código ingresado ya existe en el sistema.";
    }

    if ($datosForm["categoria"] !== "" && !in_array($datosForm["categoria"], $categoriasPermitidas)) {
        $errores[] = "La categoría seleccionada no es válida.";
    }

    if (empty($errores)) {
        $productos["cod"][] = strtoupper($datosForm["cod"]);
        $productos["Producto"][] = $datosForm["nombre"];
        $productos["categoria"][] = $datosForm["categoria"];
        $productos["precio"][] = (float)$datosForm["precio"];
        $productos["unidades"][] = (int)$datosForm["unidades"];

        $mensajeExito = "¡Producto añadido correctamente al inventario temporal!";
        
        // Limpiar formulario tras éxito
        $datosForm = array_fill_keys(array_keys($datosForm), "");
    }
}


function calcularValorInventario($cat) {
    $total = 0;
    $numProductos = count($cat["cod"]);
    for ($i = 0; $i < $numProductos; $i++) {
        $total += $cat["precio"][$i] * $cat["unidades"][$i];
    }
    return $total;
}

$totalProductos = count($productos["cod"]);
$totalUnidades = array_sum($productos["unidades"]);
$valorTotalInventario = calcularValorInventario($productos);

// Producto más caro
$maxPrecioIndex = array_search(max($productos["precio"]), $productos["precio"]);
$productoMasCaro = $productos["Producto"][$maxPrecioIndex] . " (" . $productos["precio"][$maxPrecioIndex] . "€)";

// Productos agotados
$agotados = [];
for ($i = 0; $i < $totalProductos; $i++) {
    if ($productos["unidades"][$i] == 0) {
        $agotados[] = $productos["Producto"][$i] . " [" . $productos["cod"][$i] . "]";
    }
}

$busqueda = trim($_GET["q"] ?? "");
$resultadosBusqueda = [];

if ($busqueda !== "") {
    for ($i = 0; $i < $totalProductos; $i++) {
        if (mb_stripos($productos["Producto"][$i], $busqueda) !== false || 
            mb_stripos($productos["categoria"][$i], $busqueda) !== false) {
            $resultadosBusqueda[] = [
                "cod" => $productos["cod"][$i],
                "nombre" => $productos["Producto"][$i],
                "categoria" => $productos["categoria"][$i],
                "precio" => $productos["precio"][$i],
                "unidades" => $productos["unidades"][$i]
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario PHP</title>
</head>
<body>

    <h1>Sistema de Control de Inventario</h1>

    <div class="seccion">
        <h2>Apartado 2. Valor del Inventario</h2>
        <ul>
            <li><strong>Número total de productos diferentes:</strong> <?= $totalProductos ?></li>
            <li><strong>Número total de unidades almacenadas:</strong> <?= $totalUnidades ?></li>
            <li><strong>Valor económico total del inventario:</strong> <?= number_format($valorTotalInventario, 2) ?> €</li>
            <li><strong>Producto más caro:</strong> <?= $productoMasCaro ?></li>
            <li><strong>Productos agotados:</strong> 
                <?php if (!empty($agotados)): ?>
                    <?php foreach ($agotados as $prodAgotado): ?>
                        <span class="agotado"><?= $prodAgotado ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    Ninguno
                <?php endif; ?>
            </li>
        </ul>
    </div>

    <div class="seccion">
        <h2>Apartado 3. Añadir Nuevo Producto</h2>

        <?php if (!empty($errores)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errores as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($mensajeExito)): ?>
            <div class="exito"><?= htmlspecialchars($mensajeExito) ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div>
                <label for="cod">Código:</label>
                <input type="text" id="cod" name="cod" value="<?= htmlspecialchars($datosForm["cod"]) ?>">
            </div>
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($datosForm["nombre"]) ?>">
            </div>
            <div>
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="">-- Seleccionar --</option>
                    <?php foreach ($categoriasPermitidas as $cat): ?>
                        <option value="<?= $cat ?>" <?= $datosForm["categoria"] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="precio">Precio (€):</label>
                <input type="text" id="precio" name="precio" value="<?= htmlspecialchars($datosForm["precio"]) ?>">
            </div>
            <div>
                <label for="unidades">Unidades:</label>
                <input type="number" id="unidades" name="unidades" value="<?= htmlspecialchars($datosForm["unidades"]) ?>">
            </div>
            <div>
                <label>Disponibilidad:</label>
                <input type="radio" id="disp_si" name="disponibilidad" value="Si" <?= $datosForm["disponibilidad"] === "Si" ? "checked" : "" ?>>
                <label for="disp_si" style="width: auto;">Disponible</label>
                <input type="radio" id="disp_no" name="disponibilidad" value="No" <?= $datosForm["disponibilidad"] === "No" ? "checked" : "" ?>>
                <label for="disp_no" style="width: auto;">No disponible</label>
            </div>
            <br>
            <button type="submit">Añadir Producto</button>
        </form>
    </div>

    <div class="seccion">
        <h2>Apartado 4. Búsqueda de Productos</h2>
        <form action="" method="GET">
            <input type="text" name="q" placeholder="Nombre o categoría..." value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit">Buscar</button>
        </form>

        <?php if ($busqueda !== ""): ?>
            <h3>Resultados de la búsqueda para: "<?= htmlspecialchars($busqueda) ?>"</h3>
            <?php if (!empty($resultadosBusqueda)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Unidades</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultadosBusqueda as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res["cod"]) ?></td>
                                <td><?= htmlspecialchars($res["nombre"]) ?></td>
                                <td><?= htmlspecialchars($res["categoria"]) ?></td>
                                <td><?= $res["precio"] ?> €</td>
                                <td><?= $res["unidades"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se han encontrado productos que coincidan con la búsqueda.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>