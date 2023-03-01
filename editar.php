<?php
include 'funciones.php';

$config = include 'config.php';

$resultado = [
  'error' => false,
  'mensaje' => ''
];

if (!isset($_GET['id'])) {
  $resultado['error'] = true;
  $resultado['mensaje'] = 'El alumno no existe';
}

if (isset($_POST['submit'])) {
  try {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $alumno = [
      "id"                      => $_GET['id'],
      "nombre_articulo"         => $_POST['nombre_articulo'],
      "cantidad"                => $_POST['cantidad_articulo'],
      "descripcion_articulo"    => $_POST['desc_articulo'],
      "id_Ubicacion"            => $_POST['personal_respo'],
      "id_Responsable"          => $_POST['ubicacion_art']
    ];

    $consultaSQL = "UPDATE articulo SET
        nombre_articulo = :nombre_articulo,
        cantidad = :cantidad,
        descripcion_articulo = :descripcion_articulo,
        id_Ubicacion = :id_Ubicacion,
        id_Responsable = :id_Responsable,
        updated_at = NOW()
        WHERE id = :id";

    $consulta = $conexion->prepare($consultaSQL);
    $consulta->execute($alumno);
  } catch (PDOException $error) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $error->getMessage();
  }
}

try {
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

  $id = $_GET['id'];

  $consultaSQL = "SELECT
  articulo.id AS 'id_articulo',
  articulo.nombre_articulo AS 'nom_articulo', 
  articulo.cantidad AS 'cantidad_articulo', 
  articulo.descripcion_articulo AS 'desc_articulo',
  articulo.id_Ubicacion  AS 'id_Ubicacion',
  ubicacion.nombre_ubicacion AS 'nom_ubicacion', 
  articulo.id_Responsable AS 'id_Responsable',
  personal.nombre AS 'nom_personal',
  personal.apellido_paterno AS 'apellido_Personal' FROM articulo
  INNER JOIN personal ON articulo.id_Ubicacion = personal.id
  INNER JOIN ubicacion ON articulo.id_Responsable = ubicacion.id
  WHERE articulo.id = " . $id;

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  $articulo = $sentencia->fetch(PDO::FETCH_ASSOC);

  if (!$articulo) {
    $resultado['error'] = true;
    $resultado['mensaje'] = 'No se ha encontrado el articulo';
  }

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
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php include "./templases/header.php" ?>

<?php
if ($resultado['error']) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
          <?= $resultado['mensaje'] ?>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<?php
if (isset($_POST['submit']) && !$resultado['error']) {
?>
  <div class="container mt-2">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          El articulo ha sido actualizado correctamente
        </div>
      </div>
    </div>
  </div>
<?php
}
?>

<?php
if (isset($articulo) && $articulo) {
?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mt-4">Editando el articulo: <?= escapar($articulo['nom_articulo'])  ?></h2>
        <hr>
        <form method="post">
          <div class="form-group">
            <label for="nombre_articulo">Nombre del articulo</label>
            <input type="text" name="nombre_articulo" id="nombre_articulo" value="<?php echo escapar($articulo["nom_articulo"]) ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="cantidad_articulo">Cantidad del articulo</label>
            <input type="number" name="cantidad_articulo" id="cantidad_articulo" value="<?php echo escapar($articulo["cantidad_articulo"]) ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="desc_articulo">Descripción del articulo</label>
            <textarea name="desc_articulo" id="desc_articulo" class="form-control" required><?php echo escapar($articulo["desc_articulo"]) ?></textarea>
          </div>
          <div class="form-group">
          <label for="personal_respo">Ubicación del articulo</label>
          <!-- Coloar con select con el nombre de las ubicaciones -->
          <select name="personal_respo" id="personal_respo" class="form-select">
            <option value="<?php echo escapar($articulo["id_Responsable"]) ?>"> <?php echo escapar($articulo["nom_personal"] . ' ' . $articulo["apellido_Personal"]) ?> </option>
            <?php
            foreach ($personal as $p) {
            ?>
              <option value="<?php echo escapar($p["id_Personal"]) ?>"> <?php echo escapar($p["nombre_Personal"] . ' ' . $p["apellido_Personal"]) ?> </option>
            <?php
            }
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="ubicacion_art">Responsable del articulo</label>
          <!-- Coloar con select con el nombre de las personas registradas -->
          <select name="ubicacion_art" id="ubicacion_art" class="form-select">
            <option value="<?php echo escapar($articulo["id_Ubicacion"]) ?>"> <?php echo escapar($articulo["nom_ubicacion"]) ?> </option>
            <?php
            foreach ($ubicacion as $u) {
            ?>
              <option value="<?php echo escapar($u["id_Ubicacion"]) ?>"> <?php echo escapar($u["nombre_Ubicacion"]) ?> </option>
            <?php
            }
            ?>
          </select>
        </div>
          <div class="form-group mt-2">
            <input type="submit" name="submit" class="btn btn-primary" value="Actualizar">
            <a class="btn btn-primary" href="index.php">Regresar al inicio</a>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
}
?>

<?php include "./templases/footer.php" ?>