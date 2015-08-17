<?php
header('Content-Type: text/html; charset=utf-8');
/**
* Arquivo de configuração do sistema
* @author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
* @since 05/03/2015
* @version 2.0
*
*/
require_once(BASEPATH.DIRECTORY_SEPARATOR.'config.php');

define('SYSTEMPATH','system');
define('LIBRARYPATH','library');

foreach ($_config as $key => $value)
{
	$key = strtoupper($key);
	define($key,$value);
}

if( ERRORREPORTING == 'E_ALL')
	error_reporting(E_ALL);
else
	error_reporting(0);