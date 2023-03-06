    <?php
    include 'funciones.php';
    $error = false;
    $config = include 'config.php';
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $consultaSQL = "SELECT
        articulo.id AS 'id_articulo',
        articulo.nombre_articulo AS 'nom_articulo', 
        articulo.cantidad AS 'cantidad_articulo', 
        articulo.descripcion_articulo AS 'desc_articulo',
        articulo.id_Ubicacion AS 'id_ubicacion',
        ubicacion.nombre_ubicacion AS 'nom_ubicacion',
        articulo.id_Responsable AS 'id_responsable',
        personal.nombre AS 'nom_personal'
        FROM articulo 
        INNER JOIN personal ON articulo.id_Ubicacion = personal.id
        INNER JOIN ubicacion ON articulo.id_Responsable = ubicacion.id";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $inventario = $sentencia->fetchAll();
    } catch (PDOException $error) {
        $error = $error->getMessage();
    }

    if ($inventario) {
        foreach ($inventario as $fila) {
            if (isset($_POST['editar_articulo_' . $fila['id_articulo']])) {
                try {
                    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
                    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

                    $articulo = [
                        "id"                      => $fila['id_articulo'],
                        "nombre_articulo"         => $_POST['nombre_articulo_' . $fila['id_articulo']],
                        "cantidad"                => $_POST['cantidad_articulo_' . $fila['id_articulo']],
                        "descripcion_articulo"    => $_POST['desc_articulo_' . $fila['id_articulo']],
                        "id_Ubicacion"            => $_POST['personal_respo_' . $fila['id_articulo']],
                        "id_Responsable"          => $_POST['ubicacion_art_' . $fila['id_articulo']]
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
                    $consulta->execute($articulo);

                    header('Location: ./index.php');
                } catch (PDOException $error) {
                    $error = $error->getMessage();
                }
            }
        }
    }

    ?>

    <?php include "./templases/header.php" ?>
    <!--Funcion filtro -->

    <body class="sb-nav-fixed">
        <?php include('./templases/nav.php'); ?>
        <div id="layoutSidenav">
            <?php include('./templases/sidenav.php'); ?>
            <div id="layoutSidenav_content">
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
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Administración</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Administración - inventario!</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex">
                                <div class="p-2 flex-grow-1 mt-2">
                                    <i class="fas fa-table me-1"></i> Inventario
                                </div>
                                <div class="p-2">
                                    <a type="button" class="btn btn-outline-success" href="./crear_articulo.php">
                                        Agregar articulo
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive-xl">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Descripción</th>
                                            <th>Ubicación</th>
                                            <th>Responsable</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($inventario && $sentencia->rowCount() > 0) {
                                            foreach ($inventario as $fila) {
                                        ?>
                                                <tr>
                                                    <td><?php echo escapar($fila['id_articulo']) ?></td>
                                                    <td><?php echo escapar($fila['nom_articulo']) ?></td>
                                                    <td><?php echo escapar($fila['cantidad_articulo']) ?></td>
                                                    <td><?php echo escapar($fila['desc_articulo']) ?></td>
                                                    <td><?php echo escapar($fila['nom_ubicacion']) ?></td>
                                                    <td><?php echo escapar($fila['nom_personal']) ?></td>
                                                    <td>
                                                        <!-- Eliminar un articulo -->
                                                        <a class="btn" href="<?= 'borrar.php?id=' . escapar($fila["id_articulo"]) . '&table=articulo' ?>">🗑️Borrar</a>
                                                        <!-- Editar un articulo -->
                                                        <?php include('./templases/modal_inventario.php') ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
    <?php include "./templases/footer.php" ?>