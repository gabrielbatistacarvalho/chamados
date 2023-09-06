<?php
include 'header.php'; 

if($_SESSION['nivel'] === "COMUM"){
    header("Location: home.php");

    die();
}

$con = db();

if(isset($_GET['IdEmpresa'])){
    $getIdEmpresa  = decrypt($_GET['IdEmpresa']);
    $origem        = "?&IdEmpresa=".$_GET['IdEmpresa'];
    $filtroEmpresa = "(IdEmpresa = '".decrypt($_GET['IdEmpresa'])."') AND";
}
else
{
    $getIdEmpresa  = "";
    $origem        = "";
    $filtroEmpresa = "";
}

if(isset($_POST['btnCadastrar'])){
    $idUsuario    = $_POST['idUsuario'];
    $nome         = $_POST['nome'];
    $email        = $_POST['email'];
    $telefone     = filterPhone($_POST['telefone']);
    $status       = $_POST['status'];
    $nivel        = $_POST['nivel'];
    $idEmpresa    = $_POST['idEmpresa'];
    $hoje         = date('Y-m-d');
    $agora        = date('H:i:s');
    $senha        = genPassword(10);
    $senhaEncrypt = encrypt($senha);

    $sql = ($_POST['operacao'] === 'I') 
        ? "INSERT INTO usuario (Nome, Email, Password, Telefone, Status, nivel, IdEmpresa, DataCriacao, HoraCriacao) VALUES ('$nome', '$email', '$senhaEncrypt', '$telefone', '$status', '$nivel', '$idEmpresa', '$hoje', '$agora')"
        : "UPDATE usuario SET Nome = '$nome', Email = '$email', Telefone = '$telefone', Status = '$status', Nivel = '$nivel', IdEmpresa = '$idEmpresa' WHERE (IdUsuario = '$idUsuario')";
    
    $insert = $con->query($sql) or die('ERRO SQL: '.$sql);
    if($insert === true) {
        if($_POST['operacao'] === 'I') {
            $username = "gabriel.catistacarvalho@gmail.com";
            $password = "fxlutpsqkjhddtcz";
            $host = "smtp.gmail.com";
            $port = "587";
            $nomeRem = "CHAMADOS GABRIEL";
            $emailRem = "chamadosgabriel@gmail.com";
            //$nome = "GABRIEL CARVALHO";
            //$email = "gabriel_carvalho26@hotmail.com";
            $nomeSite = "CHAMADOS GABRIEL";
            $subject = "CRIAÇÃO DE USUÁRIO";
            $body = "<!DOCTYPE html>
            <html>
            
            <head>
                <meta charset='UTF-8'>
                <title>Criação de usuário</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }
            
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 5px;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    }
            
                    h1 {
                        color: #007bff;
                    }
            
                    p {
                        font-size: 16px;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
            
                    .btn {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        text-decoration: none;
                        border-radius: 5px;
                        transition: background-color 0.3s;
                    }
            
                    .btn:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            
            <body>
                <div class='container'>
                    <h1>Criação de conta</h1>
                    <p>Olá <b>$nome</b>,</p>
                    <p>Sua conta em <b>CHAMADOS GABRIEL</b> foi crada com sucesso. Para o primeiro acesso
                        em sua conta, siga as etapas abaixo:</p>
                    <ol>
                        <li>Clique no botão abaixo para acessar o sistema:</li>
                    </ol>
                    <p><a href='https://chamados.gabrielcarvalho.site/' class='btn'>Acessar sistema</a> </p>
                    <ol start='2'>
                        <li>Você utilizará este e-mail cadastrado para acesso ao sistema: <b>$email</b>.</li>
                        <li>Sua senha para o primeiro acesso é: <b>$senha</b>.</li>
                        <li>No primeiro login será solicitada a criação de uma nova senha.</li>
                        <li>Após a criação da nova senha, você poderá acessar sua conta.</li>
                    </ol>
                    <p>Se você não é <b>$nome</b>, por favor ignore este e-mail.</p>
                    <p>Atenciosamente,<br> A Equipe de Suporte do CHAMADOS GABRIEL</p>
                </div>
            </body>
            </html>";
            $dados = json_encode(array(
                "Username" => $username,
                "Password" => $password,
                "Host"     => $host,
                "Port"     => $port,
                "NomeRem"  => $nomeRem,
                "EmailRem" => $emailRem,
                "Nome"     => $nome,
                "Email"    => $email,
                "NomeSite" => $nomeSite,
                "Subject"  => $subject,
                "Body"     => $body
            ));

            echo "<script> pushEmail($dados);</script>";
        }
        echo "<script> window.location.href = 'usuarioListar.php$origem';</script>";

        die();
    }
    else
    {
        $data = [
            'Nome'      => $nome,
            'Telefone'  => $telefone,
            'Email'     => $email,
            'Status'    => $status,
            'Nivel'     => $nivel,
            'IdEmpresa' => $idEmpresa 
        ];
    }
}
else if(isset($_GET['IdUsuario']))
{
    $idUsuario     = decrypt($_GET['IdUsuario']);
    $sqlUsuario    = "SELECT * FROM usuario WHERE (IdUsuario = '$idUsuario') AND (Excluido = 'N')"; 
    $data          = mysqli_fetch_assoc($con->query($sqlUsuario));
    $getIdEmpresa  = $data['IdEmpresa'];
    $filtroEmpresa = "(IdEmpresa = '".$data['IdEmpresa']."') AND";
    $senhaPadrao   = $data['SenhaPadrao'];
}

$sqlEmpresa = "SELECT * FROM empresa WHERE $filtroEmpresa (Excluido = 'N')"; 
$company    = $con->query($sqlEmpresa);
$numCompany = mysqli_num_rows($company);

?>


<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="usuarioListar.php">Usuários</a></li>
        <li class="breadcrumb-item active" aria-current="page">Usuário</li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form shadow rounded">
        <div class="card-header text-center">
            <h3><?= (isset($data) === true) ? 'Usuário' : 'Cadastrar novo usuario'; ?></h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="hidden" id="operacao" name="operacao" value="<?= (isset($data) === true) ? 'E' : 'I'; ?>">
                            <input type="hidden" id="idUsuario" name="idUsuario" value="<?= (isset($data) === true) ? $idUsuario : ''; ?>">
                            <input type="text" class="form-control nome" id="nome" name="nome" obrigatorio="true" nome-validar="Nome" placeholder="Nome do usuário" maxlength="55" value="<?= (isset($data) === true) ? $data['Nome'] : ''; ?>">
                            <label for="nome">Nome</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control email" id="email" name="email" obrigatorio="true" nome-validar="email" placeholder="email" value="<?= (isset($data) === true) ? $data['Email'] : ''; ?>">
                            <label for="email">Email </label>
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
                            <select class="form-select" id="nivel" name="nivel" obrigatorio="true" aria-label="Default select example">
                                <option value="COMUM" <? if(((isset($data) === true) and ($data['Nivel'] === 'COMUM')) or (isset($data) === false)) echo 'selected'; ?>>COMUM</option>
                                <option value="ADMIN" <? if((isset($data) === true) and ($data['Nivel'] === 'ADMIN')) echo 'selected'; ?>>ADMINISTRADOR</option>
                                <? if($_SESSION['nivel'] === "MASTER"): ?>
                                    <option value="MASTER" <? if((isset($data) === true) and ($data['Nivel'] === 'MASTER')) echo 'selected'; ?> >MASTER</option>
                                <? endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-floating mb-3">
                            <select class="form-select nome" id="idEmpresa" name="idEmpresa" obrigatorio="true" aria-label="Default select example">
                                <? if($numCompany > 1): ?>
                                    <option value="T" <?= (isset($_GET['IdEmpresa']) === true) ? '' : 'selected'; ?> >Selecione...</option>
                                <? endif;
                                   while($empresa = mysqli_fetch_assoc($company)): ?>
                                    <option value="<?= $empresa['IdEmpresa']; ?>" <?= ($getIdEmpresa === $empresa['IdEmpresa']) ? 'selected' : ''; ?>><?= $empresa['Nome']; ?></option>
                                <? endwhile ?>
                            </select>
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
                <div class="row">
                    <? if((isset($data) === true) and ($data['Status'] === "A")): ?>
                        <div class="col-md-6 col-lg-6" id="divResetarSenha" <?= ($senhaPadrao === "N") ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                            <button type="button" class="btn btn-secondary white-text" style="width: 150px; color: #FFF" id="alterarSenha" name="alterarSenha" onclick="redefinirSenha('<?= encrypt($idUsuario); ?>');">RESETAR SENHA</button>
                        </div>
                        <div class="col-md-6 col-lg-6" id="divSenhaPadrao" <?= ($senhaPadrao === "S") ? 'style="display: block;"' : 'style="display: none;"'; ?>>
                            <button type="button" class="form-control" style="width: 150px; border: none; background-color: #FFF; text-align:left;" disabled>Senha padrão</button>
                        </div>
                    <div class="col-md-6 col-lg-6 text-end">
                    <? else: ?>
                    <div class="col-md-12 col-lg-12 text-end">
                    <? endif; ?>
                        <a class="btn btn-danger" href="usuarioListar.php<?= $origem; ?>" role="button">CANCELAR</a>
                        <button id="btnCadastrar" name="btnCadastrar" type="submit" style="width: 120px;" preloader="true" onclick="return validateDataTeste(this);" class="btn btn-primary"><?= (isset($data) === true) ? 'SALVAR' : 'CADASTRAR'; ?></button>
                    </div>
                </div>
            </form> 
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>