<form method="POST" action="index.php">
    <h3>Crear Nuevo Pasajero</h3>
    
    <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required 
               placeholder="Nombre completo" 
               minlength="3">
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
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required 
               placeholder="pasajero@correo.com">
    </div>
    
    <div class="form-group">
        <label for="num_asiento">Número de Asiento:</label>
        <input type="number" id="num_asiento" name="num_asiento" required 
               min="1" max="300" 
               placeholder="Ej: 42">
    </div>
    
    <button type="submit" name="btn_create_pasajero">Guardar Pasajero</button>
</form>