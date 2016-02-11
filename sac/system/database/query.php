<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class query{
	private $paramArray;
	private $sql;
	public function __construct($sql = null)
	{
		$this->sql = htmlentities($sql);
	}

	
	public function getQuery()
	{
		return $this->sql;
	}

	public function getParamArray()
	{
		return $this->paramArray;
	}

}	