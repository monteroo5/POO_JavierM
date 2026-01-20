<header>
    <h1>Aerolínea - Gestión de Pasajeros</h1>
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
                <li><a href="signup.php">Registrarse</a></li>
            <?php else: ?>
                <li><a href="closesession.php">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<hr>