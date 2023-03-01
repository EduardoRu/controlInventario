<?php

//inclusion del archivo "funciones" y sus funciones
include 'funciones.php';

//inclusion del archivo config que tiene el archivo config
$config = include 'config.php';

/*En caso de error lo guarda en la variable
 resultado y lo imprime en un mensaje de error*/
$resultado = [
  'error' => false,
  'mensaje' => ''
];

try {
  
  //Conexcion a base de datos (Es la misma para todos los documento)*/
  $dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
  $conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
  
  //Id recibido de la pagina principal*/
  $id = $_GET['id'];
  
  //consulata a base de datos*/
  $consultaSQL = "DELETE FROM articulo WHERE id =" . $id;
  
  //Sentencia o funcion de la base de datos*/
  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();

  /*Sentencia para que al finalisar el proceso 
    retorne al usuario el archivo index*/
  header('Location: ./index.php');

} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}
?>

<?php include "./templases/header.php" ?>

<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger" role="alert">
        <?= $resultado['mensaje'] ?>
      </div>
    </div>
  </div>
</div>

<?php include "./templases/footer.php" ?>