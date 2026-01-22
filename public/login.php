<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';

$error_msg = "";

// 1. Autologin del profesor
if (isset($_COOKIE["stay-connected"])) {
    $_SESSION["email"] = $_COOKIE["stay-connected"];
    $_SESSION["origin"] = "login";
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $pass = $_POST["password"] ?? "";

    // Buscamos el usuario por email
    $usuario = UsuarioDAO::read($email);

    // Verificamos contraseña con password_verify (tu DAO ya la hashea al crear)
    if ($usuario && password_verify($pass, $usuario->getPassword())) {
        if (isset($_POST["stay-connected"])) {
            setcookie("stay-connected", $email, time() + 3600, "/");
        }
        $_SESSION["email"] = $email;
        $_SESSION["origin"] = "login"; 
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Viajes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <?php if ($error_msg) echo "<p class='error'>$error_msg</p>"; ?>
        <?php include __DIR__ . "/../resources/views/components/form-login.php";; ?>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>