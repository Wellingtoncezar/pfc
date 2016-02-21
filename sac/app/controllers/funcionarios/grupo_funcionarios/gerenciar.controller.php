<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class gerenciar extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
		//checagem do login
		// $this->load->dao('loginDao');
		// $login = new loginDao();
		// $login->statusLogin();
	}

	/********************************************/
	/****PÁGINAS****/
	
	/**
	*Página index
	*/
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		$data = array(
			'titlePage' => 'Grupos de Permissões de Funcionários',
			'template' => new templateFactory()
		);

		//grupos de usuarios
		$this->load->dao('funcionarios/gruposFuncionariosDao');
		$grupos = new gruposFuncionariosDao();
		$data['gruposFuncionarios'] = $grupos->listar();


		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/grupo_funcionarios/home',$data);
		$this->load->view('includes/footer',$data);
	}

	/**
	*Página cadastrar
	*/
	public function cadastrar()
	{

		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		$data = array(
			'titlePage' => 'Cadastrar Grupos de Permissões de Usuários',
			'template' => new templateFactory()
		);

		$this->load->dao('configuracoes/modulosDao');
		$modulosDao = new modulosDao();

		$data['modulos'] = $modulosDao->listar(0);

		
		//modulos
		//$modulos->setStatus('"Ativo"');
		//$modulos->setStatusSelecao('"Ativo"');
		
		$tipo = $this->url->getSegment(4);
		
		$tipo = filter_var($tipo);
		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveisAcessoDao = new niveisAcessoDao();
		$data['niveis'] = $niveisAcessoDao->getNivelAcesso($tipo, 'index_access_db_name');
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/grupo_funcionarios/cadastrar',$data);
		$this->load->view('includes/footer',$data);
	}


	public function getPermissaoNivel()
	{
		if(isset($_POST['id']))
		{
			$id = intval($_POST['id']);
			$this->load->dao('configuracoes/niveisAcessoDao');
			$niveisAcessoDao = new niveisAcessoDao();
			$acessos = $niveisAcessoDao->getNivelAcesso($id);
			echo json_encode(array(htmlspecialchars_decode($acessos->getPermissoes())));
			//echo json_encode(array($acessos));
		}else
			return null;
	}






	/**
	*Página editar
	*/
	public function editar()
	{
		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		$data = array(
			'titlePage' => 'Editar Grupo de Permissões para Usuários',
			'template' => new templateFactory()
		);



		//modulos
		$this->load->dao('configuracoes/modulosDao');
		$modulosDao = new modulosDao();
		$data['modulos'] = $modulosDao->listar(0);

		$tipo = $this->url->getSegment(4);
		
		$tipo = filter_var($tipo);
		$this->load->dao('configuracoes/niveisAcessoDao');
		$niveisAcessoDao = new niveisAcessoDao();
		$data['niveis'] = $niveisAcessoDao->getNivelAcesso($tipo, 'index_access_db_name');


		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/grupo_funcionarios/editar',$data);
		$this->load->view('includes/footer',$data);
	}




	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Cadastro de um novo registro
	*/
	public function inserir()
	{
		$id_nivel = isset($_POST['id_nivel']) ? intval($_POST['id_nivel']) : '';
		$nome = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$permissoes = (isset($_POST['permissoes']) AND $_POST['permissoes'] != '{}') ? $_POST['permissoes'] : '';


		$validate = new DataValidator();
		$validate->set('Nome do grupo', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Permissões', $permissoes, 'permissoes')->is_required();



		if ($validate->validate())
		{
			$this->load->model('funcionarios/gruposFuncionariosModel');
			$gruposFuncionariosModel = new gruposFuncionariosModel();
			$gruposFuncionariosModel->setNome($nome);
			$gruposFuncionariosModel->setPermissao($permissoes);

			$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
			$niveisAcessoModel = new niveisAcessoModel();
			$niveisAcessoModel->setId($id_nivel);

			$gruposFuncionariosModel->setNivel($niveisAcessoModel);

			$this->load->dao('funcionarios/gruposFuncionariosDao');
			$gruposFuncionariosDao = new gruposFuncionariosDao();
			echo $gruposFuncionariosDao->inserir($gruposFuncionariosModel);
		}else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }

	}

	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var(trim($_POST['id'])) : '';
		$nome = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$permissoes = (isset($_POST['permissoes']) AND $_POST['permissoes'] != '{}') ? $_POST['permissoes'] : '';


		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Permissões', $permissoes, 'permissoes')->is_required();

		
		
		if ($validate->validate())
		{
			$this->load->model('usuarios/gruposUsuariosModel');
			$grupoUsuarios = new gruposUsuariosModel();
			$grupoUsuarios->setId($id);
			$grupoUsuarios->setNome($nome);
			$grupoUsuarios->setPermissao($permissoes);

			$this->load->dao('usuarios/gruposUsuariosDao');
			$grupoUsuariosDao = new gruposUsuariosDao();
			echo $grupoUsuariosDao->atualizar($grupoUsuarios);
		}else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }

		
		
	}

	/**
	*Exclui um registro
	*/
	public function excluir()
	{
		// $this->saveAction();
		// $checkPermissao = new checkPermissao();
		// $checkPermissao->checkPermissaoPagina();
		if(!isset($_POST['id']))
			return false;

		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$modulos = new usuariosModel();
		echo $modulos->excluirGrupoUsuario($_POST['id']);
	}


	/**
	* Verificação de disponibilidade de login
	*/
	public function loginDisponivel()
	{
		$login = isset($_POST['login']) ? filter_var($_POST['login']) : '';
		if(!validate::string($login))
		{
			$this->countError++;
			echo "Informe o login";
		}else
		{
			$this->loadModel('configuracoes/usuarios/usuariosModel');
			$usuarios = new usuariosModel();
			echo $usuarios->loginDisponivel($login);
		
		}
	}
}


/**
*
*class: grupo_usuario
*
*location : controllers/configuracoes/usuarios/grupo_usuario.controller.php
*/