<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
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
		//$this->saveModules();
		//$this->saveAction();

		$data = array(
			'titlePage' => ''
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('home',$data);
		$this->load->view('includes/footer',$data);
	}
	public function page()
	{
		$this->load->view('home');
	}
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
