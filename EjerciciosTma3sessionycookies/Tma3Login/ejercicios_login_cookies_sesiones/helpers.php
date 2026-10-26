<?php
/**
 * Helpers y utilidades comunes para los ejercicios de Cookies y Sesiones (DEWS).
 */

if (!function_exists('escaparHtml')) {
    /**
     * Escapa caracteres especiales para salida segura en HTML.
     */
    function escaparHtml(mixed $valor): string
    {
        return htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('h')) {
    /**
     * Alias abreviado de escaparHtml para compatibilidad.
     */
    function h(mixed $valor): string
    {
        return escaparHtml($valor);
    }
}

if (!function_exists('renderizarNavegacion')) {
    /**
     * Renderiza navegación para volver a la página principal y enlaces adicionales.
     */
    function renderizarNavegacion(string $titulo, string $rutaInicio = '../index.php', array $enlacesExtra = []): void
    {
        ?>
        <p>
            <a href="<?= escaparHtml($rutaInicio) ?>">Volver al índice principal</a>
            <?php foreach ($enlacesExtra as $texto => $url): ?>
                &middot; <a href="<?= escaparHtml($url) ?>"><?= escaparHtml($texto) ?></a>
            <?php endforeach; ?>
        </p>
        <hr>
        <?php
    }
}
