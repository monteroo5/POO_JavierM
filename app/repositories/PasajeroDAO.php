<?php
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/UsuarioDAO.php';
require_once __DIR__ . '/ViajeDAO.php';
require_once __DIR__ . '/../models/Pasajero.php';

class PasajeroDAO
{
    public static function create($pasajero): bool
    /**
     * Create / insert.
     * Guarda en la bd un pasajero y todos sus viajes asociados
     * @param Pasajero $pasajero
     * @return bool true si lo ha insertado, false si no.
     */
    {
        if (UsuarioDAO::create($pasajero)) {
            $conn = CoreDB::getConecction();
            $sql = "INSERT into pasajeros (id_usuario, num_asiento) VALUES (?, ?)";
            $ps = $conn->prepare($sql);

            $idUsuario = $pasajero->getId();
            $numAsiento = $pasajero->getNumAsiento();
            $ps->bind_param("ii", $idUsuario, $numAsiento);

            try {
                $ret = $ps->execute();
                if ($ret) {
                    $idPasajeroReal = $conn->insert_id; 
                    foreach ($pasajero->getViajes() as $viaje) {
                        ViajeDAO::create($viaje, $idPasajeroReal);
                    }
                }
            } catch (mysqli_sql_exception $e) {
                $conn->close();
                return false;
            }

            $ps->close();
            $conn->close();
            return $ret;
        }
        return false;
    }

    /**
     * Read / select
     * Lee un pasajero de la bd con todos sus viajes asociados
     * @param int $id El ID del usuario
     * @return Pasajero|null
     */
    public static function read($id): ?Pasajero
    {
        $conn = CoreDB::getConecction();
        $sql = "SELECT u.*, p.id as id_p, p.num_asiento 
                FROM usuarios u 
                INNER JOIN pasajeros p ON u.id = p.id_usuario 
                WHERE u.id = ?";

        $ps = $conn->prepare($sql);
        $ps->bind_param("i", $id);
        $ps->execute();
        $result = $ps->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pasajero = new Pasajero(
                $row["nombre"],
                $row["dni"],
                $row["edad"],
                $row["salario"],
                $row["email"],
                $row["password"],
                $row["num_asiento"]
            );
            $pasajero->setId($row["id"]);
            $pasajero->setViajes(ViajeDAO::readByPasajeroId($row["id_p"]));
        } else {
            $pasajero = null;
        }

        $ps->close();
        $conn->close();
        return $pasajero;
    }
}