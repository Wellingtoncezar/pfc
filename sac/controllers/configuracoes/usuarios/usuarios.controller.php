<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class usuarios extends Controller{
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
			'titulo' => 'Usuários do sistema',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$estadocivil = new usuariosModel();
		$usuarios = $estadocivil->listarUsuarioPermissao();
		$data['usuarios'] = $usuarios;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	* Página de cadastro
	*/
	public function cadastrar(){
		$data = array(
			'titulo' => 'Cadastrar Usuários'
		);

		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$usuarios = new usuariosModel();
		$gruposUsuarios = $usuarios->listaGruposUsuarios();
		$data['gruposUsuarios'] = $gruposUsuarios;


		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	* Página de edição
	*/
	public function editar(){
		$data = array(
			'titulo' => 'Editar Usuário'
		);
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/usuarios/editar',$data);
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
		$sobrenome = isset($_POST['sobrenome']) ? filter_var(trim($_POST['sobrenome'])) : '';
		$email = isset($_POST['email']) ? filter_var(trim($_POST['email'])) : '';
		$login = isset($_POST['login']) ? filter_var(trim($_POST['login'])) : '';
		$senha = isset($_POST['senha']) ? filter_var(trim($_POST['senha'])) : '';
		$confirmsenha = isset($_POST['confirmsenha']) ? filter_var(trim($_POST['confirmsenha'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';
		$permissao = isset($_POST['permissao']) ? $_POST['permissao'] : '';

		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$usuarios = new usuariosModel();

		if(!validate::string($nome))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}

		if(!validate::string($sobrenome))
		{
			$this->countError++;
			$this->error['erro'][] = array("sobrenome"=>"Insira o sobrenome corretamente");
		}

		if(!validate::email($email))
		{
			$this->countError++;
			$this->error['erro'][] = array("email"=>"Informe o e-mail corretamente");
		}

		if(!$usuarios->emailDisponivel($email))
		{
			$this->countError++;
			$this->error['erro'][] = array("email"=>"Já existe esse e-mail cadastrado em nosso sistema");
		}


		if(!validate::string($login))
		{
			$this->countError++;
			$this->error['erro'][] = array("login"=>"Informe o login e verifique a disponibilidade");
		}

		if(!$usuarios->loginDisponivel($login))
		{
			$this->countError++;
			$this->error['erro'][] = array("login"=>"Login indisponível");
		}

		if(!validate::string($senha))
		{
			$this->countError++;
			$this->error['erro'][] = array("senha"=>"Digite sua senha");
		}

		if($senha != $confirmsenha)
		{
			$this->countError++;
			$this->error['erro'][] = array("confirmsenha"=>"As senhas não são iguais");
		}

		if(!validate::string($permissao))
		{
			$this->countError++;
			$this->error['erro'][] = array("permissao"=>"Selecione uma permissão");
		}

		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/usuarios/usuariosModel');
			$usuario = new usuariosModel();
			$usuario->setNome($nome);
			$usuario->setSobrenome($sobrenome);
			$usuario->setEmail($email);
			$usuario->setLogin($login);
			$usuario->setSenha($senha);
			$usuario->setStatus($status);
			$usuario->setPermissao($permissao);


			if($usuario->inserir())
				echo true;
			else
				echo json_encode(array('generalerror'=>'Erro ao inserir'));	
			
		}
	}



	/**
	* Atualização do status do registro
	*/
	public function atualizarStatus()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$estadoCivil = new usuariosModel();
		$estadoCivil->setId($id);
		$estadoCivil->setStatus($status);
		if($estadoCivil->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}



	/**
	* Verificação e disponibilidade de login
	*/
	public function loginDisponivel()
	{
		$login = isset($_POST['login']) ? filter_var($_POST['login']) : '';
		if(!validate::string($login))
		{
			$this->countError++;
			echo false;
		}else
		{
			$this->loadModel('configuracoes/usuarios/usuariosModel');
			$usuarios = new usuariosModel();
			echo $usuarios->loginDisponivel($login);
		
		}
	}



	/**
	* Upload da imagem
	*/
	public function uploadfoto()
	{
		$file = isset($_FILES['fotoUsuario']) ? $_FILES['fotoUsuario'] : '';
		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$usuarios = new usuariosModel();
		$usuarios->setId($_SESSION['login_adm']['id']);
		$usuarios->setFoto($file);
		$char = new caracteres($_SESSION['login_adm']['nome'].date('dmYHis'));
		$nomeArquivo = $char->getValor();
		if($usuarios->uploadFoto($nomeArquivo))
		{
			$usuarios->atualizaFoto();
		}
	}


	/**
	*Exclui um registro
	*/
	public function excluir()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('configuracoes/usuarios/usuariosModel');
		$estadoCivil = new usuariosModel();
		$estadoCivil->setId($id);
		$estadoCivil->setStatus($status);
		if($estadoCivil->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));
	}
}

/**
*
*class: usuarios
*
*location : controllers/configuracoes/usuarios/usuarios.controller.php
*/