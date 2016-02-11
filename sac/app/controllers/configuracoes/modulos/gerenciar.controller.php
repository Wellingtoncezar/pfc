<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class gerenciar extends Controller{
	private $error = array();
	private $countError = 0;
	
	public function __construct(){
		parent::__construct();
		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		
		// //checagem do login
		// $this->load->dao('loginDao');
		// $login = new loginDao();
		// $login->statusLogin();
	}

	/********************************************/
	/****PÁGINAS****/

	/**
	*Página index
	*/
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		$data = array(
			'titulo' => 'Módulos do sistema',
		);

		$this->load->dao('configuracoes/modulosDao');
		$modulos = new modulosDao();
		$data['modulos'] = $modulos->listar(0);
		
		$this->load->view('includes/header',$data);
		$this->load->view('configuracoes/modulos/home',$data);
		$this->load->view('includes/footer',$data);

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

		$this->load->model('configuracoes/modulos/modulosModel');
		$modulosModel = new modulosModel();
		$modulosModel->setTipo($tipo);
		$modulosModel->setId($id);
		$modulosModel->setCampo($campo);
		$modulosModel->setValor($valor);

		$this->load->dao('configuracoes/modulosDao');
		$modulosDao = new modulosDao();
		echo $modulosDao->atualizar($modulosModel);
	}


	/**
	* Atualiza a posição dos menus para visualização
	*/
	public function updatePosition()
	{
		$positions = $_POST['ordem'];
		$this->load->dao('configuracoes/modulosDao');
		$modulosDao = new modulosDao();
		echo $modulosDao->updatePosition($positions);
	}
}

/**
*
*class: home
*
*location : controllers/configuracoes/modulos/home.controller.php
*/