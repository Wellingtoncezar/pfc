<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
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
$_config['dao'] 				= "dao"; //diretório das daos
$_config['UPLOADPATH']			= "skin/uploads"; //diretório dos uploads




//Páginas default
$_config['default_controller'] 	= "gerenciar";
$_config['errordir'] 		= 'errors';

//show message log
$_config['SHOWLOGMESSAGE'] = false;


//url
$_config['url'] 		= 'http://'.$_SERVER['SERVER_NAME'].'/pfc/sac/';

//error reporting	
$_config['errorreporting'] = 'E_ALL';//E_ALL ou 0
	

?>