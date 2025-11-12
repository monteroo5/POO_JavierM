<?php

abstract class Usuario
{
    protected string $nombre;
    protected string $dni;
    protected int $edad;
    protected float $salario;
    protected string $contraseña;

    public function __construct(string $nombre, string $dni, int $edad, float $salario, string $contraseña)
    {
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->edad = $edad;
        $this->salario = $salario;
        $this->contraseña = $contraseña;
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
        return $this->salario;
    }

    public function setSalary(float $salary): self
    {
        $this->salario = $salary;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->contraseña;
    }

    public function setPassword(string $password): self
    {
        $this->contraseña = $password;
        return $this;
    }

    /**
     * Introducimos nuestra edad actual y la función nos devuelve
     * los años que nos faltana para jubilarnos.
     * @param int $edadActual
     * @return int
     */
    public static function añosParaJubilarse(int $edadActual): int
    {
        $edadJubilacion = 65;
        if ($edadActual >= $edadJubilacion) {
            return 0;
        }
        return $edadJubilacion - $edadActual;
    }

    /**
     * Calcula el bonus salarial del usuario según la edad de este.
     * @return float|int
     */
    public function calcularBonus(): float
    {
        return $this->salario + ($this->edad * 5);
    }
}