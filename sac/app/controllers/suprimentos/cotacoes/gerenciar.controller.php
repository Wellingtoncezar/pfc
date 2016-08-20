<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();

	}


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
			'titlePage' => 'Armazém - Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/cotacoes/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function getjsonlote()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->dao('estoque/iListagemEstoque');
		$this->load->dao('estoque/listarArmazem');
		$estoqueDao = new estoqueDao();
		$estoque = $estoqueDao->listar(new listarArmazem());
		$this->http->response($estoqueDao->getJsonEstoque($estoque));
	}


	

}