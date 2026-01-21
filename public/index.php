<?php
session_start();

// Protección: Verificar sesión o cookie
if (!isset($_SESSION['usuario']) && !isset($_COOKIE['usuario_web'])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../app/repositories/PasajeroDAO.php';
require_once __DIR__ . '/../app/models/Pasajero.php';

$mensaje = null;
$tipoMensaje = null;

// Recuperar mensaje de éxito tras redirección
if (isset($_SESSION['mensaje_exito'])) {
    $mensaje = $_SESSION['mensaje_exito'];
    $tipoMensaje = "success";
    unset($_SESSION['mensaje_exito']);
}

// Procesar formulario de ELIMINACIÓN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_delete_pasajero'])) {
    if (!empty($_POST['pasajero_id'])) {
        if (PasajeroDAO::delete((int)$_POST['pasajero_id'])) {
            $_SESSION['mensaje_exito'] = "Pasajero eliminado.";
            header("Location: index.php");
            exit();
        }
    }
}

$pasajeros = PasajeroDAO::getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']['nombre']; ?></h2>
    <a href="closesession.php">Cerrar Sesión</a>

    <?php if ($mensaje): ?>
        <p style="color: green;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>DNI</th><th>Email</th><th>Asiento</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pasajeros as $p): ?>
                <tr>
                    <td><?php echo $p->getId(); ?></td>
                    <td><?php echo $p->getNombre(); ?></td>
                    <td><?php echo $p->getDni(); ?></td>
                    <td><?php echo $p->getEmail(); ?></td>
                    <td><?php echo $p->getNumAsiento(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php include __DIR__ . '/../resources/views/components/create-pasajero.php'; ?>
    <?php include __DIR__ . '/../resources/views/components/delete-pasajero.php'; ?>
</body>
</html>