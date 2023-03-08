<?php

echo 'oi'; exit;

define('CADASTRO_MAX_SEGUNDOS', '20'); // Tempo máximo nas rotinas de cadastro de leilões

//error_reporting(0);//desabilitar warning
//require_once "simple_html_dom.php";
require_once "funcoes_apoio.php";
require_once "gurulimpeza.php";

define('SITE_'.$_GET['o'],50);

if ($_GET['o']!=''){
	require( $_GET['o'].'.php'); 
} else {
	echo 'Definir organizador com GET o=';
}

?>

