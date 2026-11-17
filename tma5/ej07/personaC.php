<?php
include 'util.php';
$bd = conectarMySql();

$paises   = $bd->query("SELECT * FROM PAIS   ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$aficiones = $bd->query("SELECT * FROM AFICION ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nueva Persona</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; }
        h2   { color: #2c3e50; }
        fieldset { margin-bottom: 14px; padding: 12px 18px; border: 1px solid #aaa; border-radius: 4px; }
        legend   { font-weight: bold; color: #2980b9; }
        label.campo { display: inline-block; width: 160px; }
        input[type=text], select { width: 220px; padding: 4px; margin-bottom: 8px; }
        .grupo-checks { column-count: 2; column-gap: 20px; margin-top: 6px; }
        .grupo-checks label { display: block; margin-bottom: 4px; }
        .gustos-cb { accent-color: #27ae60; }
        .odios-cb  { accent-color: #e74c3c; }
        .btn-guardar { background:#27ae60; color:#fff; border:none; padding:7px 20px; cursor:pointer; font-size:1em; border-radius:3px; }
        .btn-volver  { margin-top:10px; }
    </style>
</head>
<body>
    <h2>Nueva persona</h2>

    <form action="personaCpost.php" method="post">

        <fieldset>
            <legend>Datos personales</legend>

            <label class="campo" for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required><br>

            <label class="campo" for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" required><br>

            <label class="campo" for="id_pais_nace">País de nacimiento</label>
            <select name="id_pais_nace" id="id_pais_nace" required>
                <option value="">-- Selecciona --</option>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id_pais'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endforeach; ?>
            </select><br>

            <label class="campo" for="id_pais_vive">País de residencia</label>
            <select name="id_pais_vive" id="id_pais_vive">
                <option value="">-- Ninguno --</option>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id_pais'] ?>"><?= htmlspecialchars($p['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset>
            <legend>✅ Gustos (aficiones que le gustan)</legend>
            <div class="grupo-checks">
            <?php foreach ($aficiones as $a): ?>
                <label>
                    <input type="checkbox" class="gustos-cb"
                           name="gustos[]" value="<?= $a['id_aficion'] ?>">
                    <?= htmlspecialchars($a['nombre']) ?>
                </label>
            <?php endforeach; ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>❌ Odios (aficiones que odia)</legend>
            <div class="grupo-checks">
            <?php foreach ($aficiones as $a): ?>
                <label>
                    <input type="checkbox" class="odios-cb"
                           name="odios[]" value="<?= $a['id_aficion'] ?>">
                    <?= htmlspecialchars($a['nombre']) ?>
                </label>
            <?php endforeach; ?>
            </div>
        </fieldset>

        <button type="submit" class="btn-guardar">Guardar persona</button>
    </form>

    <div class="btn-volver">
        <form action="index.php"><input type="submit" value="← Menú principal"></form>
    </div>
</body>
</html>
