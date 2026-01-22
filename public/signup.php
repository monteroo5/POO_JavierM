<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';
require_once __DIR__ . '/../app/models/Usuario.php';

$error_msg = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"] ?? "");
    $dni = strtoupper(trim($_POST["dni"] ?? ""));
    $edad = (int)($_POST["edad"] ?? 18);
    $salario = (float)($_POST["salario"] ?? 0);
    $email = strtolower(trim($_POST["email"] ?? ""));
    $password = $_POST["password"] ?? "";
    $password_confirm = $_POST["password_confirm"] ?? "";
    
    // Validaciones
    if (empty($nombre) || empty($dni) || empty($email) || empty($password)) {
        $error_msg = "Todos los campos son obligatorios.";
    } elseif (strlen($dni) != 9) {
        $error_msg = "El DNI debe tener 9 caracteres.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Email no válido.";
    } elseif ($password !== $password_confirm) {
        $error_msg = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error_msg = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Verificar si el email ya existe
        if (UsuarioDAO::read($email) !== null) {
            $error_msg = "El email ya está registrado.";
        } else {
            $u = new Usuario($nombre, $dni, $edad, $salario, $email, $password);
            
            if (UsuarioDAO::create($u)) {
                $_SESSION["email"] = $email;
                $_SESSION["nombre"] = $nombre;
                $_SESSION["origin"] = "signup";
                header("Location: index.php");
                exit();
            } else {
                $error_msg = "Error al crear el usuario. Inténtalo de nuevo.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Viajes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <h2>Crear cuenta nueva</h2>
        <?php if ($error_msg): ?>
            <p class="error"><?= htmlspecialchars($error_msg) ?></p>
        <?php endif; ?>
        <?php if ($success_msg): ?>
            <p class="success"><?= htmlspecialchars($success_msg) ?></p>
        <?php endif; ?>
        <?php include __DIR__ . "/../resources/views/components/form-signup.php"; ?>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>