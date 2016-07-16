<?php
/**
* Classe para delete do banco.
* @author Wellington cézar
* @version 2.2
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class delete implements IDbCrud
{
	private $paramArray;
	private $sql;

	public function __construct($elements)
	{
		$this->sql  = "DELETE  FROM ".$elements['tabela']."";
		if($elements['condicao'] != '')
		{
			$key = 1;
			while ( strstr($elements['condicao'], '?') !== false) 
			{
				$elements['condicao'] = preg_replace('/\?/', ":param".$key."", $elements['condicao'], 1);
				$key++;
			}
				
			foreach($elements['parameters'] AS $key => $val)
			{
				if(is_integer($val))
					$this->paramArray[":param".$key.""]= intval($val);	
				else
					$this->paramArray[":param".$key.""]= filter_var(trim(htmlentities($val)));
			}


			$this->sql .= " WHERE ".$elements['condicao'];
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
