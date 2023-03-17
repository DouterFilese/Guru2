<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

require( 'head.php');
require( 'head_bots.php');


	
if ($_GET['o']!=''){
	define('SITE_'.$_GET['o'],50);
	require( 'functions/'.$_GET['o'].'.php'); 
} else {
	echo 'Definir organizador com GET o=';
}


?>
