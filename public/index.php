<?php
require_once "../app/models/Usuario.php";
require_once "../app/models/Pasajero.php";
require_once "../app/models/Piloto.php";
require_once "../app/models/Azafata.php";
require_once "../app/models/Viaje.php";
require_once "../app/models/Reserva.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Demo Sistema de Viajes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Demo Sistema de Viajes</h1>

    <?php
    // Azafata
    $azafata1 = new Azafata("Laura", "12345678A", 28, 1500, "pass123", ["Inglés", "Francés"]);
    $azafata1->addIdioma("Alemán");

    echo "<h2>Azafata</h2>";
    echo "<p>Nombre: ".$azafata1->getNombre()."</p>";
    echo "<p>Idiomas: ".implode(", ", $azafata1->getIdiomas())."</p>";
    echo "<p>Bonus según idiomas: ".$azafata1->calcularBonusIdiomas()."€</p>";

    // Piloto
    $piloto1 = new Piloto("Carlos", "87654321B", 40, 2500, "secret", 120);

    echo "<h2>Piloto</h2>";
    echo "<p>Nombre: ".$piloto1->getNombre()."</p>";
    echo "<p>Horas de vuelo: ".$piloto1->getHorasVuelo()."</p>";
    echo "<p>Bonus: ".$piloto1->calcularBonus()."€</p>";

    // Viajes
    $viaje1 = new Viaje("París", 200, []);
    $viaje2 = new Viaje("Londres", 180, []);

    echo "<h2>Viajes</h2>";
    echo "<p>Destino viaje1: ".$viaje1->getDestino()." - Precio Base: ".$viaje1->getPrecioBase()."€</p>";
    echo "<p>Destino viaje2: ".$viaje2->getDestino()." - Precio Base: ".$viaje2->getPrecioBase()."€</p>";

    // Pasajeros
    $pasajero1 = new Pasajero("Ana", "11111111C", 30, 1000, "1234", 12, $viaje1);
    $pasajero2 = new Pasajero("Luis", "22222222D", 25, 950, "abcd", 15, $viaje1);

    echo "<h2>Pasajeros</h2>";
    echo "<p>".$pasajero1->getNombre()." - Asiento: ".$pasajero1->getNumAsiento()." - Precio a pagar: ".$pasajero1->precioAPagar()."€</p>";
    echo "<p>".$pasajero2->getNombre()." - Asiento: ".$pasajero2->getNumAsiento()." - Precio a pagar: ".$pasajero2->precioAPagar()."€</p>";

    // Añadir pasajeros al viaje
    $viaje1->addPasajero($pasajero1);
    $viaje1->addPasajero($pasajero2);

    echo "<p>Precio total del viaje a ".$viaje1->getDestino().": ".$viaje1->calcularPrecioTotal()."€</p>";

    // Array de viajes
    $viajes = [$viaje1, $viaje2];
    echo "<p>Array de viajes: ";
    foreach ($viajes as $v) {
        echo $v->getDestino()." ";
    }
    echo "</p>";

    // Reservas
    $reserva1 = new Reserva(1, $pasajero1, $viaje1, "2025-12-15");
    $reserva2 = new Reserva(2, $pasajero2, $viaje1, "2025-12-16");

    echo "<h2>Reservas</h2>";
    echo "<p>Reserva1 - Precio: ".$reserva1->calcularPrecio()."€</p>";
    echo "<p>Reserva2 - Precio: ".$reserva2->calcularPrecio()."€</p>";

    // Métodos estáticos de Usuario
    echo "<h2>Método estático de Usuario</h2>";
    echo "<p>Años para jubilarse de un usuario de 40 años: ".Usuario::añosParaJubilarse(40)." años</p>";

    // Métodos de cálculo de Usuario
    echo "<h2>Método de cálculo de Usuario</h2>";
    echo "<p>Bonus de pasajero Ana: ".$pasajero1->calcularBonus()."€</p>";
    echo "<p>Bonus de piloto Carlos: ".$piloto1->calcularBonus()."€</p>";
    ?>

    <hr>
    <footer>
        <p>Demo Sistema de Viajes 2025</p>
    </footer>
</body>
</html>