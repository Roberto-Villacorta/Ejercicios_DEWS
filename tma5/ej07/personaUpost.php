<?php
include 'util.php';
$bd = conectarMySql();

$id_persona   = isset($_POST['id_persona'])   ? (int)$_POST['id_persona']   : null;
$nombre       = isset($_POST['nombre'])       ? trim($_POST['nombre'])       : null;
$apellido     = isset($_POST['apellido'])     ? trim($_POST['apellido'])     : null;
$id_pais_nace = isset($_POST['id_pais_nace']) && $_POST['id_pais_nace'] !== '' ? (int)$_POST['id_pais_nace'] : null;
$id_pais_vive = isset($_POST['id_pais_vive']) && $_POST['id_pais_vive'] !== '' ? (int)$_POST['id_pais_vive'] : null;
$gustos       = isset($_POST['gustos'])       ? $_POST['gustos'] : [];
$odios        = isset($_POST['odios'])        ? $_POST['odios']  : [];

$ok = false;

if ($id_persona && $nombre && $apellido && $id_pais_nace) {
    try {
        $bd->beginTransaction();

        // 1. Actualizar PERSONA
        $st = $bd->prepare(<<<SQL
            UPDATE PERSONA
            SET nombre=:nombre, apellido=:apellido,
                id_pais_nace=:id_pais_nace, id_pais_vive=:id_pais_vive
            WHERE id_persona=:id_persona
SQL);
        $st->execute([
            ':nombre'       => $nombre,
            ':apellido'     => $apellido,
            ':id_pais_nace' => $id_pais_nace,
            ':id_pais_vive' => $id_pais_vive,
            ':id_persona'   => $id_persona,
        ]);

        // 2. Reemplazar GUSTOS: borrar los actuales e insertar los nuevos
        $bd->prepare("DELETE FROM GUSTO WHERE id_persona=:id")->execute([':id' => $id_persona]);
        $stG = $bd->prepare("INSERT INTO GUSTO (id_persona,id_aficion) VALUES (:p,:a)");
        foreach ($gustos as $a) {
            $stG->execute([':p' => $id_persona, ':a' => (int)$a]);
        }

        // 3. Reemplazar ODIOS
        $bd->prepare("DELETE FROM ODIO WHERE id_persona=:id")->execute([':id' => $id_persona]);
        $stO = $bd->prepare("INSERT INTO ODIO (id_persona,id_aficion) VALUES (:p,:a)");
        foreach ($odios as $a) {
            $stO->execute([':p' => $id_persona, ':a' => (int)$a]);
        }

        $bd->commit();
        $ok = true;

    } catch (PDOException $e) {
        $bd->rollBack();
        $ok = false;
    }
}

header("Location:personaUpostMensaje.php?ok=" . ($ok ? '1' : '0'));
?>
