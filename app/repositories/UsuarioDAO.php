<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../core/CoreDB.php';

/**
 * DAO para la clase Usuario
 */
class UsuarioDAO
{
    /**
     * Crea un nuevo usuario en la base de datos
     * @param Usuario $usuario Usuario a crear
     * @return bool True si se creó correctamente
     */
    public static function create(Usuario $usuario): bool
    {
        $conn = CoreDB::getConecction();
        
        // Hasheamos la contraseña antes de guardar
        $passwordHash = password_hash($usuario->getPassword(), PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare(
            "INSERT INTO usuarios (nombre, dni, edad, salario, email, password) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $nombre = $usuario->getNombre();
        $dni = $usuario->getDni();
        $edad = $usuario->getEdad();
        $salario = $usuario->getSalario();
        $email = $usuario->getEmail();
        
        $stmt->bind_param("ssiiss", $nombre, $dni, $edad, $salario, $email, $passwordHash);
        $result = $stmt->execute();
        
        if ($result) {
            // Actualizamos el ID del usuario con el autogenerado
            $usuario->setId($conn->insert_id);
        }
        
        $stmt->close();
        $conn->close();
        
        return $result;
    }

    /**
     * Lee un usuario por su email
     * @param string $email Email del usuario
     * @return Usuario|null Usuario encontrado o null
     */
    public static function read(string $email): ?Usuario
    {
        $conn = CoreDB::getConecction();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $usuario = null;
        if ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['nombre'],
                $row['dni'],
                $row['edad'],
                $row['salario'],
                $row['email'],
                $row['password'],
            );
        }
        
        $stmt->close();
        $conn->close();
        
        return $usuario;
    }

    /**
     * Lee un usuario por su ID
     * @param int $id ID del usuario
     * @return Usuario|null Usuario encontrado o null
     */
    public static function readById(int $id): ?Usuario
    {
        $conn = CoreDB::getConecction();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $usuario = null;
        if ($row = $result->fetch_assoc()) {
            $usuario = new Usuario(
                $row['nombre'],
                $row['dni'],
                $row['edad'],
                $row['salario'],
                $row['email'],
                $row['password'],
            );
        }
        
        $stmt->close();
        $conn->close();
        
        return $usuario;
    }

    /**
     * Obtiene todos los usuarios
     * @return array Array de usuarios
     */
    public static function getAll(): array
    {
        $conn = CoreDB::getConecction();
        $result = $conn->query("SELECT * FROM usuarios");
        
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = new Usuario(
                $row['nombre'],
                $row['dni'],
                $row['edad'],
                $row['salario'],
                $row['email'],
                $row['password'],
            );
        }
        
        $conn->close();
        return $usuarios;
    }
}