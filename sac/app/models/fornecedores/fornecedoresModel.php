<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class fornecedoresModel{
	private $id;
	private $foto;
	private $razao_social;
	private $nome_fantasia;
	private $cnpj;
	private $cpf;
	private $pessoa;
	private $site;
	private $observacoes;
	private $nome_contato;
	private $endereco;
	private $telefones = Array();
	private $email = Array();
	private $data_visita;
	private $retorno;
	private $status;
	private $dataCadastro;


 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setFoto($foto)
	{
		$this->foto = $foto;
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
	public function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}
	public function setPessoa($pessoa)
	{
		$this->pessoa = $pessoa;
	}
	public function setSite($site)
	{
		$this->site = $site;
	}
	public function setObservacoes($observacoes)
	{
		$this->observacoes = $observacoes;
	}
	public function setNomeContato($nome_contato)
	{
		$this->nome_contato = $nome_contato;
	}
	public function setEndereco($endereco)
	{
		$this->endereco = $endereco;
	}
	public function setTelefones($telefones)
	{
		$this->telefones = $telefones;
	}
	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function setDataVisita($data_visita)
	{
		$this->data_visita = $data_visita;
	}
	public function setRetorno($retorno)
	{
		$this->retorno = $retorno;
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
	public function getCpf()
	{
		return $this->cpf;
	}
	public function getPessoa()
	{
		return $this->pessoa;
	}
	public function getSite()
	{
		return $this->site;
	}
	public function getObservacoes()
	{
		return $this->observacoes;
	}
	public function getNomeContato()
	{
		return $this->nome_contato;
	}
	public function getEndereco()
	{
		return $this->endereco;
	}
	public function getTelefones()
	{
		return $this->telefones;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getDataVisita()
	{
		return $this->data_visita;
	}
	public function getRetorno()
	{
		return $this->retorno;
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