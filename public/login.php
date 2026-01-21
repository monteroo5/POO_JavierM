<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';
require_once __DIR__ . '/../app/models/Pasajero.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $usuario = UsuarioDAO::read($email);

    // Comprobamos si existe y si la contraseña es correcta
    if ($usuario && password_verify($password, $usuario->getPassword())) {
        $_SESSION['usuario'] = [
            'id' => $usuario->getId(),
            'nombre' => $usuario->getNombre(),
            'email' => $usuario->getEmail()
        ];
        header("Location: index.php");
        exit();
    } else {
        $error = "Email o contraseña incorrectos.";
    }
}
?>