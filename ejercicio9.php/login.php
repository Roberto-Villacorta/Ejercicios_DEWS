<?php
require_once __DIR__ . '/funciones.php';

// Obtener el nombre del último usuario recordado mediante cookie
$ultimoUsuario = obtenerUltimoUsuarioRecordado();
$recordarChecked = ($ultimoUsuario !== '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Mensajería</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Iniciar Sesión</h1>
            <span class="user-badge">Cookies</span>
        </div>

        <!-- Formulario con destino a listaUsuarios.php y autocomplete desactivado -->
        <form action="listaUsuarios.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="usuario">Nombre de Usuario:</label>
                <input 
                    type="text" 
                    id="usuario" 
                    name="usuario" 
                    class="form-control" 
                    value="<?= htmlspecialchars($ultimoUsuario) ?>" 
                    required 
                    autocomplete="off"
                    placeholder="Introduce tu usuario"
                    <?= $ultimoUsuario ? '' : 'autofocus' ?>
                >
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required 
                    autocomplete="new-password"
                    placeholder="Introduce tu contraseña"
                    <?= $ultimoUsuario ? 'autofocus' : '' ?>
                >
            </div>

            <div class="form-group">
                <label class="checkbox-label" for="recordar">
                    <input 
                        type="checkbox" 
                        id="recordar" 
                        name="recordar" 
                        value="1" 
                        <?= $recordarChecked ? 'checked' : '' ?>
                    >
                    Recordar usuario
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>

        <div class="links-footer">
            <p>¿Aún no tienes cuenta? <a href="registrar.php">Crear una cuenta nueva</a></p>
        </div>

        <div style="margin-top: 24px; padding: 12px; background-color: #f8fafc; border-radius: 8px; font-size: 0.85rem; color: #64748b; border: 1px dashed #cbd5e1;">
            <strong>Usuarios de prueba disponibles:</strong><br>
            • <code>admin</code> (clave: <code>1234</code>)<br>
            • <code>maria</code> (clave: <code>1234</code>)<br>
            • <code>pepe</code> (clave: <code>1234</code>)
        </div>
    </div>
</body>
</html>
