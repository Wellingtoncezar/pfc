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
			'titlePage' => 'Caixa',
			'usuario' => unserialize($_SESSION['user'])
		);

		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listarAtivos();
		$data['produtos'] = $produtos;

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



	public function consultaProduto()
	{
		$this->load->model('produtos/produtosModel');
		$this->load->model('produtos/precosModel');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/IConsultaProduto');
		$this->load->dao('produtos/consultaPorIdNaPrateleira');
		$this->load->dao('produtos/consultaPorCodigoBarras');
		$this->load->dao('produtos/precosDao');

		$tipo = $this->http->getRequest('tipo');
		$value = $this->http->getRequest('value');
		$quantidade = $this->http->getRequest('quantidade');


		// $tipo = 'porcodigo';
		// $value = '7896006752837';

		$status = Array(status::ATIVO);

		$produtosModel = new produtosModel();
		$produtos = new produtosDao();

		$produto = new produtosModel();
		if($tipo == 'pordescricao')
		{
			//em estoque
			$idProduto = (int) $value;
			$produtosModel->setId($idProduto);
			$produto = $produtos->consultar(new consultaPorIdNaPrateleira(), $produtosModel, $status);
		}else
		if($tipo == 'porcodigo'){
			$produtosModel->setCodigoBarra($value);
			$produto = $produtos->consultar(new consultaPorCodigoBarras(), $produtosModel, $status);
		}

		$precos = new precosDao();
		$precosModel = $precos->consultarPrecoVenda($produto);

		$produto->addPreco($precosModel);


		if(!empty($produto))
			$this->http->response($this->getJson($produto));
		else
			$this->http->response(false);
	}


	private function getJson(produtosModel $produto)
	{
		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$auxJson = Array(
			'id' => $produto->getId(),
			'codigobarras' => $produto->getCodigoBarra(),
			'nome' => $produto->getNome(),
			'foto' => URL.'skin/uploads/produtos/p/'.$produto->getFoto(),
			'preco' => $produto->getPrecos()[0]->getPreco(),
			'precoFormatado' => $dataformat->formatar($produto->getPrecos()[0]->getPreco(),'moeda')
		);
		return json_encode($auxJson);
	}

	


	public function addProdutoListaVenda()
	{
		echo 'produto listado';
	}
	


}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
