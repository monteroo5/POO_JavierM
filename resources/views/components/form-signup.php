<form action="signup.php" method="POST">
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>DNI: <input type="text" name="dni" pattern="[0-9]{8}[A-Z]" title="8 números y una letra" required></label><br>
    <label>Edad: <input type="number" name="edad" min="18" required></label><br>
    <label>Salario: <input type="number" step="0.01" name="salario" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit" name="btn_signup">Crear Usuario</button>
</form>