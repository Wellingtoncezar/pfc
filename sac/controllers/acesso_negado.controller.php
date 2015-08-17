<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class acesso_negado extends Controller{
	public function __construct(){
		echo '<p>Acesso negado</p>';
	}
	public function index(){
		echo '<p>Erro Indefinido</p>';
	}
}

/**
*
*class: acessi_negado
*
*location : controllers/acesso_negado.controller.php
*/