<?php
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Pasajero.php';

class UsuarioDAO
{
    /**
     * Create / insert.
     * @param Usuario $usuario
     * @return bool
     */
    public static function create($usuario) : bool {
        $conn = CoreDB::getConecction();
        $sql = "INSERT into usuarios (nombre, dni, edad, salario, email, password)
                VALUES (?, ?, ?, ?, ?, ?)";

        $ps = $conn->prepare($sql);
        
        $nombre = $usuario->getNombre();
        $dni = $usuario->getDni();
        $edad = $usuario->getEdad();
        $salario = $usuario->getSalario();
        $email = $usuario->getEmail();
        $passwordHasheada = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
        
        $ps->bind_param("ssidss", $nombre, $dni, $edad, $salario, $email, $passwordHasheada);
        
        try {
            $ret = $ps->execute();
            if ($ret) {
                $usuario->setId($conn->insert_id);
            }
            $ps->close();
            return $ret;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    /**
     * Read / select
     * @param string $email
     * @return Usuario|null
     */
    public static function read(string $email) : ?Usuario {
        $conn = CoreDB::getConecction();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $email);
        $ps->execute();
        $result = $ps->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Creamos el objeto Pasajero con todos sus campos
            $usuario = new Pasajero(
                $row["nombre"], 
                $row["dni"], 
                (int)$row["edad"], 
                (float)$row["salario"], 
                $row["email"], 
                $row["password"],
                0, // numAsiento por defecto
                [] // array de viajes vacío
            );
            $usuario->setId((int)$row["id"]);
            return $usuario;
        }

        return null;
    }
}