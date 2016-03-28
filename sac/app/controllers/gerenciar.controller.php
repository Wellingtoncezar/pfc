<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
		//$this->load->dao('loginDao');
		//$this->loginDao->statusLogin();

	}


	/********************************************/
	/****PÁGINAS****/
	

	/**
	*Página index
	*/

	public function index()
	{
		// print_r($_SESSION['user']);
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		$this->checkPermissao->check();

		$data = array(
			'titlePage' => ''
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('home',$data);
		$this->load->view('includes/footer',$data);
	}
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
