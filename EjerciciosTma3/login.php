<?php
$usuarios = [
"usuarios" => [
    "n1",
    "n2",
    "n3",
    "macarrones"
],
"claves" =>[
    "1",
    "2",
    "3",
    "4"
]
];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $clave  = $_POST['clave'] ?? '';

    $indiceUsuario = array_search($nombre, $usuarios['usuarios'], true);

    if (
        $indiceUsuario !== false 
        && isset($usuarios['claves'][$indiceUsuario]) 
        && $usuarios['claves'][$indiceUsuario] === $clave
    ) {
        setcookie("usuario_conectado", $nombre, time() + 3600, "/");
        $vecesEntradas = isset($_COOKIE["entradas"]) ? (int)$_COOKIE["entradas"] + 1 : 1;
        setcookie("entradas", (string)$vecesEntradas, time() + (86400 * 30), "/");
        header("Location: /wPHP/pConectadas/visita.php");
        exit;
    } else {
        $error = "No eres un usuario válido";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado y creación de cookies</title>
</head>
<body>
     <h1>Formulario de registro</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="" method= "POST" >
    Usuario: <input type="text" name="nombre" required><br>
    Clave: <input type="text" name="clave" required><br>
    <button onclick="submit()">Autentificar</button>
    </form>
   

</body>
</html>