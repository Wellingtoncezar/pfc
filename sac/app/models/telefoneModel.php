<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class telefoneModel{
	private $id;
	private $categoria;
	private $numero;
	private $tipo;
	private $operadora;
	

 	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}
	public function setNumero($numero)
	{
		$this->numero = $numero;
	}
	public function setOperadora($operadora)
	{
		$this->operadora = $operadora;
	}
	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}

	

	//GETERS
	public function getId()
	{
		return $this->id;
	}
	public function getTipo()
	{
		return $this->tipo;
	}
	public function getNumero()
	{
		return $this->numero;
	}
	public function getOperadora()
	{
		return $this->operadora;
	}
	public function getCategoria()
	{
		return $this->categoria;
	}



}