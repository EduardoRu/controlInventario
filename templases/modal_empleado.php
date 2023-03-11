<!-- Button trigger modal -->
<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#editarModal_<?= escapar($fila['id']) ?>">
  ✏️Editar
</button>

<!-- Modal -->
<div class="modal fade" id="editarModal_<?= escapar($fila['id']) ?>" tabindex="-1" aria-labelledby="exampleModalLabel_<?= escapar($fila['id']) ?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel_<?= escapar($fila['id']) ?>">Editar datos del empleado "<?php echo escapar($fila['nombre']) ?>"</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="input-group mt-3">
            <label class="input-group-text">Nombre del empleado</label>
            <input type="text" name="nombre_empleado_<?= escapar($fila['id']) ?>" id="nombre_empleado_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['nombre']) ?>" required>
          </div>
          <div class="input-group mt-3">
            <label class="input-group-text">Apellidos</label>
            <input type="text" name="apellido_paterno_<?= escapar($fila['id']) ?>" id="apellido_paterno_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['apellido_paterno']) ?>" required>
            <input type="text" name="apellido_materno_<?= escapar($fila['id']) ?>" id="apellido_materno_<?= escapar($fila['id']) ?>" class="form-control" value="<?= escapar($fila['apellido_materno']) ?>" required>
          </div>
          <div class="input-group mt-3">
            <label class="input-group-text" for="puesto_cargo_empleado">Puesto/Cargo del empleado</label>
            <select class="form-select" name="puesto_cargo_empleado_<?= escapar($fila['id']) ?>" id="puesto_cargo_empleado_<?= escapar($fila['id']) ?>" required>
              <option value="<?= escapar($fila['puesto_cargo']) ?>"><?php echo escapar($fila['puesto_cargo']) ?></option>
              <option value="admin">Administrador/admin</option>
              <option value="boss">Director/boss</option>
              <option value="professor">Docente/teacher</option>
              <option value="pp">Personal general/pp</option>
            </select>
          </div>
          <div class="input-group mt-3">
            <label class="input-group-text">Telefono</label>
            <input type="number" id="telefono_empleado_<?= escapar($fila['id']) ?>" name="telefono_empleado_<?= escapar($fila['id']) ?>" value="<?= escapar($fila['telefono']) ?>" class="form-control" required>
          </div>
          <div class="input-group mt-3">
            <label for="" class="input-group-text">Correo electronico</label>
            <input type="email" id="email_empleado_<?= escapar($fila['id']) ?>" name="email_empleado_<?= escapar($fila['id']) ?>" value="<?= escapar($fila['email']) ?>" class="form-control" required>
          </div>
          <div class="input-group mt-3">
            <label class="input-group-text">Contraseña</label>
            <input type="text" name="pass_empleado_<?= escapar($fila['id']) ?>" name="pass_empleado_<?= escapar($fila['id']) ?>" class="form-control">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" name="editar_personal_<?= escapar($fila['id']) ?>" id="editar_personal_<?= escapar($fila['id']) ?>">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>