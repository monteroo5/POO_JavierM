<?php
session_start();

// Barrera de seguridad
if (!isset($_COOKIE["stay-connected"]) && !isset($_SESSION["origin"])) {
    header("Location: login.php");
    exit();
}

require_once __DIR__ . '/../app/repositories/PasajeroDAO.php';
$listaPasajeros = PasajeroDAO::getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pasajeros</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include __DIR__ . "/../resources/views/layouts/header.php"; ?>
    <main>
        <h2>Listado de Pasajeros</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Asiento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaPasajeros as $p): ?>
                <tr>
                    <td><?= $p->getNombre() ?></td>
                    <td><?= $p->getDni() ?></td>
                    <td><?= $p->getEmail() ?></td>
                    <td><?= $p->getNumAsiento() ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <?php include __DIR__ . "/../resources/views/layouts/footer.php"; ?>
</body>
</html>