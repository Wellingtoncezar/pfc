<?php
/**
* @author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class login extends Controller{
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['ntentativaLogin']))
			$_SESSION['ntentativaLogin'] = 0;

		//echo $_SESSION['login_adm']['token'];
	}

	/********************************************/
	/****PÁGINAS****/


	/**
	*Página index
	*/
	public function index()
	{
		$data = array(
			'titlePage' => 'Login',
			'keywords' => '',
			'description' => ''
		);

		$this->load->view('login',$data);
	}


	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* loagin no sistema
	*/
	public function logar(){
		if(!isset($_POST['login']) || !isset($_POST['senha']))
			return false;

		$login = isset($_POST['login']) ? filter_var($_POST['login']) : '';
		$senha = isset($_POST['senha']) ? filter_var($_POST['senha']) : '';
		$captcha = isset($_POST['captcha']) ? filter_var($_POST['captcha']) : '';
		$this->load->model('loginModel');
		$this->loginModel->setLogin($login);
		$this->loginModel->setSenha($senha);
		$this->loginModel->setCaptcha($captcha);

		$this->load->dao('loginDao');
		echo $this->loginDao->logar($this->loginModel);
		//echo $this->login->logar($login,$senha,$captcha);
	}

	/**
	* Cria o captcha caso o número de tentativas de login falhos seja maior ou igual a 5
	*/
	public function captcha()
	{
		$captcha = new captcha();
		if($_SESSION['ntentativaLogin'] >= 5)
		{
			$captcha->CreateImage();

		}else
			echo false;
	}

	/**
	*verifica números de tentativa falhas de login
	*/
	public function verificaNTentativaLogin()
	{
		if($_SESSION['ntentativaLogin'] >= 5)
			echo true;
		else
			echo false;
	}


	/**
	* Encerra a sessão
	*/
	public function sair()
	{
		session_destroy();
		header('Location: '.URL.'login');
	}
}

/**
*
*class: login
*
*location : controllers/login.controller.php
*/