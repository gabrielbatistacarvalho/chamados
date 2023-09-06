<?php 

include __DIR__."/../../src/functions/includes.php";

$con       = db();
$retorno   = "";
$idEmpresa = decrypt($_GET['IdEmpresa']);

$sql = "SELECT * FROM usuario WHERE (IdEmpresa = '$idEmpresa') AND (Status = 'A') AND (Excluido = 'N')";

$query = $con->query($sql);

while($data = mysqli_fetch_assoc($query))
{
    $retorno .= encrypt($data['IdUsuario'])."-".$data['Nome']."|";
}

echo rtrim($retorno, "|");

?>