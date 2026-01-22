<?php
//Cierra sesión y redirige a signup.
session_start();
session_destroy();
header("Location: form-login.php");
//borro las cookies: le pongo un tiempo pasado
setcookie("stay-connected", "", time() - 3600, "/");
