<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function pesquisarproduto()
	{
		$this->load->model('produtos/produtosModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/IConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('produtos/consultaPorCodigoBarras');

		$tipo = $this->http->getRequest('tipo');
		$value = $this->http->getRequest('value');
		$status = Array(status::ATIVO);

		$produtosModel = new produtosModel();
		$produtos = new produtosDao();

		$produto = new produtosModel();
		if($tipo == 'pordescricao')
		{
			$idProduto = (int) $value;
			$produtosModel->setId($idProduto);
			$produto = $produtos->consultar(new consultaPorId(), $produtosModel, $status);
		}else
		if($tipo == 'porcodigo'){
			$produtosModel->setCodigoBarra($value);
			$produto = $produtos->consultar(new consultaPorCodigoBarras(), $produtosModel, $status);
		}
		echo (empty($produto)) ? 'nada': 'tem';

	}
	
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
