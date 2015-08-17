<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class grupo_usuarios extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
		//checagem do login
		$login = new loginModel();
		$login->statusLogin();

	}

	/********************************************/
	/****PÁGINAS****/
	
	/**
	*Página index
	*/
	public function index()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Grupos de Permissões de Usuários',
		);

		//grupos de usuarios
		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$modulos = new usuariosModel();
		$data['gruposUsuarios'] = $modulos->listaGruposUsuarios();

		
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/grupo_usuarios/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	*Página cadastrar
	*/
	public function cadastrar()
	{
		$this->saveAction();

		$data = array(
			'titulo' => 'Cadastrar Grupos de Permissões de Usuários',
		);

		//modulos
		$this->loadModel('configuracoes/modulos/modulosModel');
		$modulos = new modulosModel();
		$data['modulos'] = $modulos->listar(0);


		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/grupo_usuarios/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	*Página editar
	*/
	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar Grupos de Permissões de Usuários',
		);

		//modulos
		$this->loadModel('configuracoes/modulos/modulosModel');
		$modulos = new modulosModel();
		$data['modulos'] = $modulos->listar(0);

		$url = new url();
		$id = intval($url->getSegment(4));
		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$grupo = new usuariosModel();
		$grupoUsuario = $grupo->getGrupoUsuario($id);
		$data['grupoUsuario'] = $grupoUsuario;

		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/grupo_usuarios/editar',$data);
		$this->loadView('includes/baseBottom',$data);
	}




	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Cadastro de um novo registro
	*/
	public function inserir()
	{
		$nome = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$permissoes = isset($_POST['permissoes']) ? ($_POST['permissoes']) : '{}';
		//$permissoes = json_encode($permissoes);

		if(!validate::string($nome))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}

		if($this->countError >0 )
		{
			echo json_encode($this->error);
		}else
		{
			$this->loadModel('configuracoes/usuarios/usuariosModel');
			$usuarios = new usuariosModel();
			$usuarios->setNome($nome);
			$usuarios->setPermissao($permissoes);
			echo $usuarios->inserirGrupoUsuarios();
		}
		
	}

	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var(trim($_POST['id'])) : '';
		$nome = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$permissoes = isset($_POST['permissoes']) ? ($_POST['permissoes']) : '{}';
		//$permissoes = json_encode($permissoes);

		if(!validate::string($nome))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}

		if($this->countError >0 )
		{
			echo json_encode($this->error);
		}else
		{
			$this->loadModel('configuracoes/usuarios/usuariosModel');
			$usuarios = new usuariosModel();
			$usuarios->setId($id);
			$usuarios->setNome($nome);
			$usuarios->setPermissao($permissoes);
			echo $usuarios->atualizarGrupoUsuarios();
		}
		
	}

	/**
	*Exclui um registro
	*/
	public function excluir()
	{
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