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
			'titulo' => 'Módulos do sistema',
		);

		$this->loadModel('configuracoes/modulos/modulosModel');
		$modulos = new modulosModel();
		$data['modulos'] = $modulos->listar(0);
		
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/modulos/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$tipo = isset($_POST['tipo']) ? filter_var($_POST['tipo']) : '';
		$id = isset($_POST['id']) ? filter_var($_POST['id']) : '';
		$campo = isset($_POST['campo']) ? filter_var($_POST['campo']) : '';
		$valor = isset($_POST['valor']) ? filter_var($_POST['valor']) : '';

		$this->loadModel('configuracoes/modulos/modulosModel');
		$modulos = new modulosModel();
		$modulos->setTipo($tipo);
		$modulos->setId($id);
		$modulos->setCampo($campo);
		$modulos->setValor($valor);
		echo $modulos->atualizar();

	}


	/**
	* Atualiza a posição dos menus para visualização
	*/
	public function updatePosition()
	{
		$positions = $_POST['ordem'];
		$this->loadModel('configuracoes/modulos/modulosModel');
		$modulos = new modulosModel();
		echo $modulos->updatePosition($positions);
	}
}

/**
*
*class: home
*
*location : controllers/configuracoes/modulos/home.controller.php
*/