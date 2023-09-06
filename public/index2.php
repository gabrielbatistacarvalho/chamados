<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <title>Controle de Empresas</title>
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Language" content="pt-br">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

    <style>
        body {
            min-height: 100vh;
        }
    </style>

    <link href="/cdn/custom/css/custom.css" rel="stylesheet" type="text/css">

</head>

<body class="d-flex align-items-center">

    <div class="container-fluid d-flex justify-content-center">
        <div class="card" style="width: 25rem;">
            <div class="card-header text-center">
                <h2>Login</h2>
            </div>
            <form id="formLogin" name="formLogin" action="/login/auth" method="post" autocomplete="off">
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu E-mail">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-group">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Digite sua senha">
                            <label for="password">Senha</label>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <button id="btnAcessar" name="btnAcessar" type="submit" class="btn btn-primary">ACESSAR</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
        crossorigin="anonymous"></script>
    
</body>

</html>

<?php ?>