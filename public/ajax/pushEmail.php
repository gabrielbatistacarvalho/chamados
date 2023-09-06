<?php 
// Importar as classes 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// Carregar o autoloader do composer  
require '../vendor/autoload.php';
require_once "/www/wwwroot/chamados.gabrielcarvalho.site/src/functions/includes.php";

//if(isset($_GET['EmailEnviar']) === true) {
//}
function pushEmail()
{
    $body = 
    '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Recuperação de Senha</title>
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
        <div class="container">
            <h1>Recuperação de Senha</h1>
            <p>Olá [Nome do Usuário],</p>
            
            <p>Recebemos uma solicitação para recuperação de senha da sua conta em [Nome do Site]. Para criar uma nova senha e acessar sua conta, siga as etapas abaixo:</p>
            
            <ol>
                <li>Clique no botão abaixo para redefinir sua senha:</li>
            </ol>
            
            <p>
                <a href="https://chamados.gabrielcarvalho.site/teste.php" class="btn">Redefinir Senha</a>
            </p>
            
            <ol start="2">
                <li>Siga as instruções na página para criar uma nova senha.</li>
                <li>Após redefinir sua senha, você poderá acessar sua conta com as novas credenciais.</li>
            </ol>
            
            <p>Se você não solicitou a recuperação de senha, por favor ignore este e-mail. A segurança da sua conta é importante para nós.</p>
            
            <p>Atenciosamente,<br>
            A Equipe de Suporte do [Nome do Site]</p>
        </div>
    </body>
    </html>
    ';
    $mail             = new PHPMailer;
    $mail->isSMTP();
    $mail->CharSet    = 'UTF-8';
    $mail->SMTPDebug  = 2;
    $mail->Host       = 'smtp.gmail.com';
    $mail->Port       = 587;
    $mail->SMTPAuth   = true;
    $mail->Username   = 'gabriel.catistacarvalho@gmail.com';
    $mail->Password   = 'fxlutpsqkjhddtcz';
    $mail->SMTPSecure = 'tls';
    $mail->setFrom('gabriel.catistacarvalho@gmail.com', 'Gabriel');
    $mail->addReplyTo('gabriel.catistacarvalho@gmail.com', 'Gabriel');
    $mail->addAddress('gabriel_carvalho26@hotmail.com', 'Gabriel Carvalho');
    $mail->Subject    = 'Assunto';
    $mail->Body       = $body;
    $mail->AltBody    = 'Este é o cortpo da mensagem para clientes de e-mail que não reconhecem HTML';
    //$mail->addAttachment('test.txt');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
}
?>