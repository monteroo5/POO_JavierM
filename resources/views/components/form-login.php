<form method="POST" action="login.php">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
               placeholder="ejemplo@correo.com">
    </div>
    
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required 
               placeholder="Tu contraseña">
    </div>
    
    <div class="form-group">
        <label>
            <input type="checkbox" name="stay-connected" value="1">
            Permanecer conectado (1 semana)
        </label>
    </div>
    
    <button type="submit" name="btn_login">Iniciar Sesión</button>
</form>