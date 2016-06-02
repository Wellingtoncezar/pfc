<?php
/**
* Classe obtem as requisições http
* @access 
* @author Wellington cézar
* @since 28/05/2016
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class httpRequest {
	private $requestMethod;
	private $typeOf = 'string';
	public function __construct()
	{
		$this->requestMethod = $_SERVER['REQUEST_METHOD'];
	} 

	public function getRequestMethod()
	{
		return $this->requestMethod;
	}
	public function getParameter($parafield, $typeof = 'string'){
		$value = null;
		if($typeof == 'files')
		{
			if(isset($_FILES[$parafield]))
				$value = $_FILES[$parafield];
		}else
		if($this->requestMethod == 'POST')
		{
			if(isset($_POST[$parafield]))
				$value = $_POST[$parafield];
		}else
		if($this->requestMethod == 'GET')
		{
			if(isset($_GET[$parafield]))
				$value = $_GET[$parafield];
		}

		return $this->filterVar($value, $typeof);
	}

	private function filterVar($value = null, $typeof = 'string')
	{
		if($typeof == 'files')
			return (!empty($value)) ? filter_var_array($value) : array();
		else
		if($typeof == 'int')
			return (!empty($value)) ? intval($value) : null;
		else
		if($typeof == 'string' && !empty($value))
			return (!empty($value)) ? filter_var($value) : '';
		else
		if($typeof == 'array' && !empty($value))
			return (!empty($value)) ? filter_var_array($value) : array();
	}





	

	
}