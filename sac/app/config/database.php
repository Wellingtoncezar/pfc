<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
/*
ARQUIVO DE CONFIGURAÇÕES DO BANCO DE DADOS
*/
$_db = array();

$_db['default'] = array(
	'hostname' 	=> 'localhost',
	'username' 	=> 'root',
	'password' 	=> '',
	'dbname'   	=> 'sac',
	'mysqlport'	=> '3306'
);

$_db['userlogin'] = array(
	'hostname' 	=> 'localhost',
	'username' 	=> 'userlogin',
	'password' 	=> 'vvCD74vE5sQWvrd6',
	'dbname'   	=> 'sac',
	'mysqlport'	=> '3306'
);

$_db['gerente'] = array(
	'hostname' 	=> 'localhost',
	'username' 	=> 'gerente',
	'password' 	=> '',
	'dbname'   	=> 'sac',
	'mysqlport'	=> '3306'
);


$_db['funcionarios'] = array(
	'hostname' 	=> 'localhost',
	'username' 	=> 'funcionarios',
	'password' 	=> '7mbt7Uquz8CYfHNf',
	'dbname'   	=> 'sac',
	'mysqlport'	=> '3306'
);