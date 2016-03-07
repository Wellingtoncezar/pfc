<?php
/**
* Classe para query do banco.
* @author Wellington cézar
* @version 2.2
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class query{
	private $paramArray;
	private $sql;
	public function __construct($elements, $sql = null)
	{
		$this->sql = $sql;

		$key = 1;
		while ( strstr($this->sql, '?') !== false) 
		{
			$this->sql = preg_replace('/\?/', ":param".$key."", $this->sql, 1);
			$key++;
		}
			
		foreach($elements['parameters'] AS $key => $val)
		{
			if(is_integer($val))
				$this->paramArray[":param".$key.""]= intval($val);	
			else
				$this->paramArray[":param".$key.""]= filter_var(trim(htmlentities($val)));
		}


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