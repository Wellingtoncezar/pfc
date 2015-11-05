<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class emailModel{
	private $id;
	private $email;
	private $tipo;
	private $emailExcluir;
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

	public function setExcluidos($emailExcluir)
	{
		$this->emailExcluir = $emailExcluir;
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

	public function getExcluidos()
	{
		return $this->emailExcluir;
	}


}