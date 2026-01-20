<form action="index.php" method="POST">
    <h4>Eliminar Pasajero</h4>
    <select name="id_pasajero_borrar" required>
        <option value="">Seleccione un pasajero...</option>
        <?php foreach ($pasajeros as $p): ?>
            <option value="<?= $p->getDni() ?>"><?= $p->getNombre() ?> (<?= $p->getDni() ?>)</option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="btn_delete_pasajero">Eliminar</button>
</form>