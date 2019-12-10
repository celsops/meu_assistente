<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['dados'])){
  include "../dao/Nota.php";

  $json = json_decode($_GET['dados']);
  $nota = new Nota();
  $r = $nota->updateNotas($json);
  
  echo $r;
}
else{
  echo "Nenhum dado enviado!";
}
?>
