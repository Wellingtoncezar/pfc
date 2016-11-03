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
	private $email;
	private $nivelAcesso;
	private $status = status::ATIVO;
	private $dataCadastro;
	private $hash;
	private $isUserAdministrator = false;

		

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setFuncionario(funcionariosModel $funcionario)
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
	public function setNivelAcesso (niveisAcessoModel $nivelAcesso)
	{
		$this->nivelAcesso = $nivelAcesso;
	}
	public function setEmail ($email)
	{
		$this->email = $email;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}
	public function ativar()
	{
		$this->status = status::ATIVO;
	}
	public function inativar()
	{
		$this->status = status::INATIVO;
	}
	public function excluir()
	{
		$this->status = status::EXCLUIDO;
	}

	public function setDataCadastro($dataCadastro)
	{	
		$this->dataCadastro = $dataCadastro;
	}
	public function setHash($hash)
	{	
		$this->hash = $hash;
	}
	public function setUserAdministrator($isUserAdministrator)
	{
		$this->isUserAdministrator = $isUserAdministrator;
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
	public function getNivelAcesso()
	{
		return $this->nivelAcesso;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function getStatus()
	{
		return $this->status;
	}
	public function getDataCadastro()
	{	
		return $this->dataCadastro;
	}
	public function getHash($hash)
	{	
		return $this->hash;
	}



}