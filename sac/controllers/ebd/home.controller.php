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
		$checkPermissao = new checkPermissao();
		$checkPermissao->checkPermissaoPagina();
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
			'titulo' => 'Classes da Escola Bíblica Dominical',
			'method' => __METHOD__
		);
		
		//carregamento do model e listagem
		$this->loadModel('ebd/classesModel');
		$classes = new classesModel();
		$classes = $classes->listar();
		$data['classes'] = $classes;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar nova classe'
		);

		$this->loadModel('ebd/departamentosModel');
		$departamentos = new departamentosModel();
		$data['departamentos'] = $departamentos->listar('=','Ativo');

		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$data['igreja'] = $igreja->listar('=','Ativo');

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/**
	*Atualiza o status 
	*/
	/*
	public function atualizarStatus()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('membros/membrosModel');
		$membro = new membrosModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}

	/**
	*Exclusão apena para envia-lo à lixeira
	*/
	/*
	public function excluir()
	{
		$this->saveAction();
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('membros/membrosModel');
		$membro = new membrosModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}
	
	*/


	
}

/**
*
*class: home
*
*location : controllers/ebd/home.controller.php
*/