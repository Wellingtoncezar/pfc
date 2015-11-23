<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class agendaModel{
	private $id;
	private $titulo;
	private $data;
	private $observacoes;
	private $dataCadastro;
	private $fornecedor;


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}
	public function setData($data)
	{
		$this->data = $data;
	}

	public function setObservacoes($observacoes)
	{
		$this->observacoes = $observacoes;
	}
	public function setDataCadastro($dataCadastro)
	{
		$this->dataCadastro = $dataCadastro;
	}
	public function setFornecedor($fornecedor)
	{
		$this->fornecedor = $fornecedor;
	}



	

	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getTitulo()
	{
		return $this->titulo;
	}
	public function getData()
	{
		return $this->data;
	}

	public function getObservacoes()
	{
		return $this->observacoes;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}
	public function getFornecedor()
	{
		return $this->fornecedor;
	}

}