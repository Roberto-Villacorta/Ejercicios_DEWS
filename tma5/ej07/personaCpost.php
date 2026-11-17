<?php
include 'util.php';
$bd = conectarMySql();

$nombre       = isset($_POST['nombre'])       ? trim($_POST['nombre'])       : null;
$apellido     = isset($_POST['apellido'])     ? trim($_POST['apellido'])     : null;
$id_pais_nace = isset($_POST['id_pais_nace']) && $_POST['id_pais_nace'] !== '' ? (int)$_POST['id_pais_nace'] : null;
$id_pais_vive = isset($_POST['id_pais_vive']) && $_POST['id_pais_vive'] !== '' ? (int)$_POST['id_pais_vive'] : null;
$gustos       = isset($_POST['gustos'])       ? $_POST['gustos']       : [];
$odios        = isset($_POST['odios'])        ? $_POST['odios']        : [];

$ok = false;

if ($nombre && $apellido && $id_pais_nace) {
    try {
        $bd->beginTransaction();

        // 1. Insertar PERSONA
        $sqlPersona = <<<SQL
            INSERT INTO PERSONA (nombre, apellido, id_pais_nace, id_pais_vive)
            VALUES (:nombre, :apellido, :id_pais_nace, :id_pais_vive)
SQL;
        $st = $bd->prepare($sqlPersona);
        $st->bindParam(':nombre',       $nombre);
        $st->bindParam(':apellido',     $apellido);
        $st->bindParam(':id_pais_nace', $id_pais_nace, PDO::PARAM_INT);
        $st->bindValue(':id_pais_vive', $id_pais_vive, PDO::PARAM_INT);
        $st->execute();
        $id_persona = $bd->lastInsertId();

        // 2. Insertar GUSTOS (N:M)
        $stGusto = $bd->prepare("INSERT INTO GUSTO (id_persona, id_aficion) VALUES (:id_persona, :id_aficion)");
        foreach ($gustos as $id_aficion) {
            $stGusto->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
            $stGusto->bindParam(':id_aficion', $id_aficion, PDO::PARAM_INT);
            $stGusto->execute();
        }

        // 3. Insertar ODIOS (N:M)
        $stOdio = $bd->prepare("INSERT INTO ODIO (id_persona, id_aficion) VALUES (:id_persona, :id_aficion)");
        foreach ($odios as $id_aficion) {
            $stOdio->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
            $stOdio->bindParam(':id_aficion', $id_aficion, PDO::PARAM_INT);
            $stOdio->execute();
        }

        $bd->commit();
        $ok = true;

    } catch (PDOException $e) {
        $bd->rollBack();
        $ok = false;
    }
}

// Patrón PRG
header("Location:personaCpostMensaje.php?ok=" . ($ok ? '1' : '0'));
?>
