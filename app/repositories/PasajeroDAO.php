<?php
require_once __DIR__ . '/../models/Pasajero.php';
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/UsuarioDAO.php';

/**
 * DAO para la clase Pasajero
 */
class PasajeroDAO
{
    /**
     * Crea un nuevo pasajero en la base de datos
     * @param Pasajero $pasajero Pasajero a crear
     * @return bool True si se creó correctamente
     */
    public static function create(Pasajero $pasajero): bool
    {
        $conn = CoreDB::getConecction();
        
        // Primero creamos el usuario
        $passwordHash = password_hash($pasajero->getPassword(), PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare(
            "INSERT INTO usuarios (nombre, dni, edad, salario, email, password) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $nombre = $pasajero->getNombre();
        $dni = $pasajero->getDni();
        $edad = $pasajero->getEdad();
        $salario = $pasajero->getSalario();
        $email = $pasajero->getEmail();
        
        $stmt->bind_param("ssiiss", $nombre, $dni, $edad, $salario, $email, $passwordHash);
        $result = $stmt->execute();
        
        if (!$result) {
            $stmt->close();
            $conn->close();
            return false;
        }
        
        $idUsuario = $conn->insert_id;
        $pasajero->setId($idUsuario);
        $stmt->close();
        
        // Ahora insertamos en la tabla pasajeros
        $stmt2 = $conn->prepare("INSERT INTO pasajeros (id_usuario, num_asiento) VALUES (?, ?)");
        $numAsiento = $pasajero->getNumAsiento();
        $stmt2->bind_param("ii", $idUsuario, $numAsiento);
        $result2 = $stmt2->execute();
        
        $stmt2->close();
        $conn->close();
        
        return $result2;
    }

    /**
     * Obtiene todos los pasajeros
     * @return array Array de pasajeros
     */
    public static function getAll(): array
    {
        $conn = CoreDB::getConecction();
        $query = "SELECT u.*, p.num_asiento 
                  FROM usuarios u 
                  INNER JOIN pasajeros p ON u.id = p.id_usuario";
        
        $result = $conn->query($query);
        
        $pasajeros = [];
        while ($row = $result->fetch_assoc()) {
            $pasajeros[] = new Pasajero(
                $row['nombre'],
                $row['dni'],
                $row['edad'],
                $row['salario'],
                $row['email'],
                $row['password'],
                $row['num_asiento'],
                $row['id']
            );
        }
        
        $conn->close();
        return $pasajeros;
    }

    /**
     * Elimina un pasajero por su ID
     * @param int $id ID del pasajero a eliminar
     * @return bool True si se eliminó correctamente
     */
    public static function delete(int $id): bool
    {
        $conn = CoreDB::getConecction();
        
        // Primero eliminamos de la tabla pasajeros
        $stmt = $conn->prepare("DELETE FROM pasajeros WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        
        // Luego eliminamos de usuarios (o se elimina automáticamente con ON DELETE CASCADE)
        $stmt2 = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $result2 = $stmt2->execute();
        $stmt2->close();
        
        $conn->close();
        return $result && $result2;
    }

    /**
     * Lee un pasajero por su ID
     * @param int $id ID del pasajero
     * @return Pasajero|null Pasajero encontrado o null
     */
    public static function readById(int $id): ?Pasajero
    {
        $conn = CoreDB::getConecction();
        $stmt = $conn->prepare(
            "SELECT u.*, p.num_asiento 
             FROM usuarios u 
             INNER JOIN pasajeros p ON u.id = p.id_usuario 
             WHERE u.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $pasajero = null;
        if ($row = $result->fetch_assoc()) {
            $pasajero = new Pasajero(
                $row['nombre'],
                $row['dni'],
                $row['edad'],
                $row['salario'],
                $row['email'],
                $row['password'],
                $row['num_asiento'],
                $row['id']
            );
        }
        
        $stmt->close();
        $conn->close();
        
        return $pasajero;
    }
}