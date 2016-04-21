<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class requisicoesModel{
	private $id;
	private $produto = array();
	private $quantidade;
	private $descricao;
	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}
	public function setEmail($email)
	{
		$this->email = $email;
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
	public function getEmail()
	{
		return $this->email;
	}



}