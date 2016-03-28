<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class cargosModel{
	private $id;
	private $nome;
	private $setor;
	


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setSetor($setor)
	{
		$this->setor = $setor;
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
	public function getSetor()
	{
		return $this->setor;
	}

}