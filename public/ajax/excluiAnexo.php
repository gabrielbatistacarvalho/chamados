<?php

include __DIR__."/../../src/functions/includes.php";

$con         = db();
$retorno     = "";
$idAnexo     = decrypt($_GET['IdAnexo']);
$idUsuario   = decrypt($_GET['IdUsuario']);
$hoje        = date("Y-m-d");
$agora       = date("H:i:s");
$sql         = "SELECT * FROM anexo WHERE (IdAnexo = '$idAnexo') AND (Excluido = 'N')";
$data        = mysqli_fetch_assoc($con->query($sql));
$explode     = explode("-", $data['DataInclusao']);
$anoInclusao = $explode[0];
$mesInclusao = $explode[1];

$link = "../anexos/".$anoInclusao."/".$mesInclusao."/".$data['Nome'].".".$data['Extensao'];

if(file_exists($link)){
    if(unlink($link)){
        $sqlAnexo = "UPDATE anexo 
                     SET Excluido        = 'S',
                         DataExcluido    = '$hoje',
                         HoraExcluido    = '$agora',
                         UsuarioExcluido = '$idUsuario'
                     WHERE (IdAnexo = '$idAnexo')";
        $con->query($sqlAnexo);
        echo true;
    } else {
        echo false;
    }
} else {
    /*
    $sqlAnexo = "UPDATE anexo SET Excluido = 'S' WHERE (IdAnexo = '$idAnexo')";
    
    $con->query($sqlAnexo);
    */
    echo false;
}

?>