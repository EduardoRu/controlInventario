<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['nombre'] && $_SESSION['puesto'] == "admin") {
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
  $table = $_GET['table'];
  
  $consultaSQL = "";
  //consulata a base de datos*/
  if($table == 'articulo'){
    try{
      $consultaSQL = "DELETE FROM articulo WHERE id =" . $id;
      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute();
      header('Location: ./index.php');
    }catch(PDOException $error){
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Ha ocurrido el siguiente error: '.$error->getMessage();

      header('Location: ./index.php?$resultado='.$resultado);
    }
  }else if($table == 'personal'){
    try{
      $consultaSQL = "DELETE FROM personal WHERE id =" . $id;
      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute();
      header('Location: ./empleado.php');
    }catch(PDOException $error){
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Verifique que la ubicaicón no esté ligada a un articulo, error: '.$error->getMessage();

      header('Location: ./empleado.php?$resultado='.$resultado);
    }
  }else if($table == 'ubicacion'){
    try{
      $consultaSQL = "DELETE FROM ubicacion WHERE id =" . $id;
      $sentencia = $conexion->prepare($consultaSQL);
      $sentencia->execute();
      header('Location: ./ubicacion.php');  
    }catch(PDOException $error){
      $resultado['error'] = true;
      $resultado['mensaje'] = 'Verifique que el empleado no esté ligada a un articulo, error: '.$error->getMessage();

      header('Location: ./ubicacion.php?resultado='.$resultado);
    }
  }


} catch(PDOException $error) {
  $resultado['error'] = true;
  $resultado['mensaje'] = $error->getMessage();
}

} else {
  header("Location: ./login.php");
  exit;
}
