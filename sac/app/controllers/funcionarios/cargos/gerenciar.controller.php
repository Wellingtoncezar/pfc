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
		$this->load->checkPermissao->check();

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
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Editar cargo',
			'template' => new templateFactory()
		);
		//ID
		if($this->load->url->getSegment(4) == false)
			$this->http->redirect(URL.'error404');
		$idcargo = intval($this->load->url->getSegment(4));
		
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
		
		$nome = filter_var($this->http->getRequest('nome'));
		$setor = filter_var($this->http->getRequest('setor'));

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(1);
		$this->load->dataValidator->set('Setor', $setor, 'setor')->is_required()->min_length(1);
		
		if ($this->load->dataValidator->validate())
		{
			//CARGOS MODEL
			$this->load->model('funcionarios/cargosModel');
			$cargosModel = new cargosModel();
			
			$cargosModel->setNome($nome);
			$cargosModel->setSetor($setor);


			//CARGOS DAO
			$this->load->dao('funcionarios/cargosDao');
			$cargosDao = new cargosDao();
			$this->http->response($cargosDao->inserir($cargosModel));
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
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
		$idCargo = (int) $this->http->getRequest('idCargo');
		$nome = filter_var($this->http->getRequest('nome'));
		$setor = filter_var($this->http->getRequest('setor'));

		//validação dos dados
		$this->load->library('dataValidator' ,null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(1);
		$this->load->dataValidator->set('Setor', $setor, 'setor')->is_required()->min_length(1);

		
		if ($this->load->dataValidator->validate())
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
			$this->http->response($cargosDao->atualizar($cargosModel));
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }

	}


	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		
		$idCargo = (int) $this->http->getRequest('id');

		//CARGOS MODEL
		$this->load->model('funcionarios/cargosModel');
		$cargosModel = new cargosModel();
		$cargosModel->setId( $idCargo );

		//CARGOS DAO
		$this->load->dao('funcionarios/cargosDao');
		$cargosDao = new cargosDao();
		$this->http->response($cargosDao->excluir($cargosModel));
	}

}