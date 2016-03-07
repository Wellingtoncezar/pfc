<?php
/**
* Classe para delete do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class delete extends error_db
{
	private $paramArray;
	private $sql;

	public function __construct($elements)
	{
		$this->sql  = "DELETE  FROM ".$elements['tabela']."";
		if($elements['condicao'] != '')
			$this->sql .= " WHERE ".$elements['condicao'];
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
