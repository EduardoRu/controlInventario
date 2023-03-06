<?php
try {
    $config = include 'config.php';

    $dsn = 'mysql:host=' . $config['db']['host'] .
        ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $consultaSQL = "SELECT 
    personal.id AS 'id_Personal',
    personal.nombre AS 'nombre_Personal',
    personal.apellido_paterno AS 'apellido_Personal' FROM personal";

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
<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editarModal_<?= escapar($fila['id_articulo']) ?>">
    ✏️Editar
</button>

<!-- Modal -->
<div class="modal fade" id="editarModal_<?= escapar($fila['id_articulo']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?= escapar($fila['id_articulo']) ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_<?= escapar($fila['id_articulo']) ?>">Editar el articulo "<?php echo escapar($fila['nom_articulo']) ?>"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="nombre_articulo">Nombre del articulo</label>
                        <input type="text" name="nombre_articulo_<?= escapar($fila['id_articulo']) ?>" id="nombre_articulo_<?= escapar($fila['id_articulo']) ?>" class="form-control" value="<?= escapar($fila['nom_articulo']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad_articulo">Cantidad del articulo</label>
                        <input type="number" name="cantidad_articulo_<?= escapar($fila['id_articulo']) ?>" id="cantidad_articulo_<?= escapar($fila['id_articulo']) ?>" class="form-control" value="<?= escapar($fila['cantidad_articulo']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="desc_articulo">Descripción del articulo</label>
                        <textarea name="desc_articulo_<?= escapar($fila['id_articulo']) ?>" id="desc_articulo_<?= escapar($fila['id_articulo']) ?>" class="form-control" required><?= escapar($fila['desc_articulo']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="personal_respo">Ubicación del articulo</label>
                        <select name="personal_respo_<?= escapar($fila['id_articulo']) ?>" id="personal_respo_<?= escapar($fila['id_articulo']) ?>" class="form-select" required>
                            <option value="<?= escapar($fila['id_ubicacion']) ?>"> <?php echo escapar($fila['nom_ubicacion']) ?> </option>
                            <?php
                            foreach ($ubicacion as $u) {
                            ?>
                                <option value="<?php echo escapar($u["id_Ubicacion"]) ?>"> <?php echo escapar($u["nombre_Ubicacion"]) ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ubicacion_art">Responsable del articulo</label>
                        <!-- Coloar con select con el nombre de las personas registradas -->
                        <select name="ubicacion_art_<?= escapar($fila['id_articulo']) ?>" id="ubicacion_art_<?= escapar($fila['id_articulo']) ?>" class="form-select" required>
                            <option value="<?= escapar($fila['id_responsable']) ?>"> <?php echo escapar($fila['nom_personal']) ?> </option>
                            <?php
                            foreach ($personal as $p) {
                            ?>
                                <option value="<?php echo escapar($p["id_Personal"]) ?>"> <?php echo escapar($p["nombre_Personal"] . ' ' . $p["apellido_Personal"]) ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" name="editar_articulo_<?= escapar($fila['id_articulo']) ?>" id="editar_articulo_<?= escapar($fila['id_articulo']) ?>">Guardar cambios</button>
            </div>
            </form>
        </div>
    </div>
</div>