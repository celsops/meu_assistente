<?php
header('Acess-Control-Allow-Origin: *');

if (isset($_GET['dados'])){
  include "../dao/Nota.php";

  $jsonP = json_decode($_GET['dados']);

  $nota = new Nota();
  $r = $nota->criarNota($jsonP);
  echo $r;
}
else{
  echo "Nenhum dado enviado!";
}
?>
