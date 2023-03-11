<!-- Button trigger modal -->
<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editarModal_<?= escapar($fila['id']) ?>">
    ✏️Editar
</button>

<!-- Modal -->
<div class="modal fade" id="editarModal_<?= escapar($fila['id']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?= escapar($fila['id']) ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel_<?= escapar($fila['id']) ?>">Editar la ubicacion "<?php echo escapar($fila['nombre_ubicacion']) ?>"</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="nombre_ubicacion">Nombre de la ubicacion</label>
                        <input type="text" name="nombre_ubicacion_<?= escapar($fila['id']) ?>" id="nombre_ubicacion_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['nombre_ubicacion']) ?>" required>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" name="editar_ubicacion_<?= escapar($fila['id']) ?>" id="editar_ubicacion_<?= escapar($fila['id']) ?>">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>