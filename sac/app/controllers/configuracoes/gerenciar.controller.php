<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class gerenciar extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
		//checagem do login
		// $this->load->dao('loginDao');
		// $login = new loginDao();
		// $login->statusLogin();
	}
	
	public function index(){
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		
		$data = array(
			'titulo' => 'Configurações'
		);

		//carregamento da tela
		//$this->loadView('includes/baseTop',$data);
		$this->load->view('configuracoes/home',$data);
		//$this->loadView('includes/baseBottom',$data);
	}
}

/**
*
*class: home
*
*location : models/configuracoes/home.model.php
*/