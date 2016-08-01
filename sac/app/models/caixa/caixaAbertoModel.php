<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class caixaAbertoModel{
	private $id;
	private $usuario;
	private $saldoInicial;
	private $saldoFinal;
	private $dataAbertura;
	private $ultimaAtualizacao;
	
 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setUsuario(usuariosModel $usuario)
 	{
 		$this->usuario = $usuario;
 	}

 	public function setSaldoInicial($saldoInicial)
 	{
 		$this->saldoInicial = $saldoInicial;
 	}
 	public function setSaldoFinal($saldoFinal)
 	{
 		$this->saldoFinal = $saldoFinal;
 	}
 	public function setDataAbertura($dataAbertura)
 	{
 		$this->dataAbertura = $dataAbertura;
 	}
 	public function setDataFechamento($dataFechamento)
 	{
 		$this->dataFechamento = $dataFechamento;
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

 	public function getSaldoInicial()
 	{
 		return $this->saldoInicial;
 	}
 	public function getSaldoFinal()
 	{
 		return $this->saldoFinal;
 	}
 	public function getDataAbertura()
 	{
 		return $this->dataAbertura;
 	}
 	public function getDataFechamento()
 	{
 		return $this->dataFechamento;
 	}
 	public function getUltimaAtualizacao()
 	{
 		return $this->ultimaAtualizacao;
 	}
 	
 	
 	
}