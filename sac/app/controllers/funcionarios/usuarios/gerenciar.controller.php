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
		$this->load->dao('funcionarios/usuariosDao');
		$this->load->dao('configuracoes/niveisAcessoDao');
		$this->load->dao('configuracoes/modulosDao');
		$this->load->dao('configuracoes/modulos/modulosModel');

		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Usuários',
			'template' => new templateFactory()

		);

		$usuarios = new usuariosDao();
		$usuariosModel = $usuarios->listar();

		foreach ($usuariosModel as $user){

			$modulosDao = new modulosDao();
			$modulosModel = $modulosDao->listar();

			$niveisAcessoDao = new niveisAcessoDao();
			$user->setNivelAcesso($niveisAcessoDao->getNivelAcesso($user->getNivelAcesso(), $modulosModel));
		}

		// print_r(expression)
		$data['usuarios'] = $usuariosModel;




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
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Cadastrar Usuários',
			'template' => new templateFactory()
		);
		$this->load->dao('funcionarios/IListagemFuncionarios');
		$this->load->dao('funcionarios/funcionariosDao');
		$funcionarios = new funcionariosDao;
		$data['funcionarios']=$funcionarios->listarAtivos();

		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveisAcesso = new niveisAcessoDao;
		$data['niveisAcesso']=$niveisAcesso->listar();
	
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
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Editar Usuários'
		);

		//ID -- obtendo o id na url -  caso não tenha redireciona para página de erro
		if($this->load->url->getSegment(4) == false)
			$this->http->redirect(URL.'error404');
		$idUsuario = intval($this->load->url->getSegment(4));
		
		//USUARIO MODEL
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId($idUsuario);

		//USUARIO DAO -- consultando o usuário a partir do id
		$this->load->dao('funcionarios/iUsuarios');
		$this->load->dao('funcionarios/consultaUsuarioPorId');
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		$usuariosModel = $usuariosDao->consultar(new consultaUsuarioPorId(), $usuariosModel, array(status::ATIVO, status::INATIVO));


		//Funcionários - consultando o funcionario a partir do usuário
		$this->load->dao('funcionarios/IListagemFuncionarios');
		$this->load->dao('funcionarios/funcionariosDao');
		$this->load->dao('funcionarios/consultaFuncionarioPorUsuario');
		$funcionarios = new funcionariosDao;
		$funcionariosModel = $funcionarios->consultar(new consultaFuncionarioPorUsuario($usuariosModel), new funcionariosModel(), array(status::ATIVO, status::INATIVO));
		
		//setando o funcionário em usuário
		$usuariosModel->setFuncionario($funcionariosModel);

		
		//Nível Acesso - listagem de todos os níveis de acesso
		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveisAcesso = new niveisAcessoDao;


		$data['usuario'] = $usuariosModel;
		$data['niveisAcesso'] = $niveisAcesso->listar();

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
	    $nivel 			= (int) $this->http->getRequest('nivel');
		$funcionario 	= $this->http->getRequest('funcionario');
		$email 			= $this->http->getRequest('email');
		$login 			= $this->http->getRequest('login');
		$senha 			= $this->http->getRequest('senha');


		//validação dos dados
		$this->load->library('dataValidator',null,true);
		
		$this->load->dataValidator->set('Nível de acesso', $nivel, 'nivel')->is_required();
		$this->load->dataValidator->set('Funcionário', $funcionario, 'funcionario')->is_required();
		$this->load->dataValidator->set('Email', $email, 'email')->is_required()->is_email();
		$this->load->dataValidator->set('Login', $login, 'login')->is_required();
		$this->load->dataValidator->set('Senha', $senha, 'senha')->is_required();
		

		if ($this->load->dataValidator->validate())
		{
			$this->load->model('funcionarios/funcionariosModel');
			$funcionariosModel = new funcionariosModel();
			$funcionariosModel->setId($funcionario);

            //USUARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setNivelAcesso($nivel);
			$usuariosModel->setFuncionario($funcionariosModel);
			$usuariosModel->setEmail($email);
			$usuariosModel->setLogin($login);
			$usuariosModel->setSenha($senha);
			$usuariosModel->setDataCadastro(date('Y-m-d h:i:s'));
            
			
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			if($usuariosDao->checkFuncionarioDuplicado($funcionariosModel))
				$this->http->response("Funcionário já possui um usuário cadastrado");
			else
				$this->http->response($usuariosDao->inserir($usuariosModel));
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }

	}



	/**
	 * Ação do editar
	 */
	public function atualizar()
	{
		$id_usuario 	= (int) $this->http->getRequest('id_usuario');
		$nivel 			= $this->http->getRequest('nivel');
		$funcionario 	= $this->http->getRequest('funcionario');
		$email 			= $this->http->getRequest('email');

		//validação dos dados
		$this->load->library('dataValidator',null,true);
		$this->load->dataValidator->set('Nível de acesso', $nivel, 'nivel')->is_required();
		$this->load->dataValidator->set('Funcionário', $funcionario, 'funcionario')->is_required();
		$this->load->dataValidator->set('Email', $email, 'email')->is_required()->is_email();
		
		

		if ($this->load->dataValidator->validate())
		{
			$this->load->model('funcionarios/funcionariosModel');
			$funcionariosModel = new funcionariosModel();
			$funcionariosModel->setId($funcionario);

            //USUARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setId($id_usuario);
			$usuariosModel->setNivelAcesso($nivel);
			$usuariosModel->setEmail($email);
			$usuariosModel->setFuncionario($funcionariosModel);

			//USUARIO DAO
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			if($usuariosDao->checkFuncionarioDuplicado($funcionariosModel, $id_usuario))
				$this->http->response("Funcionário já possui um usuário cadastrado");
			else
				$this->http->response($usuariosDao->atualizar($usuariosModel));
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }

	}

	/**
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idUsuario = (int) $this->http->getRequest('id');
		$status = $this->http->getRequest('status');

		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId( $idUsuario );
		$usuariosModel->setStatus( status::getAttribute($status));

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		$this->http->response($usuariosDao->atualizarStatus($usuariosModel));

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