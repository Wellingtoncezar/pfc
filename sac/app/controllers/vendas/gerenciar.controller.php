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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		$data = array(
			'titlePage' => 'Vendas'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('vendas/home',$data);
		$this->load->view('includes/footer',$data);
	}

	
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
