<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre']) {

    include 'funciones.php';
    $error = false;
    $config = include 'config.php';

    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $consultaSQL = "SELECT * FROM ubicacion";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $ubicacion = $sentencia->fetchAll();
    } catch (PDOException $error) {
        $error = $error->getMessage();
    }

    if ($ubicacion) {
        foreach ($ubicacion as $u) {
            if (isset($_POST['editar_ubicacion_' . $u['id']])) {
                try {
                    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
                    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

                    $consultaSQL = "UPDATE ubicacion SET 
                nombre_ubicacion = '" . $_POST['nombre_ubicacion_' . $u['id']] . "', 
                updated_at = NOW() 
                WHERE id = " . $u['id'];

                    $sentencia = $conexion->prepare($consultaSQL);
                    $sentencia->execute();

                    header('Location: ./ubicacion.php');
                } catch (PDOException $error) {
                    $error = $error->getMessage();
                }
            }
        }
    }

    if (isset($_POST['submit_ubc'])) {
        $resultado = [
            'error' => false,
            'mensaje' => 'El articulo ' . $_POST['nombre_articulo'] . ' ha sido agregado con éxito'
        ];
        try {
            $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
            $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

            $consultaSQL = "INSERT INTO ubicacion (nombre_ubicacion) VALUES ('" . $_POST['nom_ubicacion'] . "')";

            $sentencia = $conexion->prepare($consultaSQL);
            $sentencia->execute();

            header('Location: ./ubicacion.php');
        } catch (PDOException $error) {
            $resultado['error'] = $error;
            $resultado['mensaje'] = 'Ha ocurrido un error al agregar el articulo';
        }
    }
?>

    <?php include "./templases/header.php" ?>

    <body class="sb-nav-fixed">
        <?php include('./templases/nav.php'); ?>
        <div id="layoutSidenav">
            <?php include('./templases/sidenav.php'); ?>
            <div id="layoutSidenav_content">
                <?php
                if ($error) {
                ?>
                    <div class="mt-2">
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
                            <li class="breadcrumb-item active">Administración - ubicación!</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex">
                                <div class="p-2 flex-grow-1 mt-2">
                                    <i class="fas fa-table me-1"></i>
                                    Ubicaciones
                                </div>
                                <div class="p-2">
                                    <form method="post">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Agrega una ubicación" id="nom_ubicacion" name="nom_ubicacion">
                                            </div>
                                            <div class="col-sm-3 text-center">
                                                <button type="submit" class="btn btn-outline-success" id="submit_ubc" name="submit_ubc">
                                                    Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body table-responsive-md">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre de la ubicación</th>
                                            <th>Actualizado en</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($ubicacion && $sentencia->rowCount() > 0) {
                                            foreach ($ubicacion as $fila) {
                                        ?>
                                                <tr>
                                                    <td><?php echo escapar($fila['id']) ?></td>
                                                    <td><?php echo escapar($fila['nombre_ubicacion']) ?></td>
                                                    <td><?php echo escapar($fila['updated_at']) ?></td>
                                                    <td>
                                                        <a class="btn" href="<?= 'borrar.php?id=' . escapar($fila["id"]) . '&table=ubicacion' ?>">🗑️Borrar</a>
                                                        <?php include './templases/modal_ubicacion.php' ?>
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
<?php
} else {
    header("Location: ./login.php");
    exit;
}
?>