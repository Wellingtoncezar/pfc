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

		$this->load->dao('estoque/estoqueDao');
		$this->load->dao('estoque/iListagemEstoque');
		$this->load->dao('estoque/listarPrateleira');
		$estoqueDao = new estoqueDao();
		$estoque = $estoqueDao->listar(new listarPrateleira());

		// echo '<pre>';
		// print_r($estoque);
		// echo '</pre>';

		$data['produtos'] = $estoque;

		$this->load->view('includes/header',$data);
		$this->load->view('caixa/checkout/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function checkmachine()
	{
		if(!$this->load->checkPermissao->check(false,URL.'caixa/checkout/gerenciar'))
		{
			$this->http->response("Você não tem permissão para realizar esta ação");
			return false;
		}
		$this->load->dao('caixa/caixasDao');
		$this->load->model('caixa/caixasModel');
		$this->load->dao('caixa/iConsultaCaixa');
		$this->load->dao('caixa/consultaPorIp');

		//obtendo o ip da maquina
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}


		$caixasModel = new caixasModel();
		$caixasModel->setIp($ip);

		$caixasDao = new caixasDao();
		//verificando se a maquina tem permissao de abrir caixa
		if($caixasDao->checkmachine($caixasModel))
		{
			//retornando os dados do caixa por consulta por ip
			$caixasModel = $caixasDao->consultar(new consultaPorIp(), $caixasModel);
			//gravando os dados do caixa na sessão
			$_SESSION['caixa'] = serialize($caixasModel);

			// setcookie('IP', $ip, time() + (86400 * 30), "/"); // 86400 = 1 day
			$this->http->response(true);
		}
		else
			$this->http->response('Esta máquina não está registrada');
	}


	public function abrirCaixa()
	{
		try{
			//verificação de permissão de acesso
			if(!$this->load->checkPermissao->check(false,URL.'caixa/checkout/gerenciar'))
			{
				$this->http->response("Você não tem permissão para abrir caixa");
				return false;
			}

			//VERIFICANDO SE O CAIXA JÁ ESTÀ DEFINIDO PARA A MAQUINA ATUAL
			if(!isset($_SESSION['caixa'])) {
				$this->http->response('A Máquina não está configurada corretamente');
				return false;
			}

			//OBTENDO OS DADOS
			$dataformat = new dataformat();
			$saldoInicial = $dataformat->formatar($this->http->getRequest('saldoinicial'), 'decimal', 'banco');

			//VALIDANDO OS DADOS
			$this->load->library('dataValidator');
			$dataValidator = new dataValidator();
			$dataValidator->set('Número', $saldoInicial, 'saldoinicial')->is_required();
			if ($dataValidator->validate())
			{

				$this->load->dao('caixa/caixasDao');
				$this->load->model('caixa/caixaAbertoModel');
				$this->load->model('caixa/caixasModel');
				$this->load->model('caixa/vendasModel');
				$vendasModel = new vendasModel();

				$caixaAbertoModel = new caixaAbertoModel();
				$caixaAbertoModel->setUsuario(unserialize($_SESSION['user']));
				$caixaAbertoModel->setSaldoInicial($saldoInicial);
				$caixaAbertoModel->setDataAbertura(date('Y-m-d h:i:s'));
				$caixaAbertoModel->addVenda($vendasModel);


				//obtendo os dados do caixa da sessão
				$caixa = unserialize($_SESSION['caixa']);
				$caixa->addCaixaAberto($caixaAbertoModel);

				$caixasDao = new caixasDao();
				$caixa = $caixasDao->abrirCaixa($caixa);
				if($caixa != null)
				{
					$_SESSION['caixa'] = serialize($caixa);
					$this->http->response(true);
				}else
					$this->http->response('Não foi possível abrir o caixa, feche o caixa anterior para poder prosseguir', 400);
			}else
			{
				$this->http->response('Informe o saldo inicial em caixa', 400);
			}	
		} catch (dbException $e) {
			$this->http->response($e->getMessageError(), 400);
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
		//carregamento das classes dependentes
		$this->load->dao('produtos/IConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/precosDao');
		$this->load->model('produtos/produtosModel');
		$this->load->model('caixa/produtosVendidoModel');
		$this->load->model('caixa/vendasModel');
		$this->load->model('caixa/caixaAbertoModel');
		$this->load->model('caixa/caixasModel');

		//Obtendo os dados de entrada
		$dataformat = new dataformat();
		$idproduto = $this->http->getRequest('idproduto');
		$quantidade = (double) $dataformat->formatar($this->http->getRequest('quantidade'), 'decimal', 'banco');

		$produtosModel = new produtosModel();
		$produtosModel->setId($idproduto);

		//obtendo os dados do produto
		$produtosDao = new produtosDao();
		$produtosModel = $produtosDao->consultar(new consultaPorId(), $produtosModel, array(status::ATIVO));
		
		$produtosVendidoModel = new produtosVendidoModel();
		$produtosVendidoModel->setProduto($produtosModel);
		$produtosVendidoModel->setQuantidade($quantidade);

		//Obtendo o preço de venda
		$precosDao = new precosDao();
		$produtosVendidoModel->setPrecoVendido($precosDao->consultarPrecoVenda($produtosModel)->getPreco());

		//Adicionando o produto na venda
		$caixa = unserialize($_SESSION['caixa']);
		$caixa->getCaixaAberto()[0]->getVendas()[0]->addProdutoVendido($produtosVendidoModel);

		$_SESSION['caixa'] = serialize($caixa);

		$this->http->response(true);
	}

	/**
	 * retorna a lista dos produtos no carrinho
	 * */
	public function listarCarrinho()
	{
		$this->load->model('produtos/produtosModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		$this->load->model('produtos/unidadeMedidaModel');
		$this->load->model('caixa/produtosVendidoModel');
		$this->load->model('caixa/vendasModel');
		$this->load->model('caixa/caixaAbertoModel');
		$this->load->model('caixa/caixasModel');

		$dataformat = new dataformat();
		$caixa = unserialize($_SESSION['caixa']);
		$produtosVendidos = $caixa->getCaixaAberto()[0]->getVendas()[0]->getProdutosVendidos();

		$carrinho = Array();
		foreach ($produtosVendidos as $i => $produtoVendido)
		{
			$row = Array(
				'item' => html_entity_decode($produtoVendido->getProduto()->getNome()),
				'qtd' => $dataformat->formatar($produtoVendido->getQuantidade(),'decimal'),
				'preco' => $dataformat->formatar($produtoVendido->getPrecoVendido(), 'moeda')
			);
			array_push($carrinho, $row);
		}
		$this->http->response(json_encode($carrinho));
	}
	

	public function consultaSubtotalCarrinho()
	{
		$this->load->model('produtos/produtosModel');
		$this->load->model('caixa/produtosVendidoModel');
		$this->load->model('caixa/vendasModel');
		$this->load->model('caixa/caixaAbertoModel');
		$this->load->model('caixa/caixasModel');

		$dataformat = new dataformat();
		$caixa = unserialize($_SESSION['caixa']);
		$produtosVendidos = $caixa->getCaixaAberto()[0]->getVendas()[0]->getProdutosVendidos();

		
		$subtotal = 0;
		foreach ($produtosVendidos as $i => $produtoVendido)
		{
			$subtotal += $produtoVendido->getQuantidade() * $produtoVendido->getPrecoVendido();
		}
		$retorn = array(
			'formated' => $dataformat->formatar($subtotal, 'decimal'),
			'unformated' => $subtotal
		);
		$this->http->response(json_encode($retorn));
	}



	public function finalizarCompra()
	{
		try {
			
			$dataformat = new dataformat();
			$this->load->library('dataValidator');
			$dataValidator = new dataValidator();

			$this->load->model('produtos/produtosModel');
			$this->load->model('caixa/produtosVendidoModel');
			$this->load->model('caixa/vendasModel');
			$this->load->model('caixa/caixaAbertoModel');
			$this->load->model('caixa/caixasModel');
			$this->load->dao('caixa/caixasDao');


			$formapagamento = $this->http->getRequest('formapagamento');

			$valorrecebido = $dataformat->formatar($this->http->getRequest('valorrecebido'),'decimal', 'banco');
			

			if($formapagamento == formapagamento::DINHEIRO){
				$dataValidator->set('Valor recebido', $valorrecebido, 'valorrecebido')->is_required();
			}
			
			//validando os dados de entrada
			if ($dataValidator->validate())
			{
				$dataformat = new dataformat();
				$caixa = unserialize($_SESSION['caixa']);

				$caixa->getCaixaAberto()[0]->getVendas()[0]->setDataVenda(date('Y-m-d'));
				$caixa->getCaixaAberto()[0]->getVendas()[0]->setHoraVenda(date('H:i:s'));

				//forma de pagamento escolhido 
				if($formapagamento == formapagamento::DINHEIRO)
					$caixa->getCaixaAberto()[0]->getVendas()[0]->pagarComDinheiro();
				else
				if($formapagamento == formapagamento::CARTAOCREDITO)
					$caixa->getCaixaAberto()[0]->getVendas()[0]->pagarComCartaoCredito();
				else
				if($formapagamento == formapagamento::CARTAODEBITO)
					$caixa->getCaixaAberto()[0]->getVendas()[0]->pagarComCartaoDebito();

				//valor pago pelo cliente
				$caixa->getCaixaAberto()[0]->getVendas()[0]->setValorPago($valorrecebido);

				
				$caixasDao = new caixasDao();
				if($caixasDao->finalizarCompra($caixa));
				{
					$caixa->getCaixaAberto()[0]->setVendas(array(new vendasModel()));
					$_SESSION['caixa'] = serialize($caixa);
					$this->http->response(true);
				}

			}else
		    {
				$this->http->response('Informe o valor pago pelo cliente', 400);
		    }
		} catch (Exception $e) {
			$this->http->response($e->getMessageError(), 400);
		}
	}

}
