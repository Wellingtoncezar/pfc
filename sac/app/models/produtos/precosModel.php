<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class precosModel{
	private $id;
	private $preco;
	private $dataInicio;
	private $dataFim;
	private $padrao;
	private $dataCadastro;

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setPreco($preco)
	{
		$this->preco = $preco;
	}
	public function setDataInicio($dataInicio)
	{
		$this->dataInicio = $dataInicio;
	}
	public function setDataFim($dataFim)
	{
		$this->dataFim = $dataFim;
	}
	public function setPadrao($padrao)
	{
		$this->padrao = $padrao;
	}
	public function setDataCadastro($dataCadastro)
	{
		$this->dataCadastro = $dataCadastro;
	}



	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getPreco()
	{
		return $this->preco;
	}
	public function getDataInicio()
	{
		return $this->dataInicio;
	}
	public function getDataFim()
	{
		return $this->dataFim;
	}
	public function getPadrao()
	{
		return $this->padrao;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

}