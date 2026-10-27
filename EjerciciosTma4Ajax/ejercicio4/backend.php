<?php
header('Content-Type: application/json; charset=utf-8');

session_start();

$usuariosValidos = [
    'admin'   => '1234',
    'pepe'    => '1234',
    'juan'    => '1234',
    'roberto' => '1234',
    'ana'     => '1234'
];

$traducciones = [
    'ES' => [
        'usuario' => 'Usuario',
        'contrasena' => 'Contraseña',
        'entrar' => 'Entrar',
        'introduceNumero' => 'Introduce un número (1-10)',
        'jugar' => 'Jugar',
        'miNumero' => 'Mi número:',
        'tuNumero' => 'Tu número:',
        'mayor' => 'Lo siento, tu número es mayor',
        'menor' => 'Lo siento, tu número es menor',
        'acierto' => '¡Enhorabuena, has acertado!',
        'salir' => 'Salir',
        'loginInvalido' => 'Usuario o contraseña no válidos',
        'volver' => 'Volver'
    ],
    'EN' => [
        'usuario' => 'Username',
        'contrasena' => 'Password',
        'entrar' => 'Login',
        'introduceNumero' => 'Introduce a number (1-10)',
        'jugar' => 'Play',
        'miNumero' => 'My number:',
        'tuNumero' => 'Your number:',
        'mayor' => 'Sorry, your number is higher',
        'menor' => 'Sorry, your number is lower',
        'acierto' => 'Congratulations, you guessed it!',
        'salir' => 'Back',
        'loginInvalido' => 'Invalid username or password',
        'volver' => 'Back'
    ]
];

$action = $_REQUEST['action'] ?? '';

switch ($action) {
    case 'idioma':
        $lang = strtoupper($_REQUEST['lang'] ?? 'ES');
        if (!isset($traducciones[$lang])) {
            $lang = 'ES';
        }
        $_SESSION['idioma'] = $lang;
        echo json_encode([
            'success' => true,
            'lang' => $lang,
            'labels' => $traducciones[$lang]
        ], JSON_UNESCAPED_UNICODE);
        break;

    case 'login':
        $usuario = trim($_POST['usuario'] ?? '');
        $password = $_POST['password'] ?? '';
        $lang = strtoupper($_POST['lang'] ?? 'ES');
        if (!isset($traducciones[$lang])) {
            $lang = 'ES';
        }
        $_SESSION['idioma'] = $lang;

        if (isset($usuariosValidos[$usuario]) && $usuariosValidos[$usuario] === $password) {
            $_SESSION['usuario'] = $usuario;
            echo json_encode([
                'success' => true,
                'usuario' => $usuario,
                'lang' => $lang,
                'labels' => $traducciones[$lang]
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'credenciales_invalidas',
                'lang' => $lang,
                'labels' => $traducciones[$lang]
            ], JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'jugar':
        $numeroUsuario = isset($_POST['numero']) ? intval($_POST['numero']) : 0;
        $lang = strtoupper($_POST['lang'] ?? 'ES');
        if (!isset($traducciones[$lang])) {
            $lang = 'ES';
        }

        if ($numeroUsuario < 1 || $numeroUsuario > 10) {
            echo json_encode([
                'success' => false,
                'error' => 'rango_invalido'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $miNumero = rand(1, 10);
        $resultado = '';

        if ($numeroUsuario > $miNumero) {
            $resultado = 'mayor';
            $mensaje = $traducciones[$lang]['mayor'];
        } elseif ($numeroUsuario < $miNumero) {
            $resultado = 'menor';
            $mensaje = $traducciones[$lang]['menor'];
        } else {
            $resultado = 'acierto';
            $mensaje = $traducciones[$lang]['acierto'];
        }

        echo json_encode([
            'success' => true,
            'miNumero' => $miNumero,
            'tuNumero' => $numeroUsuario,
            'resultado' => $resultado,
            'mensaje' => $mensaje
        ], JSON_UNESCAPED_UNICODE);
        break;

    case 'salir':
        $ultimoUsuario = $_SESSION['usuario'] ?? '';
        unset($_SESSION['usuario']);
        echo json_encode([
            'success' => true,
            'ultimoUsuario' => $ultimoUsuario
        ], JSON_UNESCAPED_UNICODE);
        break;

    default:
        echo json_encode([
            'success' => false,
            'error' => 'accion_no_valida'
        ], JSON_UNESCAPED_UNICODE);
        break;
}
