<?php
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
                        <li class="breadcrumb-item active">Administración - ubicación!</li>
                    </ol>
                </div>
            </main>
        </div>
    </div>
</body>
<?php include "./templases/footer.php" ?>