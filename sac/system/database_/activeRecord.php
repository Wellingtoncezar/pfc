<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class activeRecord{
	private $elementQuery = array();

	public function __construct() 
	{
		$this->elementQuery['tabela'] = '';
		$this->elementQuery['campos'] = '';
		$this->elementQuery['valores'] = '';
		$this->elementQuery['condicao'] = '';
		$this->elementQuery['orderBy'] = '';
		$this->elementQuery['limit'] = '';
	}

	public function setTabela($tabela)
	{
		$this->elementQuery['tabela'] = $tabela;
	}

	public function setCampos($campos)
	{
		if(is_array($campos))
			$this->elementQuery['campos'] = $campos;
		else
			die('Informe um tipo array para o metodo setCampos');
	}

	public function setValores($valores)
	{
		if(is_array($valores))
			$this->elementQuery['valores'] = $valores;
		else
			$this->elementQuery['valores'] = $this->prepare_values($valores);
	}


	public function  setCondicao($cond)
	{
		$this->elementQuery['condicao'] = $cond;
	}


	public function setOrderBy($orderBy = '')
	{
		$this->elementQuery['orderBy'] = $orderBy;
	}

	public function setLimit($limit1='', $limit2 = null)
	{
		if($limit2 != null)
			$this->elementQuery['limit'] = $limit1.','.$limit2;	
		else
			$this->elementQuery['limit'] = $limit1;	
	}

	private function prepare_values($valores)
	{
		if(count($this->elementQuery['campos']) == count($valores))
		{
			$ar_val = array();
			foreach ($this->elementQuery['campos'] as $key => $val){
				$ar_val[$val] = $this->elementQuery['valores'][$key];
			}
			return $ar_val;
		}else
		{
			die('A quantidade de campos não é compativel com a quantidade de valores');
		}
	}

	public function getElementQuery(){
		return $this->elementQuery;
	}


	public function clearElements()
	{
		$this->elementQuery['tabela'] = '';
		$this->elementQuery['campos'] = '';
		$this->elementQuery['valores'] = '';
		$this->elementQuery['condicao'] = '';
		$this->elementQuery['orderBy'] = '';
		$this->elementQuery['limit'] = '';
	}



}