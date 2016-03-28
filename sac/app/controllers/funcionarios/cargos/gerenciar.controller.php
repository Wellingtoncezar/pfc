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

		$data = array(
			'titlePage' => 'Gerenciar Cargos',
			'template' => new templateFactory()
		);

		$this->load->dao('funcionarios/cargosDao');
		$cargos = new cargosDao();
		$data['cargos'] = $cargos->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cargos/home',$data);
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

		$data = array(
			'titlePage' => 'Cadastrar categoria',
			'template' => new templateFactory()
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cargos/cadastro',$data);
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

		$data = array(
			'titlePage' => 'Editar cargo',
			'template' => new templateFactory()
		);
		//ID
		$idcargo = intval($this->url->getSegment(4));
		
		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/cargosModel');
		$cargosModel = new cargosModel();
		$cargosModel->setId($idcargo);

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/cargosDao');
		$cargosDao = new cargosDao();
		$data['cargo'] = $cargosDao->consultar($cargosModel);
		


		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cargos/editar',$data);
		$this->load->view('includes/footer',$data);
	}



	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$setor = isset($_POST['setor']) ? filter_var($_POST['setor']) : '';

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->dataValidator->set('Setor', $setor, 'setor')->is_required()->min_length(2);
		
		if ($this->dataValidator->validate())
		{
			//CARGOS MODEL
			$this->load->model('funcionarios/cargosModel');
			$cargosModel = new cargosModel();
			
			$cargosModel->setNome($nome);
			$cargosModel->setSetor($setor);


			//CARGOS DAO
			$this->load->dao('funcionarios/cargosDao');
			$cargosDao = new cargosDao();
			echo $cargosDao->inserir($cargosModel);
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
		$idCargo = isset($_POST['idCargo']) ? filter_var($_POST['idCargo']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$setor = isset($_POST['setor']) ? filter_var($_POST['setor']) : '';

		//validação dos dados
		$this->load->library('dataValidator' ,null, true);
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->dataValidator->set('Setor', $setor, 'setor')->is_required()->min_length(2);

		
		if ($this->dataValidator->validate())
		{
		
			//CARGO
			$this->load->model('funcionarios/cargosModel');
			$cargosModel = new cargosModel();
			$cargosModel->setId($idCargo);
			$cargosModel->setNome($nome);
			$cargosModel->setSetor($setor);


			//SETOR DAO
			$this->load->dao('funcionarios/cargosDao');
			$cargosDao = new cargosDao();
			echo $cargosDao->atualizar($cargosModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}


	public function excluir()
	{
		$idCargo = intval($_POST['id']);

		//CARGOS MODEL
		$this->load->model('funcionarios/cargosModel');
		$cargosModel = new cargosModel();
		$cargosModel->setId( $idCargo );

		//CARGOS DAO
		$this->load->dao('funcionarios/cargosDao');
		$cargosDao = new cargosDao();
		echo $cargosDao->excluir($cargosModel);
	}

}