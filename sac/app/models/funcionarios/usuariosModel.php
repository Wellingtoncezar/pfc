<?php
/**
*@author Wellington cezar, Diego Hernandes.
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class usuariosModel{
	private $id;
	private $funcionario;
	private $login;
	private $senha;
	private $grupoFuncionario;
	private $status;
	private $dataCadastro;
	

		

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setFuncionario($funcionario)
	{
		$this->funcionario = $funcionario;
	}
    public function setLogin($login)
	{
		$this->login = $login;
	}
	public function setSenha($senha)
	{
		$this->senha = $senha;
	}
	public function setGrupoFuncionario ($grupoFuncionario)
	{
		$this->grupoFuncionario = $grupoFuncionario;
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
	public function getFuncionario()
	{
		return $this->funcionario;
	}
	public function getLogin()
	{
		return $this->login;
	}
	public function getSenha()
	{
		return $this->senha;
	}
	public function getGrupoFuncionario()
	{
		return $this->grupoFuncionario;
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