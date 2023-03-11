<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre'] && $_SESSION['puesto'] == "admin") {
  $config = include 'config.php';

  try {
    $conexion = new PDO(
      'mysql:host='
        . $config['db']['host'],
      $config['db']['user'],
      $config['db']['pass'],
      $config['db']['options']
    );
    $sql = file_get_contents("date/migration.sql");

    $conexion->exec($sql);

    echo "La base de datos y la tabla de alumnos se han creado con éxito.";
  } catch (PDOException $error) {
    echo $error->getMessage();
  }
} else {
  header("Location: ./login.php");
  exit;
}
?>