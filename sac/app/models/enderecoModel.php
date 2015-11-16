<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class enderecoModel{
	private $id;
	private $cep;
	private $numero;
	private $complemento;
	private $logradouro;
	private $bairro;
	private $cidade;
	private $estado;


 	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setCep($cep)
	{
		$this->cep = $cep;
	}
	public function setNumero($numero)
	{
		$this->numero = $numero;
	}
	public function setComplemento($complemento)
	{
		$this->complemento = $complemento;
	}
	public function setLogradouro($logradouro)
	{
		$this->logradouro = $logradouro;
	}
	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}
	public function setCidade($cidade)
	{
		$this->cidade = $cidade;
	}
	public function setEstado($estado)
	{
		$this->estado = $estado;
	}

	//GETERS
	public function getId()
	{
		return $this->id;
	}
	public function getCep()
	{
		return $this->cep;
	}
	public function getNumero()
	{
		return $this->numero;
	}
	public function getComplemento()
	{
		return $this->complemento;
	}
	public function getLogradouro()
	{
		return $this->logradouro;
	}
	public function getBairro()
	{
		return $this->bairro;
	}
	public function getCidade()
	{
		return $this->cidade;
	}
	public function getEstado()
	{
		return $this->estado;
	}


}