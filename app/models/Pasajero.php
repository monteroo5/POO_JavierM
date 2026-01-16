<?php
require_once __DIR__ . '/Usuario.php';

class Pasajero extends Usuario
{
    private int $numAsiento;
    private array $viajes; 

    public function __construct(
        string $nombre, 
        string $dni, 
        int $edad, 
        float $salario, 
        string $email,
        string $password, 
        int $numAsiento, 
        array $viajes = [] 
    ) {
        parent::__construct($nombre, $dni, $edad, $salario, $email, $password);
        
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

    public function getViajes(): array
    {
        return $this->viajes;
    }

    public function setViajes(array $viajes): self
    {
        $this->viajes = $viajes;
        return $this;
    }

    /**
     * Añade un viaje a la colección del pasajero
     * @param Viaje $viaje
     */
    public function añadirViaje(Viaje $viaje): void
    {
        $this->viajes[] = $viaje;
    }

    /**
     * Calcula el precio total de todos los viajes asignados
     * @return float
     */
    public function precioAPagar(): float
    {
        $total = 0.0;
        foreach ($this->viajes as $viaje) {
            $total += $viaje->getPrecioBase();
        }
        return $total;
    }

    public function __toString(): string
    {
        return "Pasajero: {$this->nombre} | Asiento: {$this->numAsiento} | Total Viajes: " . count($this->viajes);
    }
}