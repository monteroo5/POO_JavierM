<?php
session_start();

// Barrera de seguridad: verificar que el usuario está logueado
if (!isset($_COOKIE["stay-connected"]) && !isset($_SESSION["origin"])) {
    header("Location: login.php");
    exit();
}

// Si llegó por cookie pero no tiene sesión activa, crear sesión
if (isset($_COOKIE["stay-connected"]) && !isset($_SESSION["email"])) {
    require_once __DIR__ . '/../app/repositories/UsuarioDAO.php';
    $email = $_COOKIE["stay-connected"];
    $usuario = UsuarioDAO::read($email);
    
    if ($usuario) {
        $_SESSION["email"] = $email;
        $_SESSION["nombre"] = $usuario->getNombre();
        $_SESSION["origin"] = "cookie";
    } else {
        setcookie("stay-connected", "", time() - 3600, "/");
        header("Location: login.php");
        exit();
    }
}

require_once __DIR__ . '/../app/repositories/PasajeroDAO.php';
require_once __DIR__ . '/../app/models/Pasajero.php';

$mensaje = "";
$mensaje_error = "";

// Procesar creación de pasajero
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_create_pasajero'])) {
    $nombre = trim($_POST['nombre'] ?? "");
    $dni = strtoupper(trim($_POST['dni'] ?? ""));
    $email = strtolower(trim($_POST['email'] ?? ""));
    $asiento = (int)($_POST['num_asiento'] ?? 0);

    if (empty($nombre) || empty($dni) || empty($email)) {
        $mensaje_error = "Rellena todos los campos.";
    } elseif (strlen($dni) != 9) {
        $mensaje_error = "DNI incorrecto (debe tener 9 caracteres).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje_error = "Email no válido.";
    } elseif ($asiento <= 0) {
        $mensaje_error = "El número de asiento debe ser mayor a 0.";
    } else {
        $p = new Pasajero($nombre, $dni, 18, 0, $email, "123456", $asiento);
        if (PasajeroDAO::create($p)) {
            $mensaje = "Pasajero creado exitosamente.";
            // Refrescar para evitar reenvío de formulario
            header("Location: index.php?success=1");
            exit();
        } else {
            $mensaje_error = "Error al crear el pasajero.";
        }
    }
}

// Procesar eliminación de pasajero
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_delete_pasajero'])) {
    $pasajero_id = (int)($_POST['pasajero_id'] ?? 0);
    
    if ($pasajero_id > 0) {
        if (PasajeroDAO::delete($pasajero_id)) {
            $mensaje = "Pasajero eliminado exitosamente.";
            header("Location: index.php?deleted=1");
            exit();
        } else {
            $mensaje_error = "Error al eliminar el pasajero.";
        }
    } else {
        $mensaje_error = "Selecciona un pasajero para eliminar.";
    }
}

// Mensajes de redirección
if (isset($_GET['success'])) {
    $mensaje = "Pasajero creado exitosamente.";
}
if (isset($_GET['deleted'])) {
    $mensaje = "Pasajero eliminado exitosamente.";
}

// Obtener todos los pasajeros
$listaPasajeros = PasajeroDAO::getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestión de Pasajeros</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <h2>Bienvenido/a, <?= htmlspecialchars($_SESSION["nombre"] ?? "Usuario") ?>!</h2>
        
        <?php if ($mensaje): ?>
            <p class="success"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        
        <?php if ($mensaje_error): ?>
            <p class="error"><?= htmlspecialchars($mensaje_error) ?></p>
        <?php endif; ?>

        <div class="forms-container">
            <div class="form-section">
                <?php include __DIR__ . "/../resources/views/components/create-pasajero.php"; ?>
            </div>
            
            <div class="form-section">
                <?php include __DIR__ . "/../resources/views/components/delete-pasajero.php"; ?>
            </div>
        </div>

        <h3>Listado de Pasajeros</h3>
        <?php if (empty($listaPasajeros)): ?>
            <p>No hay pasajeros registrados.</p>
        <?php else: ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Asiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaPasajeros as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p->getId()) ?></td>
                        <td><?= htmlspecialchars($p->getNombre()) ?></td>
                        <td><?= htmlspecialchars($p->getDni()) ?></td>
                        <td><?= htmlspecialchars($p->getEmail()) ?></td>
                        <td><?= htmlspecialchars($p->getNumAsiento()) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>