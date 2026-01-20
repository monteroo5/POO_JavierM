<?php
session_start();
// Si ya hay sesión o cookie, redirigir a index.php
if (isset($_SESSION['usuario']) || isset($_COOKIE['usuario_web'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_login'])) {
    $_SESSION['usuario'] = $_POST['dni']; 
    if (isset($_POST['remember'])) {
        setcookie('usuario_web', $_POST['dni'], time() + (60*60*24*30), "/"); // 30 días
    }
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
    <?php include '../resources/views/layouts/header.php'; ?>
    <h2>Inicio de Sesión</h2>
    <?php include '../resources/views/components/form_login.php'; ?>
    <?php include '../resources/views/layouts/footer.php'; ?>
</body>
</html>