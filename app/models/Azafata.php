<?php
require_once "Usuario.php";

class Azafata extends Usuario
{
    private array $idiomas;

    public function __construct(string $nombre, string $dni, int $edad, float $salario, string $contraseña, array $idiomas)
    {
        parent::__construct($nombre, $dni, $edad, $salario, $contraseña);
        $this->idiomas = $idiomas;
    }

    public function getIdiomas(): array
    {
        return $this->idiomas;
    }

    public function setIdiomas(array $idiomas): self
    {
        $this->idiomas = $idiomas;
        return $this;
    }
}