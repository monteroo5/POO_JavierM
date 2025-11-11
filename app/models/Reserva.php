<?php
require_once "Pasajero.php";
require_once "Viaje.php";

class Reserva {
    private int $id;
    private Pasajero $pasajero;
    private Viaje $viaje;
    private string $fecha;

    public function __construct(int $id, Pasajero $pasajero, Viaje $viaje, string $fecha) {
        $this->id = $id;
        $this->pasajero = $pasajero;
        $this->viaje = $viaje;
        $this->fecha = $fecha;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }

    public function getPasajero(): Pasajero {
        return $this->pasajero;
    }

    public function getViaje(): Viaje {
        return $this->viaje;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    // Setters
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setPasajero(Pasajero $pasajero): void {
        $this->pasajero = $pasajero;
    }

    public function setViaje(Viaje $viaje): void {
        $this->viaje = $viaje;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }
}