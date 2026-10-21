<?php
require_once __DIR__ . '/funciones.php';

// Verificar que el usuario tenga sesión activa mediante cookie
$usuarioActivo = obtenerUsuarioActivo();
if ($usuarioActivo === null) {
    header('Location: login.php');
    exit;
}

// Obtener el destinatario
$destinatario = trim($_POST['para'] ?? $_GET['para'] ?? '');

// Si no hay destinatario o es uno mismo, volver a la lista
if ($destinatario === '' || $destinatario === $usuarioActivo) {
    header('Location: listaUsuarios.php');
    exit;
}

$mensajeError = '';

// Procesar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto = trim($_POST['texto'] ?? '');

    if ($texto === '') {
        $mensajeError = 'El mensaje no puede estar vacío.';
    } else {
        // Almacenar el mensaje: la fecha y hora se calcula en el servidor
        agregarMensaje($usuarioActivo, $destinatario, $texto);

        // Redirigir a la lista de usuarios con indicador de envío exitoso
        header('Location: listaUsuarios.php?enviado=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escribir Mensaje - Mensajería</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Escribir Mensaje</h1>
            <a href="listaUsuarios.php" class="btn btn-secondary btn-sm">Volver a la Lista</a>
        </div>

        <?php if ($mensajeError !== ''): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($mensajeError) ?>
            </div>
        <?php endif; ?>

        <form action="escribir.php" method="post">
            <!-- Destinatario en campo oculto para envío seguro -->
            <input type="hidden" name="para" value="<?= htmlspecialchars($destinatario) ?>">

            <!-- Campo informativo "De" (no modificable) -->
            <div class="form-group">
                <label for="campo_de">De (remitente):</label>
                <input 
                    type="text" 
                    id="campo_de" 
                    class="form-control" 
                    value="<?= htmlspecialchars($usuarioActivo) ?>" 
                    readonly
                >
            </div>

            <!-- Campo informativo "Para" (no modificable) -->
            <div class="form-group">
                <label for="campo_para">Para (destinatario):</label>
                <input 
                    type="text" 
                    id="campo_para" 
                    class="form-control" 
                    value="<?= htmlspecialchars($destinatario) ?>" 
                    readonly
                >
            </div>

            <!-- Campo de texto del mensaje -->
            <div class="form-group">
                <label for="texto">Mensaje:</label>
                <textarea 
                    id="texto" 
                    name="texto" 
                    class="form-control" 
                    required 
                    placeholder="Escribe tu mensaje aquí..."
                    autofocus
                ><?= htmlspecialchars($_POST['texto'] ?? '') ?></textarea>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">Enviar Mensaje</button>
                <a href="listaUsuarios.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
