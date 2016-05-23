<?php
/**
*@author wellington cezar e Diego Hernandes
*/
if(!defined('URL')) die('Acesso negado');
include_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.'funcionarios/usuariosModel.php');
include_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.'funcionarios/funcionariosModel.php');
include_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.'configuracoes/niveis_acesso/niveisAcessoModel.php');
class checknivelacesso{

	public function __construct()
	{
		include_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'database.php');
		//se existir a sessão 
		if(isset($_SESSION['user']))
		{
			$userSession = unserialize($_SESSION['user']);
			$indice = $userSession->getNivelAcesso()->getIndice();
			if(isset($_db[$indice]))
				$index_access_db_name = $indice; //define o indice de acesso do usuário do banco ao que foi definido pelo nivel de acesso
			else
				$index_access_db_name = 'userlogin'; // define o usuário do banco como userlogin (usuário apenas de login)
		}else
		{
			$index_access_db_name = 'default';// define o usuário do banco como userlogin (usuário apenas de login)
		}

		//cria as constantes de acesso ao banco de dados(hostname, username, password, dbname, mysqlport)
		foreach ($_db[$index_access_db_name] as $key => $value)
		{
			$key = strtoupper($key);
			define($key,$value);//constante
		}
	}

}
