<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class marca extends Controller{
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
			'titlePage' => 'Gerenciar Marca'
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
			'titlePage' => 'Cadastrar marcas'
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
			'titlePage' => 'Editar marca'
		);
		//ID
		$idMarcas = intval($this->url->getSegment(3));
		
		//marca MODEL
		$this->load->model('produtos/marcasModel');
		$marcasModel = new marcasModel();
		$marcasModel->setId($idMarcas);

		//marca DAO
		$this->load->dao('produtos/marcasDao');
		$marcasDao = new marcasDao();
		$data['marca'] = $marcasDao->consultar($marcasModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat');
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
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);

		

		
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
		$idMarcas = isset($_POST['idMarcas']) ? filter_var($_POST['idMarcas']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';


		//validação dos dados
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		

		

		
			//CATEGORIA
			$this->load->model('produtos/marcasModel');
			$marcasDao = new marcasDao();
			$marcasDao->setId($idMarcas);
			$marcasDao->setNome($nome);
			$marcasDao->setStatus(status::ATIVO);
			$marcasDao->setDataCadastro(date('Y-m-d h:i:s'));


			//CATEGORIA DAO
			$this->load->dao('produtos/marcasDao');
			$marcasDao = new marcasDao();
			echo $marcasDao->atualizar($marcasDao);
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