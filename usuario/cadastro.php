<?php
header("Access-Control-Allow-Origin: *");

if (isset($_POST['dados'])){
  include "../dao/Usuario.php";

  $jsonP = json_decode($_POST['dados']);

  $nota = new Usuario();
  $r = $nota->cadastro($jsonP);
  echo $r;
}
else{
  echo "Nenhum dado enviado!";
}
?>
