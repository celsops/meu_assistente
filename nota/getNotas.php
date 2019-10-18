<?php
header('Acess-Control-Allow-Origin: *');

if (isset($_GET)){
  include "../dao/Nota.php";

  $j = $_GET['usuario'];
  $nota = new Nota();
  $jsonP = $nota->getNotas($j);
  echo $jsonP;
}
else{
  echo "Nenhum dado enviado!";
}
?>
