<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class caixasModel{
	private $id_checkout;
	private $codigo;
	private $ip;
	private $ListOpenBox = array();
	private $dataCadastro;
	


 	//SETERS
 	public function setId($id_checkout)
 	{
 		$this->id_checkout = $id_checkout;
 	}
 	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setIp($ip)
	{
		$this->ip = $ip;
	}
	public function setListOpenBox($ListOpenBox)
	{
		$this->ListOpenBox = $ListOpenBox;
	}
	public function addListOpenBox(caixaAbertoModel $ListOpenBox)
	{
		array_push($this->ListOpenBox, $ListOpenBox);
	}
	public function setDataCadastro($dataCadastro)
	{
		$this->dataCadastro = $dataCadastro;
	}
	
		//GETERS
 	public function getId()
 	{
 		return $this->id_checkout;
 	}
 	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getIp()
	{
		return $this->ip;
	}
	public function getListOpenBox()
	{
		return $this->ListOpenBox;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

}