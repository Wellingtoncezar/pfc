<?php
/**
* Classe para update do banco.
* @author Wellington cézar
* @version 2.2
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
		if($elements['condicao'] != ''){
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
