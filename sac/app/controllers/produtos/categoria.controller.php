<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class categoria extends Controller{
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
		$data = array(
			'titlePage' => 'Gerenciar Categoria'
		);

		$this->load->dao('produtos/categoriasDao');
		$categorias = new categoriasDao();
		$data['categorias'] = $categorias->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('categorias/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$data = array(
			'titlePage' => 'Cadastrar categoria'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('categorias/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$data = array(
			'titlePage' => 'Editar categoria'
		);
		//ID
		$idFuncionario = intval($this->url->getSegment(3));
		
		//FUNCIONARIO MODEL
		$this->load->model('produtos/categoriasModel');
		$categoriasModel = new categoriasModel();
		$categoriasModel->setId($idCategoria);

		//FUNCIONARIO DAO
		$this->load->dao('categorias/categoriasDao');
		$categoriasDao = new categoriasDao();
		$data['funcionario'] = $categoriasDao->consultar($categoriasModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat');
		$data['dataFormat'] = $this->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('categorias/editar',$data);
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
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);

		

		
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
			$todos_erros = $this->dataValidator->get_errors();
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
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		

		

		
			//CATEGORIA
			$this->load->model('produtos/categoriasModel');
			$categoriasDao = new categoriasDao();
			$categoriasDao->setId($idCategoria);
			$categoriasDao->setNome($nome);
			$categoriasDao->setStatus(status::ATIVO);
			$categoriasDao->setDataCadastro(date('Y-m-d h:i:s'));


			//CATEGORIA DAO
			$this->load->dao('produtos/categoriasDao');
			$categoriasDao = new categoriasDao();
			echo $categoriasDao->atualizar($categoriasDao);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
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
		$this->atualizarStatus();
	}

}