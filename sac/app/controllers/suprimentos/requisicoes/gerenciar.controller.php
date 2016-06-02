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
			'titlePage' => 'Gerenciar Requisicoes'
		);

		$this->load->dao('suprimentos/requisicoesDao');
		$requisicoesDao = new requisicoesDao();
		$data['requisicoes'] = $requisicoesDao->listar();
		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/requisicoes/home',$data);
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
			'titlePage' => 'Cadastrar Requisição',
			'template' => new templateFactory()
		);


		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listarAtivos();
		$data['produtos'] = $produtos;

		
		$this->load->view('includes/header',$data);
		$this->load->view('suprimentos/requisicoes/cadastro',$data);
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
			'titlePage' => 'Editar marca',
			'template' => new templateFactory()
		);
		//ID
		$idMarcas = intval($this->load->url->getSegment(4));
		
		//marca MODEL
		$this->load->model('produtos/marcasModel');
		$marcasModel = new marcasModel();
		$marcasModel->setId($idMarcas);

		//marca DAO
		$this->load->dao('produtos/marcasDao');
		$marcasDao = new marcasDao();
		$data['marca'] = $marcasDao->consultar($marcasModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat', null, true);
		$data['dataFormat'] = $this->load->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('produtos/marcas/editar',$data);
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
		$idMarcas = isset($_POST['idMarca']) ? filter_var($_POST['idMarca']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		

		
		if ($this->load->dataValidator->validate())
		{
		
			//CATEGORIA
			$this->load->model('produtos/marcasModel');
			$marcasModel = new marcasModel();
			$marcasModel->setId($idMarcas);
			$marcasModel->setNome($nome);
			$marcasModel->setStatus(status::ATIVO);
			$marcasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//CATEGORIA DAO
			$this->load->dao('produtos/marcasDao');
			$marcasDao = new marcasDao();
			echo $marcasDao->atualizar($marcasModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}

	/**
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idMarcas = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//MARCA MODEL
		$this->load->model('produtos/marcasModel');
		$marcasModel = new marcasModel();
		$marcasModel->setId( $idMarcas );
		$marcasModel->setStatus( $status );

		//MARCA DAO
		$this->load->dao('produtos/marcasDao');
		$marcasDao = new marcasDao();
		echo $marcasDao->atualizarStatus($marcasModel);

	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$this->atualizarStatus();
	}

}