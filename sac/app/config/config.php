<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
session_start();
/*
ARQUIVO DE CONFIGURAÇÕES DO SISTEMA
*/
$_config = array();


/****DIRETÓRIOS****/
//Diretórios da applicação
$_config['controllers'] 		= "controllers"; //diretório dos controllers
$_config['models'] 				= "models"; //diretório dos models
$_config['views'] 				= "views"; //diretório das views
$_config['UPLOADPATH']			= "skin/uploads"; //diretório dos uploads




//Páginas default
$_config['default_controller'] 	= "home";
$_config['errordir'] 		= 'errors';

//show message log
$_config['SHOWLOGMESSAGE'] = false;


//Banco de dados, url
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.25.32')
{
	//banco de dados
	$_config['hostname'] 	='localhost';
	$_config['username'] 	= 'root';
	$_config['password'] 	= '';
	$_config['dbname'] 		= 'sac';
	$_config['mysqlport'] 	= '3306';

	//url
	$_config['url'] 		= 'http://'.$_SERVER['SERVER_NAME'].'/pfc/sac/';

	//error reporting	
	$_config['errorreporting'] = 'E_ALL';//E_ALL ou 0
}else
{
	
	/*
	//banco de dados
	$_config['hostname'] 	='mysql.webdahora.com.br';
	$_config['username'] 	= 'webdahora';
	$_config['password'] 	= '4321!@#$';
	$_config['dbname'] 		= 'webdahora';
	$_config['mysqlport'] 	= '3306';

	//url
	$_config['url'] 		= 'http://'.$_SERVER['SERVER_NAME'].'/gerenciador_eclesiastico/';

	//error reporting	
	$_config['errorreporting'] = 'E_ALL';//E_ALL ou 0
	*/
}	

?>