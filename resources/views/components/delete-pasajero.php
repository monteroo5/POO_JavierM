<form method="POST">
    <h3>Eliminar Pasajero</h3>
    <select name="pasajero_id">
        <option value="">Selecciona uno...</option>
        <?php foreach ($pasajeros as $p): ?>
            <option value="<?php echo $p->getId(); ?>">
                <?php echo $p->getNombre(); ?> (Asiento: <?php echo $p->getNumAsiento(); ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="btn_delete_pasajero">Eliminar</button>
</form>