<?php
session_start();
$config = include 'config.php';

if (isset($_POST['email_personal']) && isset($_POST['pass_personal'])) {
    $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

    $email = $_POST['email_personal'];
    $password = $_POST['pass_personal'];

    $sql = "SELECT * FROM personal WHERE email = ?";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute([$email]);

    if ($sentencia->rowCount() == 1) {
        $user = $sentencia->fetch();

        $uemail = $user['email'];
        $upassword = $user['password'];
        $ucargo = $user['puesto_cargo'];
        $name = $user['nombre'];
        $id = $user['id'];

        if ($uemail === $email) {
            if (password_verify($password, $upassword)) {

                $_SESSION['id'] = $id;
                $_SESSION['nombre'] = $name;
                $_SESSION['puesto'] = $ucargo;

                header("Location: ./index.php");
                exit;
            }
        }
    }
} else {
    header("Location: ./login.php");
    exit;
}
?>