<?php

require_once "Pasajero.php";

class Viaje
{
    private string $destino;
    private float $precioBase;
    private array $pasajeros;

    public function __construct(string $destino, float $precioBase, array $pasajeros)
    {
        $this->destino = $destino;
        $this->precioBase = $precioBase;
        $this->pasajeros = $pasajeros;
    }

    public function getDestino(): string
    {
        return $this->destino;
    }

    public function setDestino(string $destino): self
    {
        $this->destino = $destino;
        return $this;
    }

    public function getPrecioBase(): float
    {
        return $this->precioBase;
    }

    public function setPrecioBase(float $precioBase): self
    {
        $this->precioBase = $precioBase;
        return $this;
    }

    public function getPasajeros(): array
    {
        return $this->pasajeros;
    }

    public function setPasajeros(array $pasajeros): self
    {
        $this->pasajeros = $pasajeros;
        return $this;
    }

    /**
     * Añade un pasajero
     * @param Pasajero $p
     * @return void
     */
    public function addPasajero(Pasajero $p): void
    {
        $this->pasajeros[] = $p;
    }

    /**
     * Calcula el precio total del viaje según cantidad de pasajeros
     * @return float|int
     */
    public function calcularPrecioTotal(): float
    {
        return $this->precioBase * count($this->pasajeros);
    }
}