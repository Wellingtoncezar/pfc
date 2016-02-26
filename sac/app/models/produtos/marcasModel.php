<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class marcasModel{
	private $id;
	private $nome;
	private $status;
	private $dataCadastro;
	


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setStatus($status)
	{
		$this->status = $status;
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
 	public function getNome()
	{
		return $this->nome;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

}