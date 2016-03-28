<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class unidademedidaModel{
	private $id;
	private $nome;
	private $abreviacao;
	


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function setAbreviacao($abreviacao)
	{
		$this->abreviacao = $abreviacao;
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
	public function getAbreviacao()
	{
		return $this->abreviacao;
	}

}