<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
if (isset($_POST)){
  include "../dao/Nota.php";

  $nota = new Nota();
  var_dump($_POST['dados']);
  $dados = json_decode($_POST['dados']);
  $jsonP = $nota->delNotas($dados);
  echo $jsonP;
}
else{
  echo "Nenhum dado enviado!";
}
?>