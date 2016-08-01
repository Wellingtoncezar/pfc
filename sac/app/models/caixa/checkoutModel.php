<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class checkoutModel{
	private $id;
	private $codigo;
	private $ipmaquina;
	private $dataCadastro;
	private $ultimaAtualizacao;

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}

 	public function setCodigo($codigo)
 	{
 		$this->codigo = $codigo;
 	}
 	public function setIpmaquina($ipmaquina)
 	{
 		$this->ipmaquina = $ipmaquina;
 	}
 	public function setDataCadastro($dataCadastro)
 	{
 		$this->dataCadastro = $dataCadastro;
 	}
 	public function setUltimaAtualizacao($ultimaAtualizacao)
 	{
 		$this->ultimaAtualizacao = $ultimaAtualizacao;
 	}



 	//GET
 	public function getId()
 	{
 		return $this->id;
 	}

 	public function getCodigo()
 	{
 		return $this->codigo;
 	}
 	public function getIpmaquina()
 	{
 		return $this->ipmaquina;
 	}
 	public function getDataCadastro()
 	{
 		return $this->dataCadastro;
 	}
 	public function getUltimaAtualizacao()
 	{
 		return $this->ultimaAtualizacao;
 	}
 	
 	
 	
}