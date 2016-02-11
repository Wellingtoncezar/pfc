<?php
/**
* Classe para select do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 2.0
*
*/

if(!defined('BASEPATH')) die('Acesso não permitido');
class select
{
	private $paramArray;
	private $sql;
	public function __construct( $elements)
	{
		if($elements['campos'] != null)
		{
			$campos = '';
			$campos = implode(', ', $elements['campos']);
		}else
			$campos = '*';

		$this->sql  = "SELECT ".$campos." FROM ".$elements['tabela']." ";
		if($elements['condicao'] != '')
			$this->sql .= " WHERE ".trim($elements['condicao']);

		if($elements['orderBy'] != '')
			$this->sql .= " ORDER BY ".trim($elements['orderBy']);

		if($elements['limit'] != '')
			$this->sql .= " LIMIT ".trim($elements['limit']);
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
