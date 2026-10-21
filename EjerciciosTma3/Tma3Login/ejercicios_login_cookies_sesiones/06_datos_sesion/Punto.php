<?php
/**
 * Clase Punto - Representación geométrica bidimensional en un plano cartesiano.
 * 
 * Diseñada para demostrar la persistencia y serialización de objetos en la sesión de PHP ($_SESSION).
 * Almacena coordenadas (X, Y) y proporciona métodos matemáticos y de representación textual.
 */
class Punto
{
    /** Coordenada en el eje horizontal (abscisas). */
    public float $coordenadaX;

    /** Coordenada en el eje vertical (ordenadas). */
    public float $coordenadaY;

    /**
     * Constructor del Punto.
     * 
     * @param float $coordenadaX Valor de la coordenada X (por defecto 0.0)
     * @param float $coordenadaY Valor de la coordenada Y (por defecto 0.0)
     */
    public function __construct(float $coordenadaX = 0.0, float $coordenadaY = 0.0)
    {
        $this->coordenadaX = $coordenadaX;
        $this->coordenadaY = $coordenadaY;
    }

    /**
     * Obtiene la coordenada X.
     */
    public function getX(): float
    {
        return $this->coordenadaX;
    }

    /**
     * Asigna un nuevo valor a la coordenada X.
     */
    public function setX(float $x): void
    {
        $this->coordenadaX = $x;
    }

    /**
     * Obtiene la coordenada Y.
     */
    public function getY(): float
    {
        return $this->coordenadaY;
    }

    /**
     * Asigna un nuevo valor a la coordenada Y.
     */
    public function setY(float $y): void
    {
        $this->coordenadaY = $y;
    }

    /**
     * Desplaza el punto sumando incrementos a sus coordenadas actuales.
     * 
     * @param float $deltaX Desplazamiento horizontal.
     * @param float $deltaY Desplazamiento vertical.
     */
    public function desplazar(float $deltaX, float $deltaY): void
    {
        $this->coordenadaX += $deltaX;
        $this->coordenadaY += $deltaY;
    }

    /**
     * Calcula la distancia euclidiana hacia otro punto del plano.
     */
    public function distanciaHasta(Punto $otroPunto): float
    {
        $dx = $this->coordenadaX - $otroPunto->coordenadaX;
        $dy = $this->coordenadaY - $otroPunto->coordenadaY;
        return sqrt($dx * $dx + $dy * $dy);
    }

    /**
     * Determina en qué cuadrante del plano cartesiano se ubica el punto.
     */
    public function obtenerCuadrante(): string
    {
        if ($this->coordenadaX > 0 && $this->coordenadaY > 0) return 'Primer Cuadrante (I)';
        if ($this->coordenadaX < 0 && $this->coordenadaY > 0) return 'Segundo Cuadrante (II)';
        if ($this->coordenadaX < 0 && $this->coordenadaY < 0) return 'Tercer Cuadrante (III)';
        if ($this->coordenadaX > 0 && $this->coordenadaY < 0) return 'Cuarto Cuadrante (IV)';
        if ($this->coordenadaX == 0 && $this->coordenadaY == 0) return 'Origen de coordenadas (0,0)';
        return 'Sobre uno de los ejes';
    }

    /**
     * Representación textual descriptiva y legible del objeto.
     */
    public function describir(): string
    {
        return sprintf(
            'Punto en coordenadas (X: %.2f, Y: %.2f) ubicado en el %s',
            $this->coordenadaX,
            $this->coordenadaY,
            $this->obtenerCuadrante()
        );
    }

    /**
     * Convierte el objeto a string automáticamente cuando se imprime en HTML o cadenas.
     */
    public function __toString(): string
    {
        return "Punto({$this->coordenadaX}, {$this->coordenadaY})";
    }
}
