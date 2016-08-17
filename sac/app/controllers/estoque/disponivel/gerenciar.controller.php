<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/*---------------------------
	- PÁGINAS
	=============================*/


	/**
	*Página index
	*/
	public function index()
	{
		echo 'teste';
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/lotes/home',$data);
		$this->load->view('includes/footer',$data);
	}

	
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/