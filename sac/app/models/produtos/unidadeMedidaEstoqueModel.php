<?php
/**
*@author Wellington cezar, Diego Hernandes
*/

if(!defined('BASEPATH')) die('Acesso não permitido');
class unidadeMedidaEstoqueModel{
	private $id;
	private $unidadeMedida;
	private $fator;
	private $paraVenda;
	private $paraEstoque;
	private $ordem;
	


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 
	public function setUnidadeMedida(unidadeMedidaModel $unidadeMedida)
	{
		$this->unidadeMedida = $unidadeMedida;
	}

	public function setFator($fator)
	{
		$this->fator = $fator;
	}
	public function setParaVenda($paraVenda)
	{
		$this->paraVenda = $paraVenda;
	}
	public function setParaEstoque ($paraEstoque)
	{
		$this->paraEstoque  = $paraEstoque;
	}

	public function setOrdem($ordem)
	{
		$this->ordem = $ordem;
	}
	

	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getUnidadeMedida()
	{
		return $this->unidadeMedida;
	}
	public function getFator()
	{
		return $this->fator;
	}
	public function getParaVenda()
	{
		return $this->paraVenda;
	}
	public function getParaEstoque()
	{
		return $this->paraEstoque;
	}
	public function getOrdem()
	{
		return $this->ordem;
	}

}


