<?php 
include '../src/functions/includes.php'; 

?>

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
    <script 
            src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
            crossorigin="anonymous">
    </script>
    <script 
            src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" 
            crossorigin="anonymous">
    </script>
    <script 
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
            crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/jQuery/jquery.js"></script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/toast/sweetalert2.js"></script>
    <script type="text/javascript" src="https://cdn.gabrielcarvalho.site/v1/toast/notifications.js"></script>
    <script type="text/javascript" src="js/functions.js"></script>  

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        } 

        main {
            flex: 1 0 auto;
        }
    </style>

    <link href="/css/custom.css" rel="stylesheet" type="text/css">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
        <div class="container-fluid pe-0">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <? if($_SESSION['senhaPadrao'] === 'N'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">HOME</a>
                        </li>
                        <? if($_SESSION['nivel'] === 'MASTER'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="empresaListar.php">EMPRESAS</a>
                            </li>
                        <? endif;
                            if(($_SESSION['nivel'] === 'MASTER') or ($_SESSION['nivel'] === 'ADMIN')): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="usuarioListar.php">USUÁRIOS</a>
                            </li>
                        <? endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="redefinirSenha.php">REDEFINIR SENHA</a>
                        </li>
                    <? endif; ?>
                </ul>
            </div>

            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fs-3" href="/logout.php" style="width: 70px; text-align: center; padding-left: 20px;">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main>
        <div class="container-fluid">