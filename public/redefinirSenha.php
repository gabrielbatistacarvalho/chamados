<?php

$path_parts = pathinfo( __FILE__ );
include 'header.php'; 

$con         = db();
$idUsuario   = $_SESSION['idUsuario'];
$senhaPadrao = "";

if(isset($_POST['btnCadastrar'])) {
    if($_SESSION['senhaPadrao'] === "S") {
        $senhaPadrao = ", SenhaPadrao = 'N'";
    }
    $password   = md5(trim($_POST['password']));
    $novaSenha1 = $_POST['newPassword1'];
    $novaSenha2 = md5(trim($_POST['newPassword2']));

    $sql   = "SELECT * FROM usuario WHERE (IdUsuario = '$idUsuario') AND (Password = '$password') AND (Excluido = 'N')"; 
    $query = $con->query($sql) or die('ERROR SQL: sql login');
    if (mysqli_num_rows($query) > 0) {
        $sqlNovaSenha = "UPDATE usuario SET Password = '$novaSenha2' $senhaPadrao WHERE (IdUsuario = '$idUsuario') AND (Excluido = 'N')"; 
        $updateNovaSenha = $con->query($sqlNovaSenha) or die('ERRO SQL: updateNovaSenha');
        if($updateNovaSenha === true) {
            echo "<script>Swal.fire('Sucesso!', 'Sua senha foi alterada!', 'success');</script>";
            echo "<script>setTimeout(function() {
                                                    window.location.href = '/home.php';
                                                }, 2000);</script>";
            if($_SESSION['senhaPadrao'] === "S") $_SESSION['senhaPadrao'] = "N";
        } else {
            echo "<script>notification('error', 'Não foi possível alterar sua senha.<BR> tente novamente.', 'Erro!')</script>";
        }
    } else {
        echo "<script>notification('error', 'Não foi possível alterar sua senha.<BR> tente novamente.', 'Erro!');</script>";
    }
} 

?>
<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <? if($_SESSION['senhaPadrao'] === 'N'): ?>
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
        <? endif; ?>
        <li class="breadcrumb-item active" aria-current="page">Redefinir senha</li>
    </ol>
</nav>

<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card width-form shadow rounded">
        <div class="card-header text-center">
            <h3>Cadastrar nova senha</h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" id="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control password" id="password" name="password" obrigatorio="true" placeholder="Digite sua senha" nome-validar="Senha atual" value="<?= (isset($_POST['btnAcessar'])) ? $_POST['password'] : ""; ?>">
                            <label for="password">Senha atual</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-12">
                        <p class="ls-help-inline"><small>A nova senha deve conter: 1 Letra maiúscula <strong>[A-Z],</strong> 1 letra minúscula <strong>[a-z],</strong> 1 número <strong>[0-9]</strong> e entre <strong>8</strong> e <strong>16</strong> caracteres.</small></p>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control newPassword1" id="newPassword1'" name="newPassword1" obrigatorio="true" placeholder="Digite sua senha" nome-validar="Nova senha" value="<?= (isset($_POST['btnAcessar'])) ? $_POST['password'] : ""; ?>">
                            <label for="newPassword1">Nova senha</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control newPassword2" id="newPassword2" name="newPassword2" obrigatorio="true" placeholder="Digite sua senha" nome-validar="Confirmação da nova senha" value="<?= (isset($_POST['btnAcessar'])) ? $_POST['password'] : ""; ?>">
                            <label for="newPassword2">Confirmação da nova senha</label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <? if($_SESSION['senhaPadrao'] === "N"): ?>
                        <a class="btn btn-danger" href="home.php" role="button">CANCELAR</a>
                    <? endif; ?>
                    <button id="btnCadastrar" name="btnCadastrar" type="submit" style="width: 120px;" preloader="true" onclick="return validateDataTeste(this);" class="btn btn-primary"><?= (isset($data) === true) ? 'SALVAR' : 'CADASTRAR'; ?></button>
                </div>
            </form> 
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>