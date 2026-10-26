<?php
/**
 * Clase Mensaje - Representa un mensaje privado enviado entre usuarios.
 */
class Mensaje
{
    public string $de;
    public string $para;
    public string $texto;
    public string $fecha;

    public function __construct(string $de, string $para, string $texto, string $fecha = '')
    {
        $this->de = $de;
        $this->para = $para;
        $this->texto = $texto;
        $this->fecha = $fecha ?: date('Y-m-d H:i:s');
    }

    public function esPara(string $usuario): bool
    {
        return $this->para === $usuario;
    }

    public function esDe(string $usuario): bool
    {
        return $this->de === $usuario;
    }

    public function obtenerFechaFormateada(): string
    {
        return date('d/m/Y H:i', strtotime($this->fecha));
    }
}
