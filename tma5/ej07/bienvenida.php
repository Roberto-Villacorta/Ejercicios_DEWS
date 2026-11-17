<?php
include 'util.php';
$bd = conectarMySql();

// Recuperar personas con nombres de país
$sql = <<<SQL
    SELECT p.id_persona, p.nombre, p.apellido,
           pn.nombre AS pais_nace,
           pv.nombre AS pais_vive
    FROM PERSONA p
    JOIN PAIS pn ON p.id_pais_nace = pn.id_pais
    LEFT JOIN PAIS pv ON p.id_pais_vive = pv.id_pais
    ORDER BY p.apellido, p.nombre
SQL;
$personas = $bd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Personas - Menú</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        h1   { color: #2c3e50; }
        table { border-collapse: collapse; width: 100%; margin-top: 12px; }
        th, td { border: 1px solid #aaa; padding: 7px 12px; text-align: left; }
        th { background: #2980b9; color: #fff; }
        tr:nth-child(even) { background: #f0f4f8; }
        .btn-crear  { background:#27ae60; color:#fff; border:none; padding:7px 16px; cursor:pointer; font-size:1em; border-radius:3px; }
        .btn-editar { background:#f39c12; color:#fff; border:none; padding:4px 10px; cursor:pointer; border-radius:3px; }
        .btn-borrar { background:#e74c3c; color:#fff; border:none; padding:4px 10px; cursor:pointer; border-radius:3px; }
        .acciones   { margin-bottom: 14px; }
        .vacia      { color: #999; font-style: italic; }
    </style>
</head>
<body>
    <h1>Gestión de Personas</h1>

    <div class="acciones">
        <form action="personaC.php" method="get" style="display:inline">
            <button type="submit" class="btn-crear">+ Nueva persona</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>País nacimiento</th>
                <th>País residencia</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($personas)): ?>
            <tr><td colspan="7" class="vacia">No hay personas registradas.</td></tr>
        <?php else: ?>
            <?php foreach ($personas as $p): ?>
            <tr>
                <td><?= $p['id_persona'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['apellido']) ?></td>
                <td><?= htmlspecialchars($p['pais_nace']) ?></td>
                <td><?= htmlspecialchars($p['pais_vive'] ?? '—') ?></td>
                <td>
                    <form action="personaRUpost.php" method="post">
                        <input type="hidden" name="id_persona" value="<?= $p['id_persona'] ?>">
                        <input type="hidden" name="accion"     value="U">
                        <button type="submit" class="btn-editar">Editar</button>
                    </form>
                </td>
                <td>
                    <form action="personaDpost.php" method="post"
                          onsubmit="return confirm('¿Borrar a <?= htmlspecialchars($p['nombre'].' '.$p['apellido']) ?>?')">
                        <input type="hidden" name="id_persona" value="<?= $p['id_persona'] ?>">
                        <button type="submit" class="btn-borrar">Borrar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
