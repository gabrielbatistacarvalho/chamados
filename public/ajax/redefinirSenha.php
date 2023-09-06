<?php

include __DIR__."/../../src/functions/includes.php";

$con     = db();

$json = file_get_contents('php://input');

// Decodifica o JSON em um array associativo
$dados     = json_decode($json, true);
$idUsuario = decrypt($dados['idUsuario']);

$sql   = "SELECT * FROM usuario WHERE (IdUsuario = '$idUsuario') AND (Status = 'A') AND (Excluido = 'N')";
$query = $con->query($sql) or die("ERRO SQL: sql busca usuário");
$data  = mysqli_fetch_assoc($query);


$nome               = $data['Nome'];
$email              = $data['Email'];
$password           = genPassword(10);
$passwordCripto     = md5(trim($password));
$sqlRedefineSenha   = "UPDATE usuario SET Password = '$passwordCripto WHERE (IdUsuario = '$idUsuario) AND (Status = 'A') AND (Excluido = 'N')";
$queryRedefineSenha = $con->query($sqlRedefineSenha) or die('ERRO SQL: sqlRedefineSenha');
if($queryRedefineSenha) {
    $array = json_encode(array(
    "username"  => "gabriel.catistacarvalho@gmail.com",
    "password"  => "fxlutpsqkjhddtcz",
    "host"      => "smtp.gmail.com",
    "port"      => "587",
    "nomeRem"   => "CHAMADOS GABRIEL",
    "emailRem"  => "chamadosgabriel@gmail.com",
    "nome"      => $nome,
    "email"     => $email,
    "nomeSite"  => "CHAMADOS GABRIEL",
    "subject"   => "REDEFINIÇÃO DE SENHA",
    "body"      => "<!DOCTYPE html>
                <html>
                
                <head>
                    <meta charset='UTF-8'>
                    <title>Redefinição de senha</title>
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
                            <li>Sua senha para o primeiro acesso é: <b>$password</b>.</li>
                            <li>No primeiro login será solicitada a criação de uma nova senha.</li>
                            <li>Após a criação da nova senha, você poderá acessar sua conta.</li>
                        </ol>
                        <p>Se você não é <b>$nome</b>, por favor ignore este e-mail.</p>
                        <p>Atenciosamente,<br> A Equipe de Suporte do CHAMADOS GABRIEL</p>
                    </div>
                </body>
                </html>"
    ));

    echo $array;
} else {
    echo "error";
}



?>