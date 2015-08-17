<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class home extends Controller{
	private $id;	
	public function setId($id){
		$this->id = $id;
	}


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
			'titulo' => 'Lixeira',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		
		$this->loadModel('lixeira/lixeiraModel');
		$lixeira = new lixeiraModel();
		$lixeira = $lixeira->listar();
		$data['lixeira'] = $lixeira;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('lixeira/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* restaura o registro exluído
	*/
	public function restaurar()
	{
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		$this->loadModel('lixeira/lixeiraModel');
		$lixeira = new lixeiraModel();
		$lixeira->setId($id);
		echo $lixeira->restaurar();
	}
}

/**
*
*class: home
*
*location : controllers/lixeira/home.controller.php
*/