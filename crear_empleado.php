<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre'] && $_SESSION['puesto'] == "admin") {
include 'funciones.php';
$error = false;
$config = include 'config.php';

if (isset($_POST['submit'])) {
    $resultado = [
        'error' => false,
        'mensaje' => 'El empleado ' . $_POST['nombre_empleado'] . ' ha sido agregado con éxito'
    ];
    try {
        $dsn = 'mysql:host=' . $config['db']['host'] .
            ';dbname=' . $config['db']['name'];
        $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
        $pass = password_hash($_POST['pass_empleado'], PASSWORD_DEFAULT);

        $empleado = [
            'nombre'            => $_POST['nombre_empleado'],
            'apellido_paterno'  => $_POST['apellido_paterno'],
            'apellido_materno'  => $_POST['apellido_materno'],
            'puesto_cargo'      => $_POST['puesto_cargo_empleado'],
            'telefono'          => $_POST['telefono_empleado'],
            'email'             => $_POST['email_empleado'],
            'password'          => $pass
        ];

        $consultaSQL = "INSERT INTO personal (nombre, apellido_paterno, apellido_materno, puesto_cargo, telefono, email, password)";
        $consultaSQL.= "values (:" . implode(", :", array_keys($empleado)) . ")";

        $sentencia = $conexion->prepare($consultaSQL);
        $sentencia->execute($empleado);

    } catch (PDOException $error) {
        $resultado['error'] = true;
        $resultado['mensaje'] = 'Ah ocurrido un error al agregar al el empleado';
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
                            <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" placeholder="Nombre del empleado" required>
                        </div>
                        <div class="input-group mt-3">
                            <label class="input-group-text">Apellidos</label>
                            <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" placeholder="Apellido paterno" required>
                            <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" placeholder="Apellido materno" required>
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
                            <input type="number" id="telefono_empleado" name="telefono_empleado" class="form-control" placeholder="Telefono del empleado" required>
                        </div>
                        <div class="input-group mt-3">
                            <label for="" class="input-group-text">Correo electronico</label>
                            <input type="email" id="email_empleado" name="email_empleado" class="form-control" placeholder="Correo electronico del empleado" required>
                        </div>
                        <div class="input-group mt-3">
                            <label class="input-group-text">Contraseña</label>
                            <input type="text" name="pass_empleado" name="pass_empleado" class="form-control" placeholder="Agregar contraseña" required>
                        </div>
                        <div class="form-group mt-2 d-grid gap-2 col-6 mx-auto">
                            <input type="submit" name="submit" class="btn btn-outline-success" value="Agregar empleado">
                            <a class="btn btn-outline-secondary" href="./empleado.php">Regresar al inicio</a>
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