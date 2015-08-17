<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class home extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
		//checagem do login
		$login = new loginModel();
		$login->statusLogin();
	}
	
	public function index(){
		$this->saveAction();
		$data = array(
			'titulo' => 'Configurações'
		);

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}
}

/**
*
*class: home
*
*location : models/configuracoes/home.model.php
*/