    <?php
    include 'funciones.php';
    $error = false;
    $config = include 'config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        if (isset($_POST['articulo_nombre'])) {
            $consultaSQL = "SELECT
            articulo.id AS 'id_articulo',
            articulo.nombre_articulo AS 'nom_articulo', 
            articulo.cantidad AS 'cantidad_articulo', 
            articulo.descripcion_articulo AS 'desc_articulo', 
            ubicacion.nombre_ubicacion AS 'nom_ubicacion', 
            personal.nombre AS 'nom_personal' FROM articulo 
            INNER JOIN personal ON articulo.id_Ubicacion = personal.id
            INNER JOIN ubicacion ON articulo.id_Responsable = ubicacion.id
            WHERE articulo.nombre_articulo LIKE '%" . $_POST['articulo_nombre'] . "%' 
            OR personal.nombre LIKE '%" . $_POST['articulo_nombre'] . "%'";
        } else {
            $consultaSQL = "SELECT
            articulo.id AS 'id_articulo',
            articulo.nombre_articulo AS 'nom_articulo', 
            articulo.cantidad AS 'cantidad_articulo', 
            articulo.descripcion_articulo AS 'desc_articulo', 
            ubicacion.nombre_ubicacion AS 'nom_ubicacion', 
            personal.nombre AS 'nom_personal' FROM articulo 
            INNER JOIN personal ON articulo.id_Ubicacion = personal.id
            INNER JOIN ubicacion ON articulo.id_Responsable = ubicacion.id";
        }

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $alumnos = $sentencia->fetchAll();
    } catch (PDOException $error) {
        $error = $error->getMessage();
    }

    $titulo = isset($_POST['articulo_nombre']) ? 'Lista de articulos (' . $_POST['articulo_nombre'] . ')' : 'Lista de articulos';
    ?>

    <?php include "./templases/header.php" ?>

    <?php
    if ($error) {
    ?>
        <div class="container mt-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <!--Funcion filtro -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="crear_articulo.php" class="btn btn-primary mt-4">Agregar articulo</a>
                <a href="#" class="btn btn-primary mt-4">Agregar ubicacion</a>
                <a href="#" class="btn btn-primary mt-4">Agregar personal</a>
                <hr>
                <form method="post" class="form-inline">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group mr-3">
                                <input type="text" id="articulo_nombre" name="articulo_nombre" placeholder="Buscar por nombre del articulo o responsable" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-3"><?= $titulo ?></h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre articulo</th>
                            <th>Cantidad</th>
                            <th>Descripcion del articulo</th>
                            <th>Ubicación</th>
                            <th>Responsable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($alumnos && $sentencia->rowCount() > 0) {
                            foreach ($alumnos as $fila) {
                        ?>
                                <tr>
                                    <td><?php echo escapar($fila["id_articulo"]) ?></td>
                                    <td><?php echo escapar($fila["nom_articulo"]); ?></td>
                                    <td><?php echo escapar($fila["cantidad_articulo"]); ?></td>
                                    <td><?php echo escapar($fila["desc_articulo"]); ?></td>
                                    <td><?php echo escapar($fila["nom_ubicacion"]); ?></td>
                                    <td><?php echo escapar($fila["nom_personal"]); ?></td>
                                    <td>
                                        <a href="<?= 'borrar.php?id=' . escapar($fila["id_articulo"]) ?>">🗑️Borrar</a>
                                        <a href="<?= 'editar.php?id=' . escapar($fila["id_articulo"]) ?>" .>✏️Editar</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    <tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include "./templases/footer.php" ?>