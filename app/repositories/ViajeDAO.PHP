<?php
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/../models/Viaje.php';

class ViajeDAO
{
    /**
     * Create / insert
     * Guarda un viaje asociado a un pasajero específico
     * @param Viaje $viaje
     * @param int $idPasajero
     * @return bool
     */
    public static function create($viaje, $idPasajero): bool
    {
        $conn = CoreDB::getConecction();
        $sql = "INSERT INTO viajes (id_pasajero, destino, precio_base) VALUES (?, ?, ?)";
        $ps = $conn->prepare($sql);
        
        $destino = $viaje->getDestino();
        $precio = $viaje->getPrecioBase();
        
        $ps->bind_param("isd", $idPasajero, $destino, $precio);
        $ret = $ps->execute();
        
        $ps->close();
        $conn->close();
        return $ret;
    }

    /**
     * Read / select
     * Lee todos los viajes asociados a un ID de pasajero
     * @param int $idPasajero
     * @return array Lista de objetos Viaje
     */
    public static function readByPasajeroId($idPasajero): array
    {
        $conn = CoreDB::getConecction();
        $sql = "SELECT * FROM viajes WHERE id_pasajero = ?";
        $ps = $conn->prepare($sql);
        $ps->bind_param("i", $idPasajero);
        $ps->execute();
        $result = $ps->get_result();
        
        $viajes = [];
        while ($row = $result->fetch_assoc()) {
            $viajes[] = new Viaje($row["destino"], $row["precio_base"], []);
        }
        
        $ps->close();
        $conn->close();
        return $viajes;
    }
}