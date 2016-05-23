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
			'titlePage' => 'Gerenciar Categoria',
			'template' => new templateFactory()
		);

		$this->load->dao('produtos/categoriasDao');
		$categorias = new categoriasDao();
		$data['categorias'] = $categorias->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('produtos/categorias/home',$data);
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
			'titlePage' => 'Cadastrar categoria',
			'template' => new templateFactory()
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/categorias/cadastro',$data);
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
			'titlePage' => 'Editar categoria',
			'template' => new templateFactory()
		);
		//ID
		$idCategoria = intval($this->load->url->getSegment(4));
		
		//FUNCIONARIO MODEL
		$this->load->model('produtos/categoriasModel');
		$categoriasModel = new categoriasModel();
		$categoriasModel->setId($idCategoria);

		//FUNCIONARIO DAO
		$this->load->dao('produtos/categoriasDao');
		$categoriasDao = new categoriasDao();
		$data['categoria'] = $categoriasDao->consultar($categoriasModel);
		


		$this->load->view('includes/header',$data);
		$this->load->view('produtos/categorias/editar',$data);
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

			//CATEGORIA
			$this->load->model('produtos/categoriasModel');
			$categoriasModel = new categoriasModel();
			
			$categoriasModel->setNome($nome);
			$categoriasModel->setStatus(status::ATIVO);
			$categoriasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//CATEGORIAS DAO
			$this->load->dao('produtos/categoriasDao');
			$categoriasDao = new categoriasDao();
			echo $categoriasDao->inserir($categoriasModel);
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
		$idCategoria = isset($_POST['idCategoria']) ? filter_var($_POST['idCategoria']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';


		//validação dos dados
		$this->load->library('dataValidator' ,null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		

		
		if ($this->load->dataValidator->validate())
		{
		
			//CATEGORIA
			$this->load->model('produtos/categoriasModel');
			$categoriasModel = new categoriasModel();
			$categoriasModel->setId($idCategoria);
			$categoriasModel->setNome($nome);
			$categoriasModel->setStatus(status::ATIVO);
			$categoriasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//CATEGORIA DAO
			try {
				$this->load->dao('produtos/categoriasDao');
				$categoriasDao = new categoriasDao();
				echo $categoriasDao->atualizar($categoriasModel);
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
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idCategoria = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//CATEGORIA MODEL
		$this->load->model('produtos/categoriasDao');
		$categoriasDao = new categoriasDao();
		$categoriasDao->setId( $idCategoria );
		$categoriasDao->setStatus( $status );

		//CATEGORIA DAO
		$this->load->dao('produtos/categoriasDao');
		$categoriasDao = new categoriasDao();
		echo $categoriasDao->atualizarStatus($categoriasModel);

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