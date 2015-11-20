<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class usuariosModel{
	private $id;
	private $login;
	private $senha;
	private $status;
	private $dataCadastro;
		

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setLogin($login)
	{
		$this->foto = $login;
	}
	public function setSenha($senha)
	{
		$this->senha = $senha;
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
	public function getFoto()
	{
		return $this->foto;
	}
	public function getLogin()
	{
		return $this->login;
	}
	public function getSenha()
	{
		return $this->senha;
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