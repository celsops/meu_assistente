<?php
  header("Access-Control-Allow-Origin: *");

  if (isset($_POST['dados'])){
    include "../dao/Usuario.php";

    $jsonP = json_decode($_POST['dados']);

    $user = new Usuario();
    $r = $user->cadastro($jsonP);
    echo $r;
  }
  else{
    echo "Nenhum dado enviado!";
  }
?>
