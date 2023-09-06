<?php

function randomCode($length = 7) {  
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
    $charactersLength = strlen($characters);  
    $randomString = '';  
    for ($i = 0; $i < $length; $i++) {  
        $randomString .= $characters[rand(0, $charactersLength - 1)];  
    }  
    return $randomString;  
}  

function dataBanco($data)
{
    return implode('-', array_reverse(explode('/', $data)));
}

function dataPadrao($data)
{
    return implode('/', array_reverse(explode('-', $data)));
}

function horaPadrao($hora)
{
    $explode = explode(":", $hora);
    return $explode[0].":".$explode[1];
}

function enviaEmail()
{
    include '/www/wwwroot/chamados.gabrielcarvalho.site/public/ajax/pushEmail.php';

    pushEmail();
}
?>