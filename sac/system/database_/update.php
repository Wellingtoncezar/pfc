<?php
/**
* Classe para update do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class update
{
	private $paramArray;
	private $sql;

	public function __construct($elements)
	{
		$campos='';
		$valores = '';
		$param = '';
		$n = count($elements['valores']);
		$i = 0;

		foreach($elements['valores'] AS $key => $val)
		{
			$key = trim($key);
			if( $i < $n-1 )
			{
				$campos .= $key.", ";
				$param .= "".$key." = :".htmlentities($key).", ";
			}
			else
			{
				$campos .= $key."";
				$param .= "".$key." = :".htmlentities($key)."";
			}
			$this->paramArray[":".$key.""]= filter_var(trim(htmlentities($val)));
			$i++;
		}

		$this->sql  = "UPDATE ".$elements['tabela']." SET ".$param."";
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
