<?php
header('Acess-Control-Allow-Origin: *');

if (isset($_POST)){
  include "../dao/Nota.php";

  $nota = new Usuario();
  $jsonP = $nota->getNotas();
  echo $jsonP;
}
else{
  echo "Nenhum dado enviado!";
}
?>
