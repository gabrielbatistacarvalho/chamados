<?php

session_start();

include_once __DIR__.'/config.php'; 
include_once __DIR__.'/functions.php';
include_once __DIR__.'/DB.php';
include_once __DIR__.'/filters.php';
include_once __DIR__.'/masks.php';
include_once __DIR__.'/criptograph.php';
include_once __DIR__.'/password.php';
if(!(isset($path_parts))) {
    $path_parts = pathinfo( __FILE__ ); 
}
if(!isset($paglogin))
{
    include __DIR__.'/access.php';
}


?>
