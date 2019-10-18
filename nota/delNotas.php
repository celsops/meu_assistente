<?php
header('Acess-Control-Allow-Origin: *');

if (isset($_POST)){
  include "../dao/Nota.php";

  $nota = new Nota();
  $jsonP = $nota->delNotas();
  echo $jsonP;
}
else{
  echo "Nenhum dado enviado!";
}
?>
