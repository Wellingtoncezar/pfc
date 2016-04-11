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
			'titlePage' => 'Gerenciar Pedidos',
			'template' => new templateFactory()
		);

		$this->load->dao('produtos/marcasDao');
		$marcas = new marcasDao();
		$data['marcas'] = $marcas->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('orcamentos/pedidos/home',$data);
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
			'titlePage' => 'Cadastrar pedido',
			'template' => new templateFactory()
		);


		$this->load->dao('produtos/produtosDao');
		$produtosDao = new produtosDao();
		$produtos = $produtosDao->listar();
		$data['produtos'] = $produtos;

		
		$this->load->view('includes/header',$data);
		$this->load->view('orcamentos/pedidos/cadastro',$data);
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
	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
	

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);

		
		if ($this->load->dataValidator->validate())
		{
		
			//MARCAS
			$this->load->model('produtos/marcasModel');
			$marcasModel = new marcasModel();
			
			$marcasModel->setNome($nome);
			$marcasModel->setStatus(status::ATIVO);
			$marcasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//marcas DAO
			$this->load->dao('produtos/marcasDao');
			$marcasDao = new marcasDao();
			echo $marcasDao->inserir($marcasModel);
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