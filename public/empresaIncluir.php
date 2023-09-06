<?php
include 'header.php'; 

if(($_SESSION['nivel'] === "ADMIN") or ($_SESSION['nivel'] === "COMUM")){
    header("Location: home.php");

    die();
}

$con = db();

if(isset($_POST['btnCadastrar'])){
    $idEmpresa = $_POST['idEmpresa'];
    $nome      = $_POST['nome'];
    $status    = $_POST['status'];
    $telefone  = filterPhone($_POST['telefone']);
    $hoje      = date('Y-m-d');
    $agora     = date('H:i:s');

    $sql = ($_POST['operacao'] === 'I') 
        ? "INSERT INTO empresa (Nome, Telefone, Status, DataCriacao, HoraCriacao) VALUES ('$nome', '$telefone', '$status', '$hoje', '$agora')"
        : "UPDATE empresa SET Nome = '$nome', Telefone = '$telefone', Status = '$status' WHERE (IdEmpresa = '$idEmpresa')";
    
    $insert = $con->query($sql) or die('ERRO SQL: insert');
    if($insert === true)
    {
        header("Location: empresaListar.php");

        die();
    }
    else
    {
        $data = [
            'Nome'     => $nome,
            'Telefone' => $telefone,
            'Status'   => $status 
        ];
    }
}
else if(isset($_GET['IdEmpresa']))
{
    $idEmpresa = decrypt($_GET['IdEmpresa']);
    $sql       = "SELECT * FROM empresa WHERE (IdEmpresa = '$idEmpresa') AND (Excluido = 'N')";
    $data      = mysqli_fetch_assoc($con->query($sql));
}

?>


<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="empresaListar.php">Empresas</a></li>
        <li class="breadcrumb-item active" aria-current="page">Empresa</li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form shadow rounded">
        <div class="card-header text-center">
            <h3><?= (isset($data) === true) ? 'Empresa' : 'Cadastrar nova empresa'; ?></h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="hidden" id="operacao" name="operacao" value="<?= (isset($data) === true) ? 'E' : 'I'; ?>">
                            <input type="hidden" id="idEmpresa" name="idEmpresa" value="<?= (isset($data) === true) ? $idEmpresa : ''; ?>">
                            <input type="text" class="form-control nome" id="nome" name="nome" obrigatorio="true" nome-validar="Nome" placeholder="Nome da empresa" maxlength="55" value="<?= (isset($data) === true) ? $data['Nome'] : ''; ?>">
                            <label for="nome">Nome</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control celullar" id="telefone" name="telefone" obrigatorio="true" nome-validar="telefone" placeholder="telefone" value="<?= (isset($data) === true) ? $data['Telefone'] : ''; ?>">
                            <label for="telefone">Telefone</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="status" name="status" obrigatorio="true" aria-label="Default select example">
                                <option value="A" <?php if((isset($data) === false) or ($data['Status'] === 'A')) echo 'selected'; ?>>Ativa</option>
                                <option value="I" <?php if((isset($data) === true) and ($data['Status'] === 'I')) echo 'selected'; ?>>Inativa</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <a class="btn btn-danger" href="empresaListar.php" role="button">CANCELAR</a>
                    <button id="btnCadastrar" name="btnCadastrar" type="submit" style="width: 120px;" preloader="true" onclick="return validateDataTeste(this);" class="btn btn-primary"><?= (isset($data) === true) ? 'SALVAR' : 'CADASTRAR'; ?></button>
                </div>
            </form> 
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>