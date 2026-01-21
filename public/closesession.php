<?php
session_start();
session_destroy();
// Borrar la cookie de "recordar"
setcookie('usuario_web', '', time() - 3600, "/");
header("Location: login.php");
exit();