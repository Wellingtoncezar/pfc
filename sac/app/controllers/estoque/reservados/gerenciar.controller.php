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
			'titlePage' => 'Zona Reservada - Estoque'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('estoque/reservados/home2',$data);
		$this->load->view('includes/footer',$data);
	}

	public function getjsonlote()
	{
		$this->load->dao('estoque/estoqueDao');
		$this->load->dao('estoque/iListagemEstoque');
		$this->load->dao('estoque/listarReservados');
		$estoqueDao = new estoqueDao();
		$estoque = $estoqueDao->listar(new listarReservados());
		echo $estoqueDao->getJsonEstoque($estoque);
	}

}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/