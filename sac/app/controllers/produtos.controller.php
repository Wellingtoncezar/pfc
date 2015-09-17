<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtos extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/********************************************/
	/****PÁGINAS****/
	
	/**
	*Página index
	*/
	public function index()
	{
		$this->saveModules();
		$this->saveAction();

		$data = array(
			'titlePage' => 'Produtos'
		);
		
		$this->load->view('include/header',$data);
		$this->load->view('produtos/home',$data);
		$this->load->view('include/footer',$data);
	}

	
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
