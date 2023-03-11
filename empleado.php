<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre'] && $_SESSION['puesto'] == "admin") {
    include 'funciones.php';
    $error = false;
    $config = include 'config.php';
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

        $consultaSQL = "SELECT * FROM personal";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute();

        $personal = $sentencia->fetchAll();

        if ($personal) {
            foreach ($personal as $per) {
                if (isset($_POST['editar_personal_' . $per['id']])) {
                    try {

                        $pass = "";

                        if (password_verify($_POST['pass_empleado_' . $per['id']], $per['password'])) {
                            $pass = password_hash($_POST['pass_empleado_' . $per['id']], PASSWORD_DEFAULT);
                        } else {
                            $pass = $per['password'];
                        }

                        $personalData = [
                            'id'                => $per['id'],
                            'nombre'            => $_POST['nombre_empleado_' . $per['id']],
                            'apellido_paterno'  => $_POST['apellido_paterno_' . $per['id']],
                            'apellido_materno'  => $_POST['apellido_materno_' . $per['id']],
                            'puesto_cargo'      => $_POST['puesto_cargo_empleado_' . $per['id']],
                            'telefono'          => $_POST['telefono_empleado_' . $per['id']],
                            'email'             => $_POST['email_empleado_' . $per['id']],
                            'password'          => $pass
                        ];

                        $consultaSQL = "UPDATE personal SET
                    nombre = :nombre,
                    apellido_paterno = :apellido_paterno,
                    apellido_materno = :apellido_materno,
                    puesto_cargo = :puesto_cargo,
                    telefono = :telefono,
                    email = :email,
                    password = :password,
                    updated_at = NOW()
                    WHERE id = :id";

                        $sentencia = $conexion->prepare($consultaSQL);
                        $sentencia->execute($personalData);

                        header('Location: ./empleado.php');
                    } catch (PDOException $error) {
                        $error = $error->getMessage();
                    }
                }
            }
        }
    } catch (PDOException $error) {
        $error = $error->getMessage();
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
                            <li class="breadcrumb-item active">Administración - empleados!</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header d-flex">
                                <div class="p-2 flex-grow-1 mt-2">
                                    <i class="fas fa-table me-1"></i>Empleados
                                </div>
                                <div class="p-2">
                                    <a type="button" class="btn btn-outline-success" href="./crear_empleado.php">
                                        Agregar empleado
                                    </a>
                                </div>
                            </div>
                            <div class="card-body table-responsive-md">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Apellido paterno</th>
                                            <th>Apellido materno</th>
                                            <th>Puesto</th>
                                            <th>Teléfono</th>
                                            <th>email</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($personal && $sentencia->rowCount() > 0) {
                                            foreach ($personal as $fila) {
                                        ?>
                                                <tr>
                                                    <td><?php echo escapar($fila['id']) ?></td>
                                                    <td><?php echo escapar($fila['nombre']) ?></td>
                                                    <td><?php echo escapar($fila['apellido_paterno']) ?></td>
                                                    <td><?php echo escapar($fila['apellido_materno']) ?></td>
                                                    <td><?php echo escapar($fila['puesto_cargo']) ?></td>
                                                    <td><?php echo escapar($fila['telefono']) ?></td>
                                                    <td><?php echo escapar($fila['email']) ?></td>
                                                    <td>
                                                        <a class="btn" href="<?= 'borrar.php?id=' . escapar($fila["id"]) . '&table=personal' ?>">🗑️Borrar</a>
                                                        <?php include "./templases/modal_empleado.php"; ?>
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