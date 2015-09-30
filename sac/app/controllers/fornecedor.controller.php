<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class fornecedor extends Controller{
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
			'titlePage' => 'fornecedor'
		);
		
		$this->load->model();
		$this->load->view('includes/header',$data);
		$this->load->view('fornecedor/home',$data);
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
		$this->load->view('fornecedor/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/