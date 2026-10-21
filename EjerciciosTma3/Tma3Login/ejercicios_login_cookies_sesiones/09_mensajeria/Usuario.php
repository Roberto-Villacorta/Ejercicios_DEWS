<?php
/**
 * Clase Usuario - Representa un usuario registrado en el sistema de mensajería.
 */
class Usuario
{
    public string $nombre;
    public string $passwordHash;
    public string $fechaRegistro;

    public function __construct(string $nombre, string $passwordHash, string $fechaRegistro = '')
    {
        $this->nombre = $nombre;
        $this->passwordHash = $passwordHash;
        $this->fechaRegistro = $fechaRegistro ?: date('Y-m-d H:i:s');
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function verificarPassword(string $password): bool
    {
        return password_verify($password, $this->passwordHash);
    }

    public function __toString(): string
    {
        return $this->nombre;
    }
}
