# Ejercicios de cookies, sesiones y login

Código de apoyo para los ejercicios 1–7 y 9. Los ficheros PHP están separados por ejercicio,
con sangría y saltos de línea para facilitar su lectura. Los nombres de variables y funciones
propias están en castellano.

## Requisitos

- PHP 8.1 o superior.
- Un navegador web.

## Cómo ejecutar

1. Descomprime el ZIP.
2. Abre una terminal en la carpeta del proyecto.
3. Ejecuta `php -S localhost:8000`.
4. Abre <http://localhost:8000/>.

## Ejercicios incluidos

1. Identificador de visitante mediante cookie.
2. Contador de visitas con cookie.
3. Ámbito y rutas de cookies.
4. Login de ejemplo y preferencias recordadas mediante cookie.
5. Contador de visitas con sesión.
6. Guardar y recuperar varios tipos de datos en una sesión, incluido un objeto `Punto`.
7. Formulario de registro por pasos con datos conservados en sesión.
9. Mensajería de demostración con registro, login, listado, lectura y envío.

## Credenciales del ejercicio 4

- `ana` / `clave123`
- `pepe` / `secreto`

El ejercicio 9 mantiene usuarios y mensajes en la sesión de PHP para que se pueda practicar sin
configurar una base de datos. Por tanto, los datos son temporales y no constituyen un sistema de
mensajería de producción. El login del ejercicio 4 también es didáctico y usa credenciales de
prueba escritas en el código.
