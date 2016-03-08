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
		$data = array(
			'titlePage' => 'Gerenciar Marca',
			'template' => new templateFactory()
		);

		$this->load->dao('produtos/marcasDao');
		$marcas = new marcasDao();
		$data['marcas'] = $marcas->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('produtos/marcas/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$data = array(
			'titlePage' => 'Cadastrar marcas',
			'template' => new templateFactory()

		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('produtos/marcas/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$data = array(
			'titlePage' => 'Editar marca',
			'template' => new templateFactory()
		);
		//ID
		$idMarcas = intval($this->url->getSegment(4));
		
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
		$data['dataFormat'] = $this->dataFormat;

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
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);

		
		if ($this->dataValidator->validate())
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
		$idMarcas = isset($_POST['idMarca']) ? filter_var($_POST['idMarca']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		

		
		if ($this->dataValidator->validate())
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
			$todos_erros = $this->dataValidator->get_errors();
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
		$this->atualizarStatus();
	}

}