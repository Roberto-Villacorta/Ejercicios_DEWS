<?php
include 'util.php';
$bd = conectarMySql();

$id_persona = isset($_POST['id_persona']) ? (int)$_POST['id_persona'] : null;
$ok = false;

if ($id_persona) {
    try {
        // Las FK con ON DELETE CASCADE eliminan GUSTO y ODIO automáticamente
        $st = $bd->prepare("DELETE FROM PERSONA WHERE id_persona = :id");
        $st->execute([':id' => $id_persona]);
        $ok = $st->rowCount() > 0;
    } catch (PDOException $e) {
        $ok = false;
    }
}

header("Location:personaDpostMensaje.php?ok=" . ($ok ? '1' : '0'));
?>
