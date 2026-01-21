<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';
require_once __DIR__ . '/../app/models/Pasajero.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_signup'])) {
    $nombre = trim($_POST['nombre']);
    $dni = strtoupper(trim($_POST['dni']));
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    // Validaciones
    if (empty($nombre) || empty($dni) || empty($email) || empty($password)) {
        $error = "Faltan campos por rellenar.";
    } elseif (strlen($dni) != 9) {
        $error = "El DNI debe tener 9 caracteres.";
    } elseif (strpos($email, '@') === false) { // strpos busca la posición de la '@' en el email. Si no la encuentra, devuelve false.
        $error = "El email no tiene un formato válido.";
    } else {
        $nuevo = new Pasajero($nombre, $dni, 18, 0, $email, $password, 0);
        if (UsuarioDAO::create($nuevo)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Error al registrar.";
        }
    }
}
?>