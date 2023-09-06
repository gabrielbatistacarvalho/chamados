<?php

//echo $_SESSION['login']. " - ".$_SESSION['usuario'];
// Verifica se existe algum problema no login
if (($_SESSION['login'] != "S")) {	
// Redireciona para a tela de login
	header('Location: index.php');
} 
$arquivo = explode(".", $path_parts['basename']) ;
if (($_SESSION['senhaPadrao'] != "N") and ($arquivo[0] != "redefinirSenha")) {
// Redireciona para a tela de login
	header('Location: index.php');
}
   
?>