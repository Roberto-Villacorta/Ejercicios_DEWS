<?php
/**
 * funciones.php
 * Gestión de datos mediante COOKIES para la aplicación de mensajería.
 */

// Nombres de las cookies
define('COOKIE_USUARIOS', 'app_usuarios');
define('COOKIE_MENSAJES', 'app_mensajes');
define('COOKIE_ACTIVO', 'app_usuario_activo');
define('COOKIE_RECORDAR', 'app_ultimo_usuario');

// Tiempo de expiración de cookies persistentes (30 días)
define('TIEMPO_PERSISTENTE', time() + (3600 * 24 * 30));

/**
 * Obtiene la lista de usuarios registrados desde la cookie.
 * Si no existe, inicializa con usuarios de prueba.
 */
function obtenerUsuarios(): array {
    if (isset($_COOKIE[COOKIE_USUARIOS])) {
        $usuarios = json_decode($_COOKIE[COOKIE_USUARIOS], true);
        if (is_array($usuarios)) {
            return $usuarios;
        }
    }

    // Usuarios iniciales de prueba (usuario => contraseña)
    $usuariosDefecto = [
        'admin' => '1234',
        'maria' => '1234',
        'pepe'  => '1234'
    ];
    guardarUsuarios($usuariosDefecto);
    return $usuariosDefecto;
}

/**
 * Guarda el array de usuarios en la cookie correspondiente.
 */
function guardarUsuarios(array $usuarios): void {
    $valor = json_encode($usuarios);
    setcookie(COOKIE_USUARIOS, $valor, TIEMPO_PERSISTENTE, '/');
    $_COOKIE[COOKIE_USUARIOS] = $valor;
}

/**
 * Obtiene todos los mensajes almacenados en la cookie.
 * Si no existen, inicializa con un par de mensajes de ejemplo.
 */
function obtenerMensajes(): array {
    if (isset($_COOKIE[COOKIE_MENSAJES])) {
        $mensajes = json_decode($_COOKIE[COOKIE_MENSAJES], true);
        if (is_array($mensajes)) {
            return $mensajes;
        }
    }

    // Mensajes de bienvenida de ejemplo
    $mensajesDefecto = [
        [
            'de'    => 'maria',
            'para'  => 'admin',
            'fecha' => '19/10/2026 09:00:00',
            'texto' => '¡Hola admin! ¿Qué tal estás?'
        ],
        [
            'de'    => 'maria',
            'para'  => 'admin',
            'fecha' => '19/10/2026 09:05:00',
            'texto' => 'Te he dejado los informes preparados en tu despacho.'
        ],
        [
            'de'    => 'pepe',
            'para'  => 'admin',
            'fecha' => '19/10/2026 09:15:00',
            'texto' => 'Acuérdate de la reunión de hoy a las 11:00.'
        ],
        [
            'de'    => 'admin',
            'para'  => 'maria',
            'fecha' => '19/10/2026 09:20:00',
            'texto' => 'Muchas gracias María, los reviso en un momento.'
        ]
    ];
    guardarMensajes($mensajesDefecto);
    return $mensajesDefecto;
}

/**
 * Guarda los mensajes en la cookie.
 */
function guardarMensajes(array $mensajes): void {
    $valor = json_encode($mensajes);
    setcookie(COOKIE_MENSAJES, $valor, TIEMPO_PERSISTENTE, '/');
    $_COOKIE[COOKIE_MENSAJES] = $valor;
}

/**
 * Añade un nuevo mensaje al almacenamiento por cookies.
 */
function agregarMensaje(string $de, string $para, string $texto): void {
    $mensajes = obtenerMensajes();
    $mensajes[] = [
        'de'    => $de,
        'para'  => $para,
        'fecha' => date('d/m/Y H:i:s'),
        'texto' => $texto
    ];
    guardarMensajes($mensajes);
}

/**
 * Cuenta cuántos mensajes ha enviado $de a $para.
 */
function contarMensajes(string $de, string $para): int {
    $mensajes = obtenerMensajes();
    $total = 0;
    foreach ($mensajes as $msg) {
        if ($msg['de'] === $de && $msg['para'] === $para) {
            $total++;
        }
    }
    return $total;
}

/**
 * Obtiene todos los mensajes enviados por $de a $para.
 */
function obtenerMensajesRecibidos(string $de, string $para): array {
    $mensajes = obtenerMensajes();
    $resultado = [];
    foreach ($mensajes as $msg) {
        if ($msg['de'] === $de && $msg['para'] === $para) {
            $resultado[] = $msg;
        }
    }
    return $resultado;
}

/**
 * Obtiene el usuario activo actual desde la cookie.
 */
function obtenerUsuarioActivo(): ?string {
    if (isset($_COOKIE[COOKIE_ACTIVO]) && trim($_COOKIE[COOKIE_ACTIVO]) !== '') {
        $usuario = trim($_COOKIE[COOKIE_ACTIVO]);
        $usuarios = obtenerUsuarios();
        if (isset($usuarios[$usuario])) {
            return $usuario;
        }
    }
    return null;
}

/**
 * Inicia sesión guardando el usuario activo en cookie.
 * Gestiona además la cookie de recordar.
 */
function iniciarSesion(string $usuario, bool $recordar): void {
    // Cookie de sesión (expira al cerrar navegador, o 1 día)
    setcookie(COOKIE_ACTIVO, $usuario, time() + (3600 * 24), '/');
    $_COOKIE[COOKIE_ACTIVO] = $usuario;

    if ($recordar) {
        // Recordar usuario: guardamos su nombre por 30 días
        setcookie(COOKIE_RECORDAR, $usuario, TIEMPO_PERSISTENTE, '/');
        $_COOKIE[COOKIE_RECORDAR] = $usuario;
    } else {
        // Si no se marca recordar, borramos la cookie de recordar si existía
        setcookie(COOKIE_RECORDAR, '', time() - 3600, '/');
        unset($_COOKIE[COOKIE_RECORDAR]);
    }
}

/**
 * Cierra la sesión eliminando la cookie del usuario activo.
 */
function cerrarSesion(): void {
    setcookie(COOKIE_ACTIVO, '', time() - 3600, '/');
    unset($_COOKIE[COOKIE_ACTIVO]);
}

/**
 * Obtiene el nombre del último usuario que entró con la opción 'recordar'.
 */
function obtenerUltimoUsuarioRecordado(): string {
    return $_COOKIE[COOKIE_RECORDAR] ?? '';
}

/**
 * Valida las credenciales de un usuario.
 */
function validarCredenciales(string $usuario, string $password): bool {
    $usuarios = obtenerUsuarios();
    if (!isset($usuarios[$usuario])) {
        return false;
    }
    return $usuarios[$usuario] === $password;
}

/**
 * Registra un nuevo usuario en la cookie.
 * Retorna true si tuvo éxito, false si ya existía.
 */
function registrarUsuario(string $usuario, string $password): bool {
    $usuarios = obtenerUsuarios();
    if (isset($usuarios[$usuario])) {
        return false;
    }
    $usuarios[$usuario] = $password;
    guardarUsuarios($usuarios);
    return true;
}
