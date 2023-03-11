<?php include "./templases/header.php" ?>

<body class="sb-nav-fixed">
  <?php include('./templases/nav.php'); ?>
  <div id="layoutSidenav" class="container">
    <?php include('./templases/sidenav.php'); ?>
    <div id="layoutSidenav_content">
      <div class="row">
        <div class="col-md-12">
          <h2 class="mt-4">Agregar un nuveo empleado</h2>
          <?php
          if (isset($resultado)) {
          ?>
            <div class="mt-3">
              <div class="row">
                <div class="col-md-12">
                  <div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
                    <?= $resultado['mensaje'] ?>
                  </div>
                </div>
              </div>
            </div>
          <?php
          }
          ?>
          <hr>
          <form method="post">
            <div class="input-group mt-3">
              <label class="input-group-text">Nombre del empleado</label>
              <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" required>
            </div>
            <div class="input-group mt-3">
              <label class="input-group-text">Apellidos</label>
              <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" required>
              <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" required>
            </div>
            <div class="input-group mt-3">
              <label class="input-group-text" for="puesto_cargo_empleado">Puesto/Cargo del empleado</label>
              <select class="form-select" name="puesto_cargo_empleado" id="puesto_cargo_empleado" required>
                <option value=""></option>
                <option value="admin">Administrador</option>
                <option value="boss">Director</option>
                <option value="professor">Docente</option>
                <option value="pp">Personal general</option>
              </select>
            </div>
            <div class="input-group mt-3">
                <label class="input-group-text">Telefono</label>
                <input type="number" id="telefono_empleado" name="telefono_empleado" class="form-control" required>
            </div>
            <div class="input-group mt-3">
                <label for="" class="input-group-text">Correo electronico</label>
                <input type="email" id="email_empleado" name="email_empleado" class="form-control" required>
            </div>
            <div class="input-group mt-3">
                <label class="input-group-text">Contraseña</label>
                <input type="text" name="pass_empleado" name="pass_empleado" class="form-control" required>
            </div>
            <div class="form-group mt-2 d-grid gap-2 col-6 mx-auto">
              <input type="submit" name="submit" class="btn btn-outline-success" value="Agregar empleado">
              <a class="btn btn-outline-secondary" href="index.php">Regresar al inicio</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>
<?php include "./templases/footer.php" ?>