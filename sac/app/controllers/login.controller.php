<?php
/**
*@author Wellington cezar, Diego Hernandes
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



	/**
	* loagin no sistema
	*/
	public function logar(){
		
	}

}