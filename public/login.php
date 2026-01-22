<?php
session_start();
require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';

$error_msg = "";

// Auto-login si existe cookie
if (isset($_COOKIE["stay-connected"])) {
    $email = $_COOKIE["stay-connected"];
    $usuario = UsuarioDAO::read($email);
    
    if ($usuario) {
        $_SESSION["email"] = $email;
        $_SESSION["nombre"] = $usuario->getNombre();
        $_SESSION["origin"] = "cookie";
        header("Location: index.php");
        exit();
    } else {
        // Cookie inválida, la borramos
        setcookie("stay-connected", "", time() - 3600, "/");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? "");
    $pass = $_POST["password"] ?? "";

    if (empty($email) || empty($pass)) {
        $error_msg = "Email y contraseña son obligatorios.";
    } else {
        $usuario = UsuarioDAO::read($email);

        if ($usuario && password_verify($pass, $usuario->getPassword())) {
            // Login exitoso
            $_SESSION["email"] = $email;
            $_SESSION["nombre"] = $usuario->getNombre();
            $_SESSION["origin"] = "login";
            
            // Si marcó "Permanecer conectado", crear cookie
            if (isset($_POST["stay-connected"])) {
                // Cookie de 1 semana (604800 segundos)
                setcookie("stay-connected", $email, time() + 604800, "/");
            }
            
            header("Location: index.php");
            exit();
        } else {
            $error_msg = "Credenciales incorrectas.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Viajes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <h2>Iniciar Sesión</h2>
        <?php if ($error_msg): ?>
            <p class="error"><?= htmlspecialchars($error_msg) ?></p>
        <?php endif; ?>
        <?php include __DIR__ . "/../resources/views/components/form-login.php"; ?>
        <p>¿No tienes cuenta? <a href="signup.php">Regístrate aquí</a></p>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>