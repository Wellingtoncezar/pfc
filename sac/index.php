<?php 
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
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


class _initialize{
	public function __construct(){
		// parent::__construct();
		config::getInstance();
		config::getConfig();

		$router = new Router();
		$router->explodeUri();

		/*
		apenas para checagem dos caminhos
		//echo '<p>ROUT FILE: '.$routFile.'</p>';
		echo '<pre >';
		echo '<p>ROTA COMPLETA: '.$this->getRoute().'</p>';
		echo '<p>NOME Controller: '.$this->getController().'</p>';
		echo '<p>NOME METODO: '.$this->getAction().'</p>';
		echo '</pre>';
		*/

		define('ROUTE', $router->getRoute());
		define('CONTROLLER', $router->getController());
		define('ACTION', $router->getAction());
		
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
				require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.'error404.controller.php');
				$errorController = new error404();
				$errorController->index();
			}
		}else{
			require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.'error404.controller.php');
			$errorController = new error404();
			$errorController->index();
		}
	}
}

new _initialize;
