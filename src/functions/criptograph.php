<?php

$key           = '';
$iv            = '';
$encryptMethod = '';

function setSecurity() 
{
    global $key, $iv, $encryptMethod;
    $key = hash('sha256', SECRET_KEY);
    $iv  = substr(hash('sha256', SECRET_IV), 0, 16);
    $encryptMethod = ENCRYPT_METHOD;
}

function encrypt(string $text): string
{
    global $key, $iv, $encryptMethod;
    setSecurity();

    $output = openssl_encrypt($text, $encryptMethod, $key, 0, $iv);
    $output = base64_encode($output);

    return $output;
}

function decrypt(string $text): string
{
    global $key, $iv, $encryptMethod;
    setSecurity();
    
    $output = openssl_decrypt(base64_decode($text), $encryptMethod, $key, 0, $iv);
    return $output;
}

?>