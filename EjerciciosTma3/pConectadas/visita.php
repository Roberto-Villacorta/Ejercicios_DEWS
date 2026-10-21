<?php
include_once "./utilHTML.php";
$idioma = [
    "español" => "es",
    "ingles" => "en"
]
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información de Cookies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Cookies activas en esta página</h2>

    <?php if (empty($_COOKIE)): ?>
        <p><em>No hay cookies disponibles para esta ruta o dominio.</em></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre de la cookie</th>
                    <th>Valor / Contenido</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_COOKIE as $nombre => $valor): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($nombre) ?></strong></td>
                        <td><?= htmlspecialchars($valor) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php
    pintarRadio("idioma",$idioma)
    ?>
    <button onclick="history.back()">
        Volver
    </button>

</body>
</html>