<?php 

include __DIR__."/../../src/functions/includes.php";

$con     = db();
$retorno = "fail";
$arrayPrioridade = array(
    "CRI" => "CRÍTICA", 
    "ALT" => "ALTA", 
    "MED" => "MÉDIA", 
    "BAI" => "BAIXA", 
    "NEM" => "NENHUMA"
);
$arrayStatus = array(
    "AGU" => "AGUARDANDO", 
    "INI" => "INICIADO", 
    "PRO" => "EM PROCESSAMENRO", 
    "FIN" => "BAIXA", 
    "CAN" => "NENHUMA"
);

if(isset($_GET['IdChamado'])){
    $getIdChamado = decrypt($_GET['IdChamado']);
    $sql = "SELECT a.*, b.Nome AS NomeEmpresa, c.Nome AS NomeUsuario
            FROM chamado       AS a 
            INNER JOIN empresa AS b ON(a.IdEmpresa = b.IdEmpresa)
            INNER JOIN usuario AS c ON(a.IdUsuario = c.IdUsuario)
            WHERE (a.IdChamado = '$getIdChamado')
            AND   (a.Excluido  = 'N')
            AND   (b.Excluido  = 'N')
            AND   (c.Excluido  = 'N')";
    
    $query      = $con->query($sql) or die('ERRO SQL: chamado '.$sql);
    $data       = mysqli_fetch_assoc($query);
    
    $sqlAnexo   = "SELECT * FROM anexo WHERE (IdChamado = '$getIdChamado') AND (Excluido = 'N')";
    $queryAnexo = $con->query($sqlAnexo) or die('ERRO SQL: anexo '.$sqlAnexo);
    $dataAnexo  = mysqli_fetch_assoc($queryAnexo);

    if(isset($dataAnexo['IdAnexo'])){
        $explode     = explode("-", $dataAnexo['DataInclusao']);
        $anoInclusao = $explode[0];
        $mesInclusao = $explode[1];
    }
    $idEmpresa         = $data['IdEmpresa'];
    $idUsuarioEncripty = encrypt($data['IdUsuario']);
    $idEmpresaEncripty = encrypt($data['IdEmpresa']);
    $prioridade        = $arrayPrioridade[$data['Prioridade']];
    $status            = $arrayStatus[$data['Status']];

    //echo "<script>selectUsuarios('$idEmpresaEncripty', 'filtro', '$idUsuarioEncripty');</script>";
    $linkExibicao = (isset($dataAnexo['IdAnexo']) === true) ? LINKANEXO.$anoInclusao."/".$mesInclusao."/".$dataAnexo['Nome'].".".$dataAnexo['Extensao'] : "false";
    /*
        ORDEM DOS CAMPOS - 
        0 - Assunto 
        1 - Descricao 
        2 - Usuario 
        3 - Empresa 
        4 - Data 
        5 - Hora 
        6 - Prioridade 
        7 - Status 
        8 - LinkAnexo 
        9 - IdChamado criptografado
        */
    $retorno =  $data['Assunto']."|".
                $data['Descricao']."|".
                $data['NomeUsuario']."|".
                $data['NomeEmpresa']."|".
                dataPadrao($data['DataCriacao'])."|".
                horaPadrao($data['HoraCriacao'])."|".
                $prioridade."|".
                $status."|".
                $linkExibicao."|".
                $_GET['IdChamado'];

}

echo $retorno;

?>