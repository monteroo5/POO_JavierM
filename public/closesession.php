<?php
// Cierra sesión y redirige a login
session_start();
session_destroy();

// Borrar la cookie: poner un tiempo pasado
setcookie("stay-connected", "", time() - 3600, "/");

header("Location: login.php");
exit();