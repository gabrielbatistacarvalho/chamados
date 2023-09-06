<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <title>Controle de Empresas</title>
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Language" content="pt-br">

    <link href="https://cdn.emersonsilveira.com.br/shared/v1/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.emersonsilveira.com.br/shared/v1/bootstrap/icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.emersonsilveira.com.br/shared/v1/toast/sweetalert2.css" rel="stylesheet" type="text/css">

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
                    <li class="nav-item">
                        <a class="nav-link" href="/home">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/company/list">EMPRESAS</a>
                    </li>
                </ul>
            </div>

            <div>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fs-3" href="/logout" style="width: 70px; text-align: center; padding-left: 20px;">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container-fluid">
            <?php require '../src/views/' . $view . '.php'; ?>
        </div>
    </main>

    <div class="container-fluid">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <div>
                    <span class="text-muted"><b>Usuário:</b> </span>
                    <br>
                    <span class="text-muted">© <?= YEAR; ?> Gabriel Carvalho</span>
                </div>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted fs-4" href="#"><i class="bi bi-instagram"></i></li>
                <li class="ms-3"><a class="text-muted fs-4" href="#"><i class="bi bi-facebook"></i></a></li>
            </ul>
        </footer>
    </div>

    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/jQuery/jquery.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/toast/sweetalert2.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/mask/mask.min.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/mask/maskMoney.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/mask/Masks.js"></script>
    <script type="text/javascript" src="https://cdn.emersonsilveira.com.br/shared/v1/validate/form.js"></script>

    <script>
        var submited = false;
    </script>
    
    <?php if (file_exists('js/' . $view . '.js')) : ?>
        <script type="text/javascript" src="/js/<?= $view; ?>.js"></script>
    <?php endif; ?>

</body>

</html>