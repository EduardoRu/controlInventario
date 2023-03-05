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
        ubicacion.nombre_ubicacion AS 'nom_ubicacion', 
        personal.nombre AS 'nom_personal' FROM articulo 
        INNER JOIN personal ON articulo.id_Ubicacion = personal.id
        INNER JOIN ubicacion ON articulo.id_Responsable = ubicacion.id";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $inventario = $sentencia->fetchAll();
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
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Inventario
                            </div>
                            <div class="card-body">
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
                                                        <a class="btn" href="<?= 'borrar.php?id=' . escapar($fila["id_articulo"]) ?>">🗑️Borrar</a>
                                                        <a class="btn" href="<?= 'editar.php?id=' . escapar($fila["id_articulo"]) ?>">✏️Editar</a>
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