<?php

require_once "Usuario.php";

class Pasajero extends Usuario
{
    private int $numAsiento;
    private Viaje $viajes;

    public function __construct(string $nombre, string $dni, int $edad, float $salario, string $contraseña, int $numAsiento, Viaje $viajes)
    {
        parent::__construct($nombre, $dni, $edad, $salario, $contraseña);
        $this->numAsiento = $numAsiento;
        $this->viajes = $viajes;
    }

    public function getNumAsiento(): int
    {
        return $this->numAsiento;
    }

    public function setNumAsiento(int $numAsiento): self
    {
        $this->numAsiento = $numAsiento;
        return $this;
    }

    public function getViajes(): Viaje
    {
        return $this->viajes;
    }

    public function setViajes(Viaje $viajes): self
    {
        $this->viajes = $viajes;
        return $this;
    }

    /**
     * Precio a pagar por el pasajero (del viaje asignado)
     * @return float
     */
    public function precioAPagar(): float
    {
        return $this->viajes->getPrecioBase();
    }

}