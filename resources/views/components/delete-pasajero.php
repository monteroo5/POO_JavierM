<form method="POST" action="index.php">
    <h3>Eliminar Pasajero</h3>
    
    <div class="form-group">
        <label for="pasajero_id">Selecciona un pasajero:</label>
        <select id="pasajero_id" name="pasajero_id" required>
            <option value="">-- Selecciona un pasajero --</option>
            <?php foreach ($listaPasajeros as $p): ?>
                <option value="<?= htmlspecialchars($p->getId()) ?>">
                    <?= htmlspecialchars($p->getNombre()) ?> 
                    (DNI: <?= htmlspecialchars($p->getDni()) ?>, 
                    Asiento: <?= htmlspecialchars($p->getNumAsiento()) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <button type="submit" name="btn_delete_pasajero" 
            onclick="return confirm('¿Estás seguro de eliminar este pasajero?');">
        Eliminar Pasajero
    </button>
</form>