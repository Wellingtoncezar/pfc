<?php 
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
session_start();
header('Content-Type: text/html; charset=utf-8');
define('SYSTEMPATH','system');
define('LIBRARYPATH','library');
define('APPPATH','app');
if (!version_compare(PHP_VERSION, '5.4.0', '>=')): 
	echo 'I am at least PHP version 5.4.0, my version: ' . PHP_VERSION . "\n"; 
	exit; 
endif;

require_once('include.php');
config::getInstance();
config::getConfig();

class _initialize extends Router{
	public function __construct(){
		parent::__construct();
		
		$this->explodeUri();

		/*
		apenas para checagem dos caminhos
		//echo '<p>ROUT FILE: '.$routFile.'</p>';
		echo '<pre >';
		echo '<p>ROTA COMPLETA: '.$this->getRoute().'</p>';
		echo '<p>NOME Controller: '.$this->getController().'</p>';
		echo '<p>NOME METODO: '.$this->getAction().'</p>';
		echo '</pre>';
		*/

		define('ROUTE', $this->getRoute());
		define('CONTROLLER', $this->getController());
		define('ACTION', $this->getAction());
		
		$filename = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.ROUTE.CONTROLLER.'.controller.php';
		
		if(file_exists($filename))
		{
			require_once($filename);
			$_controllerName = CONTROLLER;
			$_controller = new $_controllerName();

			$action = ACTION;
			if(method_exists($_controller, $action))
			{
				$_controller->$action();
			}else
			{
				$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>
								";
				require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
			}
		}else{

			$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
			require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
		}
	}
}

new _initialize;
