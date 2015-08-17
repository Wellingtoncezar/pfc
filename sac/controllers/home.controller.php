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


	/********************************************/
	/****PÁGINAS****/
	

	/**
	*Página index
	*/
	public function index()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Gerenciador Eclesiastico',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja = $igreja->getPrimeiraIgreja();
		$data['igreja'] = $igreja;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('home',$data);
		$this->loadView('includes/baseBottom',$data);
	}
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
