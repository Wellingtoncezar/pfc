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
			'titlePage' => 'Caixa'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/checkout/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function checkmachine()
	{
		if(!$this->load->checkPermissao->check(false,URL.'caixa/checkout/gerenciar'))
		{
			echo "Você não tem permissão para realizar esta ação";
			return false;
		}
		$this->load->model('caixa/checkoutModel');
		$this->load->dao('caixa/checkoutDao');

		//get ip client
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}


		$checkoutModel = new checkoutModel();
		$checkoutModel->setIpmaquina($ip);

		$checkoutDao = new checkoutDao();
		if($checkoutDao->checkmachine($checkoutModel))
		{
			$_SESSION['IP'] = $ip;
			// setcookie('IP', $ip, time() + (86400 * 30), "/"); // 86400 = 1 day
			echo true;
		}
		else
			echo 'Esta maquina não está registrada';
	}


	public function abrirCaixa()
	{
		if(!$this->load->checkPermissao->check(false,URL.'caixa/checkout/gerenciar'))
		{
			echo "Você não tem permissão para realizar esta ação";
			return false;
		}

		if(!isset($_SESSION['IP'])) {
			echo 'Erro ao abrir caixa';
		} else {
			$this->load->dao('caixa/checkoutDao');
			$this->load->model('caixa/caixaAbertoModel');
			$caixaAbertoModel = new caixaAbertoModel();
			$caixaAbertoModel->setUsuario(unserialize($_SESSION['user']));
			//$caixaAbertoModel->setIp$_COOKIE['IP']

			$checkoutDao = new checkoutDao();


			


		}
	}
	
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
