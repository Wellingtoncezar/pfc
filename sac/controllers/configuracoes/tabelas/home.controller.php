<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class home extends Controller{
	public function __construct(){
		parent::__construct();
	}

	/********************************************/
	/****PÁGINAS****/


	/**
	*Página index
	*/
	public function index(){
		echo 'página de tabelas';
	}
}

/**
*
*class: home
*
*location : controllers/configuracoes/tabelas/home.controller.php
*/

