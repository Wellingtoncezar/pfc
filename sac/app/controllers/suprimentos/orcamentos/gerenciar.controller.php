<?php
/**
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
	 * Página index
	 */
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Gerenciar Orcamentos'
		);
		
		$this->load->library('dataFormat',null,true);
		$data['dataFormat'] = $this->load->dataFormat;


		$this->load->dao('suprimentos/orcamentosDao');
		$orcamentosDao = new orcamentosDao();
		$data['orcamentos'] = $orcamentosDao->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/orcamentos/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Cadastrar Orcamento',
			'template' => new templateFactory()
		);


		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listarAtivos();
		$data['produtos'] = $produtos;

		
		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/orcamentos/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Editar Orcamentos',
			'template' => new templateFactory()
		);

		$idOrcamento = $this->load->url->getSegment(4);
		$this->load->model('suprimentos/orcamentos/orcamentosModel');
		$orcamentosModel = new orcamentosModel();
		$orcamentosModel->setId($idOrcamento);
		$this->load->dao('suprimentos/orcamentosDao');

		$orcamentosDao = new orcamentosDao();
		$orc = $orcamentosDao-> consultar($orcamentosModel);
		$data['orcamentos'] = $orc;
		print_r($orc);
		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listarAtivos();
		$data['produtos'] = $produtos;

		
		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/orcamentos/editar',$data);
		$this->load->view('includes/footer',$data);
	}





	/*----------------------------
	- AÇÕES
	=============================*/

	public function getItemRequisicao()
	{
		if(isset($_POST['idProduto']))
		{
			$idProduto = intval($_POST['idProduto']);
			$this->load->model('produtos/produtosModel');
			$produtosModel = new produtosModel();
			$produtosModel->setId($idProduto);

			$this->load->dao('produtos/produtosDao');
			$produtosDao = new produtosDao();
			$produto = $produtosDao->consultar($produtosModel);
			
			$imgProduct = ($produto->getFoto() != '') ? URL.'skin/uploads/produtos/p/'.$produto->getFoto() : URL.'skin/img/imagens/produtosemimagem.jpg';
			$nomeUnidadeMedida = '';
			$nomeUnidadeMedida = '';
			foreach ($produto->getUnidadeMedida() as $unidadeMedida){
				if($unidadeMedida->getParaEstoque() == true)
				{
					$nomeUnidadeMedida = $unidadeMedida->getUnidadeMedida()->getNome();
					$idUnidadeMedida = $unidadeMedida->getId();
				}
			}
			// echo '<pre>';
			// print_r($produto->getUnidadeMedida());
			// echo '</pre>';
			// echo 'acabou';
			$aux = Array(
				'id_produto' => $produto->getId(),
				'imgProduct' => $imgProduct,
				'productname' => $produto->getNome(),
				'unidadeMedida' => $nomeUnidadeMedida,
				'idUnidadeMedida' => $idUnidadeMedida
			);

			echo json_encode($aux);
		}
	}



	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
		$titulo = isset($_POST['titulo']) ? filter_var($_POST['titulo']) : '';
		$observacoes = isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		$produtos = isset($_POST['produtos']) ? filter_var_array($_POST['produtos']) : array();
		


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		$this->load->dataValidator->set('Código', $codigo, 'codigo')->is_required()->min_length(3);
		$this->load->dataValidator->set('Título', $titulo, 'titulo')->is_required()->min_length(2);
		$this->load->dataValidator->set('Produtos', $produtos, 'produtos')->is_required();


		
		if ($this->load->dataValidator->validate())
		{
			$this->load->model('suprimentos/requisicoes/requisicoesModel');
			$this->load->model('suprimentos/requisicoes/requisicaoProdutoModel');
			$this->load->model('produtos/produtosModel');
			$this->load->model('produtos/unidadeMedidaProdutoModel');
			$this->load->model('funcionarios/usuarioModel');
			
			$requisicoesModel = new requisicoesModel();
			foreach($produtos as $produto)
			{
				$unidadeMedidaProdutoModel = new unidadeMedidaProdutoModel();
				$unidadeMedidaProdutoModel->setId($produto['idUnidadeMedida']);

				$produtoModel = new produtosModel();
				$produtoModel->setId($produto['id_produto']);
				$produtoModel->addUnidadeMedida($unidadeMedidaProdutoModel);

				$requisicaoProdutoModel = new requisicaoProdutoModel();
				$requisicaoProdutoModel->addProduto($produtoModel);
				$requisicaoProdutoModel->setQuantidade($produto['quantidade']);
				$requisicoesModel->addProdutoRequisitado($requisicaoProdutoModel);

			}

			$usuarioModel = unserialize($_SESSION['user']);
			
			$requisicoesModel->setUsuarioCadastrado($usuarioModel);

			$requisicoesModel->setTitulo($titulo);
			$requisicoesModel->setCodigo($codigo);
			$requisicoesModel->setObservacoes($observacoes);
			$requisicoesModel->setData(date('Y-m-d H:i:s'));

			//marcas DAO
			$this->load->dao('suprimentos/requisicoesDao');
			try {
				$requisicoesDao = new requisicoesDao();
				echo $requisicoesDao->inserir($requisicoesModel);			
			} catch (Exception $e) {
				echo $e->getMessage();				
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}



	/**
	 * Ação do editar
	 */
	/**
	 * Ação do cadastrar
	 */
	public function atualizar()
	{
		$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
		$titulo = isset($_POST['titulo']) ? filter_var($_POST['titulo']) : '';
		$observacoes = isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		$produtos = isset($_POST['produtos']) ? filter_var_array($_POST['produtos']) : array();
		


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		$this->load->dataValidator->set('Código', $codigo, 'codigo')->is_required()->min_length(3);
		$this->load->dataValidator->set('Título', $titulo, 'titulo')->is_required()->min_length(2);
		$this->load->dataValidator->set('Produtos', $produtos, 'produtos')->is_required();


		
		if ($this->load->dataValidator->validate())
		{
			$this->load->model('suprimentos/requisicoes/requisicoesModel');
			$this->load->model('suprimentos/requisicoes/requisicaoProdutoModel');
			$this->load->model('produtos/produtosModel');
			$this->load->model('produtos/unidadeMedidaProdutoModel');
			$this->load->model('funcionarios/usuarioModel');
			
			$requisicoesModel = new requisicoesModel();
			foreach($produtos as $produto)
			{
				$unidadeMedidaProdutoModel = new unidadeMedidaProdutoModel();
				$unidadeMedidaProdutoModel->setId($produto['idUnidadeMedida']);

				$produtoModel = new produtosModel();
				$produtoModel->setId($produto['id_produto']);
				$produtoModel->addUnidadeMedida($unidadeMedidaProdutoModel);

				$requisicaoProdutoModel = new requisicaoProdutoModel();
				$requisicaoProdutoModel->addProduto($produtoModel);
				$requisicaoProdutoModel->setQuantidade($produto['quantidade']);
				$requisicoesModel->addProdutoRequisitado($requisicaoProdutoModel);

			}

			$usuarioModel = unserialize($_SESSION['user']);
			
			$requisicoesModel->setUsuarioCadastrado($usuarioModel);

			$requisicoesModel->setTitulo($titulo);
			$requisicoesModel->setCodigo($codigo);
			$requisicoesModel->setObservacoes($observacoes);
			$requisicoesModel->setData(date('Y-m-d H:i:s'));

			//marcas DAO
			$this->load->dao('suprimentos/requisicoesDao');
			try {
				$requisicoesDao = new requisicoesDao();
				echo $requisicoesDao->inserir($requisicoesModel);			
			} catch (Exception $e) {
				echo $e->getMessage();				
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}



	public function cancelar()
	{
		// $saveRouter = new saveRouter;
		// $saveRouter->saveModule();
		// $saveRouter->saveAction();
		// $this->load->checkPermissao->check();
		// $this->atualizarStatus();
	}


	public function cotartodos()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$this->atualizarStatus();
	}

	public function listarprodutosrequisitados()
	{
		$idRequisicao = intval($this->load->url->getSegment(4));
		$this->load->model('suprimentos/requisicoes/requisicoesModel');
		$requisicoesModel = new requisicoesModel();
		$requisicoesModel->setId($idRequisicao);
		$this->load->dao('suprimentos/requisicoesDao');
		$requisicoesDao = new requisicoesDao();
		$produtosRequisitados = $requisicoesDao->listarProdutosRequisitados($requisicoesModel);

		// $arrayProdutosRequisitados = Array();
		// $arrayProdutosRequisitados['idRequisicao'] = $produtosRequisitados->getId(); // id da requisição 
		// $arrayProdutosRequisitados['produtos'] = Array();
		// foreach ($produtosRequisitados->getProdutosRequisitados() as $key => $produtoRequisitado)
		// {
		// 	$aux = Array();
		// 	$aux['id_produto_requisitado'] = $produtoRequisitado->getId();
		// 	$aux['nome_produto'] = $produtoRequisitado->getProdutos()->getNome();
		// 	$aux['nome_unidade_medida'] = $produtoRequisitado->getProdutos()->getUnidadeMedida()[0]->getUnidadeMedida()->getNome();
		// 	$aux['quantidade'] = $produtoRequisitado->getQuantidade();
		// 	$aux['status'] = $produtoRequisitado->getStatus();
		// 	array_push($arrayProdutosRequisitados['produtos'], $aux);
		// }
		$data['produtosrequisitados'] = $produtosRequisitados;
		$this->load->library('dataFormat',null,true);
		$data['dataFormat'] = $this->load->dataFormat;
		//$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/requisicoes/produtos_requisitados',$data);
		//$this->load->view('includes/footer',$data);
	}


	public function aprovarcotacaoproduto()
	{
		$this->load->model('suprimentos/requisicoes/requisicaoProdutoModel');
		$this->load->dao('suprimentos/requisicoesDao');

		$id_produto_requisitado = intval($this->load->url->getSegment(4));
		
		$requisicaoProdutoModel = new requisicaoProdutoModel();
		$requisicaoProdutoModel->setId($id_produto_requisitado);
		$requisicaoProdutoModel->aprovar();

		$requisicoesDao = new requisicoesDao();
		echo $requisicoesDao->aprovarcotacaoproduto($requisicaoProdutoModel);
	}

	public function reprovarcotacaoproduto()
	{
		$this->load->model('suprimentos/requisicoes/requisicaoProdutoModel');
		$this->load->dao('suprimentos/requisicoesDao');

		$id_produto_requisitado = intval($this->load->url->getSegment(4));
		
		$requisicaoProdutoModel = new requisicaoProdutoModel();
		$requisicaoProdutoModel->setId($id_produto_requisitado);
		$requisicaoProdutoModel->reprovar();

		$requisicoesDao = new requisicoesDao();
		echo $requisicoesDao->reprovarcotacaoproduto($requisicaoProdutoModel);
	}

	

}