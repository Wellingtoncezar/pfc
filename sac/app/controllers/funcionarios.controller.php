<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionarios extends Controller{
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
		//$this->saveModules();
		$this->saveAction();

		$data = array(
			'titlePage' => 'Funcionários'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function cadastro()
	{
		//$this->saveModules();
		$this->saveAction();

		$data = array(
			'titlePage' => 'Cadastro'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
