<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';
require_once __DIR__ . '/../app/models/Usuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["fullname"] ?? "";
    $email = $_POST["signup-email"] ?? "";
    $pass = $_POST["signup-password"] ?? "";
    
    // Tu constructor requiere: nombre, dni, edad, salario, email, password
    // Ajustamos con valores por defecto para evitar el error de "Missing arguments"
    $u = new Usuario(
        $name, 
        "00000000X", // DNI temporal
        18,          // Edad por defecto
        0.0,         // Salario por defecto
        $email, 
        $pass
    );

    if (UsuarioDAO::create($u)) {
        $_SESSION["email"] = $email;
        $_SESSION["origin"] = "signup";
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Viajes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <?php include __DIR__ . "/../resources/views/components/signup.php"; ?>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>