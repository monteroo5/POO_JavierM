<?php
session_start();
session_destroy();
header("Location: formLogin.php");

if (isset($_COOKIE['usuario_web'])) {
    setcookie('usuario_web', '', time() - 3600, "/");
}

header("Location: login.php");
exit();