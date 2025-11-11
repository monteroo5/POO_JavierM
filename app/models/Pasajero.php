<?php

require_once "Usuario.php";

class Pasajero extends Usuario
{
    private int $numAsiento;

    public function __construct(string $nombre, string $dni, int $edad, float $salary, int $numAsiento)
    {
        parent::__construct($nombre, $dni, $edad, $salary);
        $this->numAsiento = $numAsiento;
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
}