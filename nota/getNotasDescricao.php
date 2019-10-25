<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['id'])){
  include "../dao/Nota.php";

  $id = $_GET['id'];
  $nota = new Nota();
  $jsonP = $nota->getNotasDescricao($id);
  // var_dump($jsonP);
  echo json_encode($jsonP);
}
else{
  echo "Nenhum dado enviado!";
}
?>
