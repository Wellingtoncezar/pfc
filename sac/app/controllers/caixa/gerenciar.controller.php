<?php
/*
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
	*Página index
	*/
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Caixa'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/home',$data);
		$this->load->view('includes/footer',$data);
	}

	public function checkout()
	{
		// $saveRouter = new saveRouter;
		// $saveRouter->saveModule();
		// $saveRouter->saveAction();
		// $this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Caixa'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/telacheckout1',$data);
		$this->load->view('includes/footer',$data);
	}

	public function getInfoUser(){
		$cookie_name = "user";
		$cookie_value = "John Doe";
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

		if(!isset($_COOKIE[$cookie_name])) {
		    echo "Cookie named '" . $cookie_name . "' is not set!";
		} else {
		    echo "Cookie '" . $cookie_name . "' is set!<br>";
		    echo "Value is: " . $_COOKIE[$cookie_name];
		}
	
		/*$indicesServer = array(
			'PHP_SELF', 
			'argv', 
			'argc', 
			'GATEWAY_INTERFACE', 
			'SERVER_ADDR', 
			'SERVER_NAME', 
			'SERVER_SOFTWARE', 
			'SERVER_PROTOCOL', 
			'REQUEST_METHOD', 
			'REQUEST_TIME', 
			'REQUEST_TIME_FLOAT', 
			'QUERY_STRING', 
			'DOCUMENT_ROOT', 
			'HTTP_ACCEPT', 
			'HTTP_ACCEPT_CHARSET', 
			'HTTP_ACCEPT_ENCODING', 
			'HTTP_ACCEPT_LANGUAGE', 
			'HTTP_CONNECTION', 
			'HTTP_HOST', 
			'HTTP_REFERER', 
			'HTTP_USER_AGENT', 
			'HTTPS', 
			'REMOTE_ADDR', 
			'REMOTE_HOST', 
			'REMOTE_PORT', 
			'REMOTE_USER', 
			'REDIRECT_REMOTE_USER', 
			'SCRIPT_FILENAME', 
			'SERVER_ADMIN', 
			'SERVER_PORT', 
			'SERVER_SIGNATURE', 
			'PATH_TRANSLATED', 
			'SCRIPT_NAME', 
			'REQUEST_URI', 
			'PHP_AUTH_DIGEST', 
			'PHP_AUTH_USER', 
			'PHP_AUTH_PW', 
			'AUTH_TYPE', 
			'PATH_INFO', 
			'ORIG_PATH_INFO') ; 

			echo '<table cellpadding="10">' ; 
			foreach ($indicesServer as $arg) { 
			    if (isset($_SERVER[$arg])) { 
			        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
			    } 
			    else { 
			        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
			    } 
			} 
			echo '</table>' ; 
			*/
	}
	
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
