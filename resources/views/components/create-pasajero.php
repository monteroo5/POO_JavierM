<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn_create_pasajero'])) {
    $nombre = trim($_POST['nombre']);
    $dni = strtoupper(trim($_POST['dni']));
    $email = strtolower(trim($_POST['email']));
    $asiento = (int)$_POST['num_asiento'];

    if (empty($nombre) || empty($dni) || empty($email)) {
        $mensaje = "Rellena todos los campos.";
    } elseif (strlen($dni) != 9) {
        $mensaje = "DNI incorrecto.";
    } elseif (strpos($email, '@') === false) { // strpos busca la @, si no la halla devuelve false
        $mensaje = "Email no válido.";
    } else {
        $p = new Pasajero($nombre, $dni, 18, 0, $email, "123456", $asiento);
        if (PasajeroDAO::create($p)) {
            $_SESSION['mensaje_exito'] = "Pasajero creado.";
            header("Location: index.php");
            exit();
        }
    }
}
?>
<form method="POST">
    <h3>Nuevo Pasajero</h3>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="dni" placeholder="DNI" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="number" name="num_asiento" placeholder="Nº Asiento" required>
    <button type="submit" name="btn_create_pasajero">Guardar</button>
</form>