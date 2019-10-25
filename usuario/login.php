<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_POST['dados'])){
    include "../dao/Usuario.php";

    $jsonP = json_decode($_POST['dados']);

    $nota = new Usuario();
    $r = $nota->login($jsonP);
    echo $r;
}
else{
    echo "Nenhum dado enviado!";
}
?>
