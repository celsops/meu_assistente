<?php
header('Acess-Control-Allow-Origin: *');

if (isset($_GET['dados'])){
    include "../dao/Usuario.php";

    $jsonP = json_decode($_GET['dados']);

    $nota = new Usuario();
    $r = $nota->login($jsonP);
    echo $r;
}
else{
    echo "Nenhum dado enviado!";
}
?>
