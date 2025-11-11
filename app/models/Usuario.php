<?php

class Usuario
{
    protected string $nombre;
    protected string $dni;
    protected int $edad;
    protected float $salary;

    public function __construct(string $nombre, string $dni, int $edad, float $salary)
    {
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->edad = $edad;
        $this->salary = $salary;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function setDni(string $dni): self
    {
        $this->dni = $dni;
        return $this;
    }

    public function getEdad(): int
    {
        return $this->edad;
    }

    public function setEdad(int $edad): self
    {
        $this->edad = $edad;
        return $this;
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;
        return $this;
    }
}