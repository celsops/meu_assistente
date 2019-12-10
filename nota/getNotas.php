<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET)){
  include "../dao/Nota.php";
  // var_dump($_GET['arr']);
  $j = $_GET['usuario'];
  $nota = new Nota();
  $jsonP = $nota->getNotas($j);
  // var_dump($jsonP);
  echo json_encode($jsonP);
}
else{
  echo "Nenhum dado enviado!";
}
?>
