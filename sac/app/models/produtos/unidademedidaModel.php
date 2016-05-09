<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class unidademedidaModel{
	private $id;
	private $nome;
	private $codigo;
	private $fator;
	private $ordem;
	


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}

	public function setFator($fator)
	{
		$this->fator = $fator;
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
 	public function getNome()
	{
		return $this->nome;
	}
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getFator()
	{
		return $this->fator;
	}
	public function getOrdem()
	{
		return $this->ordem;
	}

}