<?php
include 'util.php';
$bd = conectarMySql();

$id_persona = isset($_POST['id_persona']) ? (int)$_POST['id_persona'] : null;
$accion     = isset($_POST['accion'])     ? $_POST['accion']           : 'R';

if (!$id_persona) { header('Location:index.php'); exit; }

// Datos de la persona
$stP = $bd->prepare("SELECT * FROM PERSONA WHERE id_persona = :id");
$stP->execute([':id' => $id_persona]);
$persona = $stP->fetch(PDO::FETCH_ASSOC);

if (!$persona) { header('Location:index.php'); exit; }

$paises    = $bd->query("SELECT * FROM PAIS   ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$aficiones = $bd->query("SELECT * FROM AFICION ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

// IDs de gustos y odios actuales
$gustosAct = $bd->prepare("SELECT id_aficion FROM GUSTO WHERE id_persona=:id");
$gustosAct->execute([':id' => $id_persona]);
$idsGustos = array_column($gustosAct->fetchAll(PDO::FETCH_ASSOC), 'id_aficion');

$odiosAct  = $bd->prepare("SELECT id_aficion FROM ODIO  WHERE id_persona=:id");
$odiosAct->execute([':id' => $id_persona]);
$idsOdios  = array_column($odiosAct->fetchAll(PDO::FETCH_ASSOC), 'id_aficion');

$readonly  = $accion === 'R' ? 'readonly' : '';
$disabled  = $accion === 'R' ? 'disabled' : '';
$titulo    = $accion === 'R' ? 'Consulta' : 'Edición';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title><?= $titulo ?> de persona</title>
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
        .btn-guardar { background:#f39c12; color:#fff; border:none; padding:7px 20px; cursor:pointer; font-size:1em; border-radius:3px; }
    </style>
</head>
<body>
    <h2><?= $titulo ?> de persona</h2>

    <form action="personaUpost.php" method="post">
        <input type="hidden" name="id_persona" value="<?= $persona['id_persona'] ?>">

        <fieldset>
            <legend>Datos personales</legend>

            <label class="campo">ID</label>
            <input type="text" value="<?= $persona['id_persona'] ?>" readonly><br>

            <label class="campo" for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre"
                   value="<?= htmlspecialchars($persona['nombre']) ?>" <?= $readonly ?>><br>

            <label class="campo" for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido"
                   value="<?= htmlspecialchars($persona['apellido']) ?>" <?= $readonly ?>><br>

            <label class="campo" for="id_pais_nace">País de nacimiento</label>
            <select name="id_pais_nace" id="id_pais_nace" <?= $disabled ?>>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id_pais'] ?>"
                        <?= $p['id_pais'] == $persona['id_pais_nace'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label class="campo" for="id_pais_vive">País de residencia</label>
            <select name="id_pais_vive" id="id_pais_vive" <?= $disabled ?>>
                <option value="">-- Ninguno --</option>
                <?php foreach ($paises as $p): ?>
                    <option value="<?= $p['id_pais'] ?>"
                        <?= $p['id_pais'] == $persona['id_pais_vive'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </fieldset>

        <fieldset>
            <legend>✅ Gustos</legend>
            <div class="grupo-checks">
            <?php foreach ($aficiones as $a): ?>
                <label>
                    <input type="checkbox" class="gustos-cb" name="gustos[]"
                           value="<?= $a['id_aficion'] ?>"
                           <?= in_array($a['id_aficion'], $idsGustos) ? 'checked' : '' ?>
                           <?= $disabled ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </label>
            <?php endforeach; ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>❌ Odios</legend>
            <div class="grupo-checks">
            <?php foreach ($aficiones as $a): ?>
                <label>
                    <input type="checkbox" class="odios-cb" name="odios[]"
                           value="<?= $a['id_aficion'] ?>"
                           <?= in_array($a['id_aficion'], $idsOdios) ? 'checked' : '' ?>
                           <?= $disabled ?>>
                    <?= htmlspecialchars($a['nombre']) ?>
                </label>
            <?php endforeach; ?>
            </div>
        </fieldset>

        <?php if ($accion === 'U'): ?>
            <button type="submit" class="btn-guardar">Actualizar</button>
        <?php endif; ?>
    </form>

    <br>
    <form action="index.php"><input type="submit" value="← Menú principal"></form>
</body>
</html>
