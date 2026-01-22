<form method="POST" action="signup.php">
    <div class="form-group">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" required 
               placeholder="Nombre completo" 
               minlength="3" maxlength="100">
    </div>
    
    <div class="form-group">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required 
               placeholder="12345678A" 
               pattern="[0-9]{8}[A-Za-z]{1}" 
               title="8 números seguidos de una letra"
               maxlength="9">
    </div>
    
    <div class="form-group">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required 
               min="18" max="120" value="18">
    </div>
    
    <div class="form-group">
        <label for="salario">Salario:</label>
        <input type="number" id="salario" name="salario" 
               step="0.01" min="0" value="0">
    </div>
    
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
               placeholder="ejemplo@correo.com">
    </div>
    
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required 
               placeholder="Mínimo 6 caracteres" 
               minlength="6">
    </div>
    
    <div class="form-group">
        <label for="password_confirm">Confirmar Contraseña:</label>
        <input type="password" id="password_confirm" name="password_confirm" required 
               placeholder="Repite la contraseña" 
               minlength="6">
    </div>
    
    <button type="submit" name="btn_signup">Registrarse</button>
</form>