<?php
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/UsuarioDAO.php';
require_once __DIR__ . '/../models/Pasajero.php';

class PasajeroDAO
{
    /**
     * @param Pasajero $pasajero
     * @return bool
     */
    public static function create($pasajero): bool
    {
        if (UsuarioDAO::create($pasajero)) {
            $conn = CoreDB::getConecction();
            $sql = "INSERT INTO pasajeros (id_usuario, num_asiento) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            
            $idUsuario = $pasajero->getId();
            $numAsiento = $pasajero->getNumAsiento();
            
            $stmt->bind_param("ii", $idUsuario, $numAsiento);
            $resultado = $stmt->execute();
            $stmt->close();
            return $resultado;
        }
        return false;
    }

    /**
     * @return array
     */
    public static function getAll(): array
    {
        $conn = CoreDB::getConecction();
        $sql = "SELECT u.*, p.num_asiento 
                FROM usuarios u 
                INNER JOIN pasajeros p ON u.id = p.id_usuario";
        
        $result = $conn->query($sql);
        $pasajeros = [];

        while ($row = $result->fetch_assoc()) {
            $pasajero = new Pasajero(
                $row["nombre"],
                $row["dni"],
                (int)$row["edad"],
                (float)$row["salario"],
                $row["email"],
                $row["password"],
                (int)$row["num_asiento"],
                [] // viajes vacíos por defecto
            );
            $pasajero->setId((int)$row["id"]); 
            $pasajeros[] = $pasajero;
        }

        return $pasajeros;
    }

    /**
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $conn = CoreDB::getConecction();
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
}