<?php

require_once "Usuario.php";

class Piloto extends Usuario
{
    private int $horasVuelo;

    public function __construct(string $nombre, string $dni, int $edad, float $salary, int $horasVuelo)
    {
        parent::__construct($nombre, $dni, $edad, $salary);
        $this->horasVuelo = $horasVuelo;
    }

    public function getHorasVuelo(): int
    {
        return $this->horasVuelo;
    }

    public function setHorasVuelo(int $horasVuelo): self
    {
        $this->horasVuelo = $horasVuelo;
        return $this;
    }
}