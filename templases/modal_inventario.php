<?php
try {
    $consultaSQL = "SELECT 
    personal.id AS 'id_Personal',
    personal.nombre AS 'nombre_Personal',
    personal.apellido_paterno AS 'apellido_Personal',
    personal.apellido_materno AS 'apellido_Personal_M' FROM personal";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $personal = $sentencia->fetchAll();

    $consultaSQL = "SELECT 
    ubicacion.id AS 'id_Ubicacion',
    ubicacion.nombre_ubicacion AS 'nombre_Ubicacion' FROM ubicacion";

    $sentencia = $conexion->prepare($consultaSQL);
    $sentencia->execute();

    $ubicacion = $sentencia->fetchAll();
} catch (PDOException $error) {
    $error = $error->getMessage();
}
?>

<!-- Button trigger modal -->
<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editarModal_<?= escapar($fila['id']) ?>">
    ✏️Editar
</button>

<!-- Modal -->
<div class="modal fade" id="editarModal_<?= escapar($fila['id']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?= escapar($fila['id']) ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_<?= escapar($fila['id']) ?>">Editar el articulo "<?php echo escapar($fila['nombre_articulo']) ?>"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="nombre_articulo">Nombre del articulo</label>
                        <input type="text" name="nombre_articulo_<?= escapar($fila['id']) ?>" id="nombre_articulo_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['nombre_articulo']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad_articulo">Cantidad del articulo</label>
                        <input type="number" name="cantidad_articulo_<?= escapar($fila['id']) ?>" id="cantidad_articulo_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['cantidad']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="desc_articulo">Descripción del articulo</label>
                        <input type="text" name="desc_articulo_<?= escapar($fila['id']) ?>" id="desc_articulo_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['descripcion_articulo']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="">Ubicación del articulo</label>
                        <select name="ubicacion_art_<?= escapar($fila['id']) ?>" id="ubicacion_art_<?= escapar($fila['id']) ?>" class="form-select" required>
                            <option value="<?= escapar($fila['id']) ?>"> <?php echo escapar($fila['nombre_ubicacion']) ?> </option>
                            <?php
                            foreach ($ubicacion as $u) {
                            ?>
                                <option value="<?= escapar($u["id_Ubicacion"]) ?>"> <?php echo escapar($u["nombre_Ubicacion"]) ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Responsable del articulo</label>
                        <!-- Coloar con select con el nombre de las personas registradas -->
                        <select name="personal_respo_<?= escapar($fila['id']) ?>" id="personal_respo_<?= escapar($fila['id']) ?>" class="form-select" required>
                            <option value="<?= escapar($fila['id']) ?>"> <?php echo escapar($fila['nombre'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']) ?> </option>
                            <?php
                            foreach ($personal as $p) {
                            ?>
                                <option value="<?= escapar($p["id_Personal"]) ?>"> <?php echo escapar($p["nombre_Personal"] . ' ' . $p["apellido_Personal"] . ' ' . $p['apellido_Personal_M']) ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary" name="editar_articulo_<?= escapar($fila['id']) ?>" id="editar_articulo_<?= escapar($fila['id']) ?>" value="Guardar cambios">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>