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
			'titlePage' => 'Usuários',
			'template' => new templateFactory()

		);

		$this->load->dao('funcionarios/usuariosDao');
		$usuarios = new usuariosDao();
		$data['usuarios'] = $usuarios->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuarios/home',$data);
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
			'titlePage' => 'Cadastrar Usuários',
			'template' => new templateFactory()
		);
		$this->load->dao('funcionarios/funcionariosDao');
		$funcionarios = new funcionariosDao;
		$data['funcionarios']=$funcionarios->listar();

		$this->load->dao('funcionarios/gruposFuncionariosDao');
		$gruposfuncionarios = new gruposFuncionariosDao;
		$data['grupo_funcionarios']=$gruposfuncionarios->listar();
	
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuarios/cadastro',$data);
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
			'titlePage' => 'Editar Usuários',
			'template' => new templateFactory()
		);
		//ID
		$idUsuario = intval($this->url->getSegment(4));
		
		//USUARIO MODEL
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId($idUsuario);

		//USUARIOS DAO
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		$data['usuarios'] = $usuariosDao->consultar($usuariosModel);


		$this->load->dao('funcionarios/gruposFuncionariosDao');
		$gruposfuncionarios = new gruposFuncionariosDao;
		$data['grupo_funcionarios']=$gruposfuncionarios->listar();
		
		
		//DATAFORMAT
		$this->load->library('dataFormat',null,true);
		$data['dataFormat'] = $this->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuarios/editar',$data);
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
	    $grupo = isset($_POST['grupo']) ? intval($_POST['grupo']) : '';
		$funcionario = isset($_POST['funcionario']) ? intval($_POST['funcionario']) : '';
		$email = isset($_POST['email']) ? filter_var(trim($_POST['email'])) : '';
		$login = isset($_POST['login']) ? filter_var($_POST['login']) : '';
		$senha = isset($_POST['senha']) ? filter_var($_POST['senha']) : '';


		//validação dos dados
		$this->load->library('dataValidator',null,true);
		
		$this->dataValidator->set('Grupo', $grupo, 'grupo')->is_required();
		$this->dataValidator->set('Funcionario', $funcionario, 'funcionario')->is_required();
		$this->dataValidator->set('Email', $email, 'email')->is_required()->is_email();
		$this->dataValidator->set('Login', $login, 'login')->is_required();
		$this->dataValidator->set('Senha', $senha, 'senha')->is_required();
		

		if ($this->dataValidator->validate())
		{
            //USUARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setGrupoFuncionario($grupo);
			$usuariosModel->setFuncionario($funcionario);
			$usuariosModel->setEmail($email);
			$usuariosModel->setLogin($login);
			$usuariosModel->setSenha($senha);
			$usuariosModel->setStatus(status::ATIVO);
			$usuariosModel->setDataCadastro(date('Y-m-d h:i:s'));
            

			//USUARIO DAO
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			echo $usuariosDao->inserir($usuariosModel);
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
		$id = isset($_POST['id']) ? intval($_POST['id']):'';
		$grupo = isset($_POST['grupo']) ? intval($_POST['grupo']) : '';
		$email = isset($_POST['email']) ? filter_var(trim($_POST['email'])) : '';
		$login = isset($_POST['login']) ? filter_var($_POST['login']) : '';


		//validação dos dados
		$this->load->library('dataValidator',null, true);
		
		$this->dataValidator->set('Grupo', $grupo, 'grupo')->is_required();
		$this->dataValidator->set('Email', $email, 'email')->is_required();
		$this->dataValidator->set('Login', $login, 'login')->is_required();
		
		

		if ($this->dataValidator->validate())
		{
            //USUARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setId($id);
			$usuariosModel->setGrupoFuncionario($grupo);
			$usuariosModel->setEmail($email);
			$usuariosModel->setLogin($login);
		
            

			//USUARIO DAO
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			echo $usuariosDao->atualizar($usuariosModel);
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
		$idUsuario = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId( $idUsuario );
		$usuariosModel->setStatus( status::getAttribute($status));

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		echo $usuariosDao->atualizarStatus($usuariosModel);

	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->atualizarStatus();
	}

}