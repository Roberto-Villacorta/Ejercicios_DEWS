<?php
$ok  = isset($_GET['ok']) && $_GET['ok'] === '1';
$msg = $ok ? '✅ Persona borrada correctamente' : '❌ Error al borrar (puede que no exista)';
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="utf-8"><title>Resultado</title>
<style>body{font-family:Arial,sans-serif;margin:24px;} h2{color:<?= $ok?'#27ae60':'#e74c3c' ?>}</style>
</head>
<body>
    <h2><?= $msg ?></h2>
    <form action="index.php"><input type="submit" value="← Menú principal"></form>
</body>
</html>
