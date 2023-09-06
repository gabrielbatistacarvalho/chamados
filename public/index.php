<?php ?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <title>Controle de Empresas</title>
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Language" content="pt-br">

    <link rel="stylesheet" type="text/css" href="https://cdn.gabrielcarvalho.site/v1/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.gabrielcarvalho.site/v1/bootstrap/icons/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.gabrielcarvalho.site/v1/toast/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/jQuery/jquery.js"></script>
    <script type="text/javascript" src="js/selectUsuarios.js"></script>   
    <style>
        body {
            display: flex;
            min-height: 100vh;
        } 

        main {
            flex: 1 0 auto;
        }
    </style>

    <link href="/css/custom.css" rel="stylesheet" type="text/css">

</head>
<?php 
$paglogin = "S";

include '../src/functions/includes.php'; 

$erro = "0";

session_start();

if(isset($_POST['btnAcessar']))
{
    $con      = db();
    $email    = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $sql   = "SELECT * FROM usuario WHERE (Email = '$email') AND (Password = '$password') AND (Excluido = 'N')"; 
    $query = $con->query($sql) or die('ERROR SQL: sql login');
    $data  = mysqli_fetch_assoc($query);
   
	if (mysqli_num_rows($query) > 0)  {
		$_SESSION['login']       = "S";
		$_SESSION['usuario']     = $data['Nome'];
		$_SESSION['idUsuario']   = $data['IdUsuario'];
		$_SESSION['nivel']       = $data['Nivel'];
		$_SESSION['idEmpresa']   = $data['IdEmpresa'];
        $_SESSION['senhaPadrao'] = $data['SenhaPadrao'];
        if($data['SenhaPadrao'] === "S") {
            header('Location: redefinirSenha.php');
        } else {
            header('Location: home.php');
        }
        die();
	} else {
		$erro = "Usuário ou senha incorreto!";
	}
} 
?>
<body class="d-flex align-items-center">

    <div class="container-fluid d-flex justify-content-center">
        <div class="card shadow rounded" style="width: 25rem;">
            <div class="card-header text-center">
                <h2>Login</h2>
            </div>
            <form action="" method="POST" id="form" name="form">
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control email" id="email" name="email" obrigatorio="true" placeholder="Digite seu E-mail" nome-validar="E-mail" value="<?= (isset($_POST['btnAcessar'])) ? $_POST['email'] : ""; ?>">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="password" class="form-control password" id="password" name="password" obrigatorio="true" placeholder="Digite sua senha" nome-validar="Senha" value="<?= (isset($_POST['btnAcessar'])) ? $_POST['password'] : ""; ?>">
                            <label for="password">Senha</label>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button id="btnAcessar" name="btnAcessar" type="submit" class="btn btn-primary" preloader="true" onclick="return validateDataTeste(this);">ACESSAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/toast/sweetalert2.js"></script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/toast/notifications.js"></script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/validate/form.js"></script> 
    <script type="text/javascript" src="js/form.js"></script>     
    <script type="text/javascript" src="js/functions.js"></script>  
    <?= ($erro <> 0) ? "<script>notification('warning','Aviso!', '$erro');</script>" : ""; ?>

    <script>
        var submited = false;
    </script> 
    
</body>

</html>

<?php ?>