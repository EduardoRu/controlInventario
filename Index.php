    <?php
    session_start();
    if (isset($_SESSION['id']) && $_SESSION['nombre']) {
        include 'funciones.php';
        $error = false;
        $config = include 'config.php';
        $inventario = [];
        try {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $consultaSQL = "SELECT articulo.*, ubicacion.nombre_ubicacion, personal.nombre, personal.apellido_paterno, personal.apellido_materno FROM articulo 
        INNER JOIN ubicacion ON articulo.id_Ubicacion = ubicacion.id
        INNER JOIN personal ON articulo.id_Responsable = personal.id";

            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute();

            $inventario = $sentencia->fetchAll();

            foreach ($inventario as $in) {
                if (isset($_POST['editar_articulo_' . $in['id']])) {
                    try {
                        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
                        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

                        $articulo = [
                            "id"                      => $in['id'],
                            "nombre_articulo"         => $_POST['nombre_articulo_' . $in['id']],
                            "cantidad"                => $_POST['cantidad_articulo_' . $in['id']],
                            "descripcion_articulo"    => $_POST['desc_articulo_' . $in['id']],
                            "id_Ubicacion"            => $_POST['ubicacion_art_' . $in['id']],
                            "id_Responsable"          => $_POST['personal_respo_' . $in['id']]
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
        } catch (PDOException $error) {
            $error = $error->getMessage();
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
                                                        <td><?php echo escapar($fila['id']) ?></td>
                                                        <td><?php echo escapar($fila['nombre_articulo']) ?></td>
                                                        <td><?php echo escapar($fila['cantidad']) ?></td>
                                                        <td><?php echo escapar($fila['descripcion_articulo']) ?></td>
                                                        <td><?php echo escapar($fila['nombre_ubicacion']) ?></td>
                                                        <td><?php echo escapar($fila['nombre'] . ' ' . $fila['apellido_paterno'] . ' ' . $fila['apellido_materno']) ?></td>
                                                        <td>
                                                            <!-- Eliminar un articulo -->
                                                            <a class="btn" href="<?= 'borrar.php?id=' . escapar($fila["id"]) . '&table=articulo' ?>">🗑️Borrar</a>
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
    <?php include "./templases/footer.php";
    } else {
        header("Location: ./login.php");
        exit;
    } ?>