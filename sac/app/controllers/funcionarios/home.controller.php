<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
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
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Funcionários'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function cadastrar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Cadastrar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Editar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function inserir()
	{
		echo json_encode(array('error' => 'Erro de teste'));
	}


	
}


/**
*
*class: home
*
*location : controllers/home.controller.php
*/
