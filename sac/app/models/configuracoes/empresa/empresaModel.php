<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class fornecedoresModel{
	private $id;
	private $logo;
	private $razao_social;
	private $nome_fantasia;
	private $cnpj;
	private $proprietario;
	private $site;
	private $dataCadastro;


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setLogo($logo)
	{
		$this->logo = $logo;
	}
	public function setRazaoSocial($razao_social)
	{
		$this->razao_social = $razao_social;
	}

	public function setNomeFantasia($nome_fantasia)
	{
		$this->nome_fantasia = $nome_fantasia;
	}
	public function setCnpj($cnpj)
	{
		$this->cnpj = $cnpj;
	}
	
	public function setProprietario($proprietario)
	{
		$this->proprietario = $proprietario;
	}
	public function setSite($site)
	{
		$this->site = $site;
	}
	


	

	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getLogo()
	{
		return $this->logo;
	}
	public function getRazaoSocial()
	{
		return $this->razao_social;
	}

	public function getNomeFantasia()
	{
		return $this->nome_fantasia;
	}
	public function getCnpj()
	{
		return $this->cnpj;
	}
		public function getProprietario()
	{
		return $this->proprietario;
	}
	public function getSite()
	{
		return $this->site;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

}