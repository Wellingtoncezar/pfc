<?php
/**
 * ARQUIVO DE CONFIGURAÇÕES DO BANCO DE DADOS 
 * @author Wellington cezar - wellington-cezar@hotmail.com
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
$_db = Array();
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

$_db['gerencia'] = array(
					'hostname' 	=> 'localhost',
					'username' 	=> 'gerencia',
					'password' 	=> 'vvCD74vE5sQWvrd6',
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

