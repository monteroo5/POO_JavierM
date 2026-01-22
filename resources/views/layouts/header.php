<header>
    <h1>Aerolínea - Gestión de Pasajeros</h1>
    <nav>
        <ul>
            <?php if (isset($_SESSION['email'])): ?>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="closesession.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="signup.php">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<hr>