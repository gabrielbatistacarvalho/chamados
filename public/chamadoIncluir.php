<?php
include 'header.php'; 

$con             = db();
$mes             = date('m');
$extensoes       = ['jpg', 'jpeg', 'giff', 'png', 'tiff', 'svg'];
$stringExtensoes = implode(",", $extensoes);
$charExtensoes   = " Extensões permitidas: ";
$prioridadeValor = ['CRI', 'ALT', 'MED', 'BAI', 'NEM'];
$prioridadeNome  = ['CRÍTICO', 'ALTA', 'MÉDIA', 'BAIXA', 'NEMHUMA'];
$prioridadeCount = count($prioridadeValor);
$status          = "AGU";
$statusValor     = ['AGU', 'INI', 'PRO', 'FIN', 'CAN'];
$statusNome      = ['AGUARDANDO', 'INICIADO', 'PRONTO', 'FINALIZADO', 'CANCELADO'];
$statusCount     = count($statusValor);
$origem          = "home.php";
$operacao        = "I";

foreach($extensoes as $teste) {
    $charExtensoes .= "'.".$teste."', ";
}

if(isset($_GET['IdChamado'])) {
    $getIdChamado = decrypt($_GET['IdChamado']);
    $operacao     = "E"; 
    $sql = "SELECT a.*, b.Nome AS NomeEmpresa
            FROM chamado       AS a 
            INNER JOIN empresa AS b ON(a.IdEmpresa = b.IdEmpresa)
            WHERE (a.IdChamado = '$getIdChamado')
            AND   (a.Excluido  = 'N')
            AND   (b.Excluido  = 'N')";
    
    $query      = $con->query($sql) or die('ERRO SQL: chamado '.$sql);
    $data       = mysqli_fetch_assoc($query);
    
    $sqlAnexo   = "SELECT * FROM anexo WHERE (IdChamado = '$getIdChamado') AND (Excluido = 'N')";
    $queryAnexo = $con->query($sqlAnexo) or die('ERRO SQL: anexo '.$sqlAnexo);
    $dataAnexo  = mysqli_fetch_assoc($queryAnexo);

    if(isset($dataAnexo['IdAnexo'])) {
        $explode = explode("-", $dataAnexo['DataInclusao']);
        $anoInclusao = $explode[0];
        $mesInclusao = $explode[1];
    }
    $idEmpresa         = $data['IdEmpresa'];
    $idUsuarioEncripty = encrypt($data['IdUsuario']);
    $idEmpresaEncripty = encrypt($data['IdEmpresa']);
    if(($_SESSION['nivel'] === "MASTER") or ($_SESSION['nivel'] === "ADMIN")) {
        echo "<script>selectUsuarios('$idEmpresaEncripty', 'filtro', '$idUsuarioEncripty');</script>";
    }
    $linkExibicao = (isset($dataAnexo['IdAnexo']) === true) ? LINKANEXO.$anoInclusao."/".$mesInclusao."/".$dataAnexo['Nome'].".".$dataAnexo['Extensao'] : "";
}
else if(isset($_GET['IdEmpresa'])) {
    $getIdEmpresa      = decrypt($_GET['IdEmpresa']);
    $idEmpresaEncripty = $_GET['IdEmpresa'];
    $origem            = "empresaListar.php?&IdEmpresa=".$_GET['IdEmpresa'];
    $sql               = "SELECT *, Nome AS NomeEmpresa FROM empresa WHERE (IdEmpresa = '$getIdEmpresa') AND (Excluido = 'N')";
    
    $data = mysqli_fetch_assoc($con->query($sql)) or die('ERRO SQL: empresa '.$sql);
    $data['Prioridade'] = "";
    echo "<script>selectUsuarios('$idEmpresaEncripty', 'filtro');</script>";
} else {    
    $data['IdEmpresa']  = "";
    $data['Prioridade'] = "";
    $data['Status']     = "";
    $sql = "SELECT a.* 
            FROM empresa AS a 
            INNER JOIN usuario AS b ON(a.IdEmpresa = b.IdEmpresa)
            WHERE (a.Status   = 'A')
            AND   (a.Excluido = 'N')
            AND   (b.Status   = 'A')
            AND   (b.Excluido = 'N')
            GROUP BY a.IdEmpresa";
    
    $queryEmpresa = $con->query($sql) or die('ERRO SQL: empresa '.$sql);
}


if(isset($_POST['btnCadastrar'])) {
    
    $assunto    = $_POST['assunto'];
    $conteudo   = $_POST['conteudo'];
    $empresa    = decrypt($_POST['empresa']);
    $idUsuario  = decrypt($_POST['usuario']);
    $prioridade = $_POST['prioridade'];
    $status     = $_POST['status'];
    $hoje       = date('Y-m-d');
    $agora      = date('H:i:s');

    if(isset($_GET['IdChamado'])) {
        $idChamado  = decrypt($_GET['IdChamado']);
        $sqlChamado =   "UPDATE chamado 
                         SET Assunto    = '$assunto', 
                             Descricao  = '$conteudo', 
                             Prioridade = '$prioridade', 
                             Status     = '$status', 
                             IdEmpresa  = '$empresa', 
                             IdUsuario  = '$idUsuario'  
                         WHERE (IdChamado = '$idChamado')
                         AND   (Excluido  = 'N')";
        $insertChamado = $con->query($sqlChamado) or die('ERRO SQL: insert '.$sqlChamado);
    } else {
        $sqlChamado =  "INSERT INTO chamado (
                                             Assunto, 
                                             Descricao, 
                                             Prioridade, 
                                             Status,
                                             IdEmpresa, 
                                             IdUsuario, 
                                             DataCriacao, 
                                             HoraCriacao
                                            ) VALUES (
                                             '$assunto',
                                             '$conteudo',
                                             '$prioridade',
                                             '$status',
                                             '$empresa',
                                             '$idUsuario',
                                             '$hoje',
                                             '$agora'
                                            )";
        $insertChamado = $con->query($sqlChamado) or die('ERRO SQL: insert '.$sqlChamado);
        $idChamado     = $con->insert_id; 
    }

    if(isset($_FILES['foto']) and ($_FILES['foto']['error'] === 0)) {    
        $name     = $_FILES['foto']['name'];
        $file     = base64_encode($_FILES['foto']['tmp_name']);
        $explode  = explode(".", $name);
        $extensao = $explode[1];
        $link     = "anexos/".YEAR."/".$mes;
        $newName  = randomCode();
        $sqlAnexo = "INSERT INTO anexo(IdChamado, Nome, Extensao, DataInclusao, HoraInclusao, UsuarioInclusao) 
                     VALUES ('$idChamado','$newName','$extensao','$hoje','$agora',$idUsuario)";

        if(in_array($extensao, $extensoes)) {
                
            if(!file_exists($link)){
                
                $status = (mkdir($link, 0766, true)) ? "OK" : "ERROR";
                    
            }

            if( move_uploaded_file($_FILES["foto"]["tmp_name"], $link.'/'.$newName.'.'.$extensao)) {
                $insertAnexo = $con->query($sqlAnexo) or die('ERRO SQL: insert '.$sqlAnexo);
            }
        }
        if(($insertChamado === true) and ($insertAnexo === true)) {
            header("Location: home.php");

            die();
        }
    } else {
        header("Location: home.php");

        die();
    }
} else if(isset($_GET['IdUsuario'])) {
    $idUsuario     = decrypt($_GET['IdUsuario']);
    $sqlUsuario    = "SELECT * FROM usuario WHERE (IdUsuario = '$idUsuario') AND (Excluido = 'N')";
    $data          = mysqli_fetch_assoc($con->query($sqlUsuario));
    $getIdEmpresa  = $data['IdEmpresa'];
    $filtroEmpresa = "(IdEmpresa = '".$data['IdEmpresa']."') AND";
}

$sqlEmpresa = "SELECT * FROM empresa WHERE (Excluido = 'N')"; 
$company    = $con->query($sqlEmpresa);
$numCompany = mysqli_num_rows($company);

?>


<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chamado</li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form shadow rounded">
        <div class="card-header text-center">
            <h3><?= (isset($data) === true) ? 'Editar chamado' : 'Cadastrar novo chamado'; ?></h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="form" name="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="hidden" id="operacao" name="operacao" value="<?= (isset($data['IdChamado']) === true) ? 'E' : 'I'; ?>">
                            <input type="text" class="form-control nome" data-ls-module="charCounter" maxlength="50" id="assunto" name="assunto" obrigatorio="true" nome-validar="Assunto" placeholder="Assunto" maxlength="50" value="<?= (isset($data['Assunto']) === true) ? $data['Assunto'] : ''; ?>">
                            <label for="assunto">Assunto</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <textarea class="form-control nome" data-ls-module="charCounter" id="conteudo" name="conteudo" style="height: 130px; resize: none;" maxlength="550" placeholder="Módulo afetado"><?= (isset($data['Descricao']) === true) ? $data['Descricao'] : ''; ?></textarea>
                            <label for="conteudo">Descrição</label>
                        </div>
                    </div>
                </div>
                <? if($_SESSION['nivel'] === "MASTER"): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <select class="form-select empresaSelect" id="empresa" name="empresa" obrigatorio="true" onchange="selectUsuarios(this)" required>
                                    <? if(!isset($_GET['IdEmpresa']) and !isset($_GET['IdChamado'])): ?>
                                        <option value="T" >SELECIONE...</option>
                                        <? while($dadosEmpresa = mysqli_fetch_assoc($queryEmpresa)): ?>
                                            <option value="<?= encrypt($dadosEmpresa['IdEmpresa']); ?>" <?= ($dadosEmpresa['IdEmpresa'] == $data['IdEmpresa']) ? "selected" : ""; ?> ><?= $dadosEmpresa['Nome']; ?></option>
                                        <? endwhile ?>
                                    <? else: ?>  
                                        <option value="<?= encrypt($data['IdEmpresa']); ?>" ><?= $data['NomeEmpresa']; ?></option>
                                    <? endif ?>
                                    </select>
                                <label for="empresa">Empresa</label>                        
                            </div>
                        </div>
                    </div> 
                <? else: ?>                             
                    <input type="hidden" id="empresa" name="empresa" value="<?= encrypt($_SESSION['idEmpresa']); ?>">
                <? endif ?>
                
                <? if(($_SESSION['nivel'] === "MASTER") or ($_SESSION['nivel'] === "ADMIN")): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <select class="form-select selectUsuario" id="usuario" name="usuario" obrigatorio="true" <?= ($_SESSION['nivel'] === "MASTER") ? 'style="display: none;" disabled' : '' ; ?>>
                                </select>  
                                <?= (($_SESSION['nivel'] === "ADMIN") and ($operacao === "I")) ? "<script>selectUsuarios('".encrypt($_SESSION['idEmpresa'])."', 'ID');</script>" : ''; ?>  
                                <label for="prioridade" id="labelUsuario" style="display: none;">Funcionário</label>                              
                            </div>
                        </div>
                    </div>
                <? else: ?>                             
                    <input type="hidden" id="usuario" name="usuario" value="<?= encrypt($_SESSION['idUsuario']); ?>">
                <? endif ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <select class="form-select selectPrioridade" id="prioridade" name="prioridade" obrigatorio="true">
                                <option value="T" >SELECIONE...</option>
                                <? for($i = 0; $i < $prioridadeCount; $i++): ?>
                                    <option value="<?= $prioridadeValor[$i]; ?>" <?= ($prioridadeValor[$i] == $data['Prioridade']) ? "selected" : ""; ?> ><?= $prioridadeNome[$i]; ?></option>
                                <? endfor ?>
                            </select>    
                            <label for="prioridade">Prioridade</label>                        
                        </div>
                    </div>
                </div>
                <? if($_SESSION['nivel'] === "MASTER"): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="status" name="status" obrigatorio="true">
                                    <? for($j = 0; $j < $statusCount; $j++): ?>
                                        <option value="<?= $statusValor[$j]; ?>" <?= ($statusValor[$j] == $data['Status']) ? "selected" : ""; ?> ><?= $statusNome[$j]; ?></option>
                                    <? endfor ?>
                                </select>    
                                <label for="status">Status</label>                        
                            </div>
                        </div>
                    </div>
                <? endif ?>
                <? if(!isset($dataAnexo['IdAnexo'])): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">                      
                            <input type="hidden" class="extensoes" id="extensoes" name="extensoes" value="<?= $stringExtensoes; ?>">
                            <input type="file" class="form-control extensao" id="foto" name="foto" onchange="verificaArquivo(this, '<?= $operacao; ?>')">
                        </div>
                        <div class="input-group mb-3">
                            <b class="ls-label-text"><?= $charExtensoes; ?></b> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group mb-3">                      
                            <img src="" alt="" style="width: 192px; height: 108px; display: none;" id="preview-image">
                        </div>
                    </div>
                </div>
                <? else: ?>
                <div class="row">
                    <div class="col-lg-12">                    
                        <button type="button" style="border: none; padding: 0" onclick="exibeImagem('<?= $linkExibicao ?>')">
                            <img src="<?= $linkExibicao ?>" alt="" style="width: 192px; height: 108px;" id="preview-image">
                        </button>
                    </div>
                    <div class="col-lg-12">
                        <button id="excluirAnexo" name="excluirAnexo" type="button" style="width: 192px;" preloader="true" onclick="return deleteAnexo('<?= encrypt($dataAnexo['IdAnexo']) ?>', '<?= encrypt($_SESSION['idUsuario']) ?>');" class="btn btn-danger"><?= "EXCLUIR" ?></button>
                    </div>
                </div>
                <? endif ?>
                <div class="text-end">
                    <a class="btn btn-danger" href="<?= $origem; ?>" role="button">CANCELAR</a>
                    <button id="btnCadastrar" name="btnCadastrar" type="submit" style="width: 120px;" preloader="true" onclick="return validateDataTeste(this);" class="btn btn-primary"><?= (isset($data) === true) ? 'SALVAR' : 'CADASTRAR'; ?></button>
                </div>
            </form> 
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
