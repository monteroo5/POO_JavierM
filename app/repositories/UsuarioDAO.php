<?php
require_once __DIR__ . '/../core/CoreDB.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Pasajero.php';

class UsuarioDAO
{
    /**
     * Create / insert.
     * Guarda en la bd un usuario
     * @param Usuario $usuario
     * @return bool true si lo ha insertado, false si no lo ha insertado.
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
        } catch (mysqli_sql_exception $e) {
            $conn->close();
            return false;
        }

        $conn->close();
        return $ret;
    }

    /**
     * Read / select
     * Lee un usuario de la bd por su email
     * @param string $email
     * @return Usuario|null Usuario leído de la bd o null si no existe el email.
     */
    public static function read($email) : ?Usuario {
        $conn = CoreDB::getConecction();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $ps = $conn->prepare($sql);
        $ps->bind_param("s", $email);
        $ps->execute();
        $result = $ps->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $usuario = new Pasajero(
                $row["nombre"], 
                $row["dni"], 
                $row["edad"], 
                $row["salario"], 
                $row["email"], 
                $row["password"],
                0
            );
            $usuario->setId($row["id"]);
        } else {
            $usuario = null;
        }

        $ps->close();
        $conn->close();
        return $usuario;
    }
}