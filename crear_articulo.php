<!--incluye archivo y funcionalidad del archivo header -->
<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre']) {
include "./templases/header.php"; ?>

<?php
//incluye archivo y funcionalidad del archivo funciones
include 'funciones.php';
try {

  $config = include 'config.php';

  $dsn = 'mysql:host=' . $config['db']['host'] .
    ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $consultaSQL = "SELECT 
  personal.id AS 'id_Personal',
  personal.nombre AS 'nombre_Personal',
  personal.apellido_paterno AS 'apellido_Personal',
  personal.apellido_materno AS 'apellido_m' FROM personal";

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
}



//Mensaje de error
if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'El articulo ' . $_POST['nombre_articulo'] . ' ha sido agregado con éxito'
  ];

  //incluye archivo y funcionalidad del archivo config.php
  $config = include 'config.php';
  //intentamos conectarnos a la base de datos
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] .
      ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    //Informacion del alumno
    $articulo = array(
      "nombre_articulo"         => $_POST['nombre_articulo'],
      "cantidad"                => $_POST['cantidad_articulo'],
      "descripcion_articulo"    => $_POST['desc_articulo'],
      "id_Ubicacion"            => $_POST['personal_respo'],
      "id_Responsable"          => $_POST['ubicacion_art']
    );
    //Consulta a la base de datos
    $consultaSQL = "INSERT INTO articulo (nombre_articulo, cantidad, descripcion_articulo, id_Ubicacion, id_Responsable)";
    $consultaSQL .= "values (:" . implode(", :", array_keys($articulo)) . ")";
    //Intenta ejecutar la consulta y retorna un mensaje de retroalimentacion
    $sentencia = $conexion->prepare($consultaSQL);
    //Ejecuta la sentencia
    $sentencia->execute($articulo);
    //Captura el error y muestra el mismo
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}
?>

<?php include "./templases/header.php" ?>

<body class="sb-nav-fixed">
  <?php include('./templases/nav.php'); ?>
  <div id="layoutSidenav" class="container">
    <?php include('./templases/sidenav.php'); ?>
    <div id="layoutSidenav_content">
      <div class="row">
        <div class="col-md-12">
          <h2 class="mt-4">Crea un nuevo articulo</h2>
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
            <div class="form-group">
              <label for="nombre_articulo">Nombre del articulo</label>
              <input type="text" name="nombre_articulo" id="nombre_articulo" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="cantidad_articulo">Cantidad del articulo</label>
              <input type="number" name="cantidad_articulo" id="cantidad_articulo" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="desc_articulo">Descripción del articulo</label>
              <textarea name="desc_articulo" id="desc_articulo" class="form-control" required></textarea>
            </div>
            <div class="form-group">
              <label for="personal_respo">Ubicación del articulo</label>
              <!-- Coloar con select con el nombre de las ubicaciones -->
              <select name="personal_respo" id="personal_respo" class="form-select" required>
                <option value=""> </option>
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
              <select name="ubicacion_art" id="ubicacion_art" class="form-select" required>
                <option value=""> </option>
                <?php
                foreach ($personal as $p) {
                ?>
                  <option value="<?php echo escapar($p["id_Personal"]) ?>"> <?php echo escapar($p["nombre_Personal"] . ' ' . $p["apellido_Personal"]. ' ' .$p['apellido_m']) ?> </option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="form-group mt-2 d-grid gap-2 col-6 mx-auto">
              <input type="submit" name="submit" class="btn btn-outline-success" value="Agregar articulo">
              <a class="btn btn-outline-secondary" href="index.php">Regresar al inicio</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>
<?php include "./templases/footer.php";
} else {
  header("Location: ./login.php");
  exit;
} ?>