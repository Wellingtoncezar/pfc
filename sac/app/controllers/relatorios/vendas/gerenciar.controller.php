<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('produtos/produtosModel');
		$this->load->model('caixa/produtosVendidoModel');
		$this->load->model('relatorios/IRelatoriosModel');
		$this->load->model('relatorios/RelatoriosModel');
		$this->load->model('relatorios/vendas/ProdutosMaisVendidosModel');

		$this->load->dao('produtos/produtosDao');
		$this->load->dao('produtos/iConsultaProduto');
		$this->load->dao('produtos/consultaPorId');
		$this->load->dao('relatorios/IRelatoriosDao');
		$this->load->dao('relatorios/RelatoriosDao');
		$this->load->dao('relatorios/vendas/ConsultaProdutosMaisVendidos');
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
			'titlePage' => 'Relatórios'
		);

		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listar();
		
		$data['produtos'] = $produtos;
		$this->load->view('includes/header',$data);
		$this->load->view('relatorios/vendas/home',$data);
		$this->load->view('includes/footer',$data);
	}


	public function consultaRelatorio()
	{
		try {
			
			//Obtendo os dados
			$dataformat = new dataformat();
			$periodoDe 	= $dataformat->formatar($this->http->getRequest('periodoDe'), 'data', 'banco');
			$periodoAte = $dataformat->formatar($this->http->getRequest('periodoAte'), 'data', 'banco');
			$produto = (int)$this->http->getRequest('produto');

			$RelatoriosModel = new RelatoriosModel();
			$RelatoriosModel->setPeriodoDe($periodoDe);
			$RelatoriosModel->setPeriodoAte($periodoAte);

			

			$RelatoriosDao = new RelatoriosDao();
			$res = $RelatoriosDao->consultarProdutosMaisVendidos($RelatoriosModel);

			if($res != null)
			{
				$json = $this->jsonProdutosMaisVendidos($res);

				$this->http->response($json);
			}else
			{
				$this->http->response('Dados não encontrados', 400);
			}
		} catch (dbException $e) {
			$this->http->response($e->getMessageError());
		}
	} 

	
	public function jsonProdutosMaisVendidos($produtosMaisVendidos)
	{
		$dataformat = new dataformat();
		$json = Array();
		foreach ($produtosMaisVendidos->getTipoRelatorio() as $produtoVendido)
		{
			$produtos = new produtosDao();
			$produtosModel = $produtos->consultar(new consultaPorId(), $produtoVendido->getProdutosVendido()->getProduto(), array(status::ATIVO, status::INATIVO));
			$produtoVendido->getProdutosVendido()->setProduto($produtosModel);

			$aux = Array(
				'produto' => $produtoVendido->getProdutosVendido()->getProduto()->getNome(),
				'qtdVenda' => $produtoVendido->getQtdVendas(),
				'qtdProduto' => $dataformat->formatar($produtoVendido->getQtdTotalProdutos(), 'decimalinteiro'),
				'unidadeMedida' => $produtoVendido->getProdutosVendido()->getUnidadeMedidaVendido(),
				'media' => $dataformat->formatar(($produtoVendido->getQtdTotalProdutos() / $produtoVendido->getQtdVendas()), 'decimalinteiro')
			);

			array_push($json, $aux);
		}
		return json_encode($json);
	}


}
