<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosModel{
	private $id;
	private $foto;
	private $nome;
	private $sobrenome;
	private $dataNascimento;
	private $sexo;
	private $rg;
	private $cpf;
	private $estadoCivil;
	private $escolaridade;
	private $endereco;
	private $telefone;
	private $email;
	private $codigo;
	private $cargo;
	private $dataAdmissao;
	private $dataDemissao;
	private $status = status::ATIVO;
	private $dataCadastro;
	private $dataAtualizacao;
	private $usuario;

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setFoto($foto)
	{
		$this->foto = $foto;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setSobrenome($sobrenome)
	{
		$this->sobrenome = $sobrenome;
	}
	public function setDataNascimento($dataNascimento)
	{
		$this->dataNascimento = $dataNascimento;
	}
	public function setSexo($sexo)
	{
		$this->sexo = $sexo;
	}
	public function setRg($rg)
	{
		$this->rg = $rg;
	}
	public function setCpf($cpf)
	{
		$this->cpf = $cpf;
	}
	public function setEstadoCivil($estadoCivil)
	{
		$this->estadoCivil = $estadoCivil;
	}
	public function setEscolaridade($escolaridade)
	{
		$this->escolaridade = $escolaridade;
	}
	public function setEndereco(enderecoModel $endereco)
	{
		$this->endereco = $endereco;
	}
	public function setTelefone($telefone)
	{
		$this->telefone = $telefone;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setCargo($cargo)
	{
		$this->cargo = $cargo;
	}
	public function setDataAdmissao($dataAdmissao)
	{
		$this->dataAdmissao = $dataAdmissao;
	}
	public function setDataDemissao($dataDemissao)
	{
		$this->dataDemissao = $dataDemissao;
	}
	public function setDataCadastro($dataCadastro)
	{	
		$this->dataCadastro = $dataCadastro;
	}
	public function setDataAtualizacao($dataAtualizacao)
	{	
		$this->dataAtualizacao = $dataAtualizacao;
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

	public function setUsuario(usuariosModel $usuario)
	{
		$this->usuario = $usuario;
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
	public function getNome()
	{
		return $this->nome;
	}
	public function getSobrenome()
	{
		return $this->sobrenome;
	}
	public function getDataNascimento()
	{
		return $this->dataNascimento;
	}
	public function getSexo()
	{
		return $this->sexo;
	}
	public function getRg()
	{
		return $this->rg;
	}
	public function getCpf()
	{
		return $this->cpf;
	}
	public function getEstadoCivil()
	{
		return $this->estadoCivil;
	}
	public function getEscolaridade()
	{
		return $this->escolaridade;
	}
	public function getEndereco()
	{
		return $this->endereco;
	}
	public function getTelefone()
	{
		return $this->telefone;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getCargo()
	{
		return $this->cargo;
	}
	public function getDataAdmissao()
	{
		return $this->dataAdmissao;
	}
	public function getDataDemissao()
	{
		return $this->dataDemissao;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getDataCadastro()
	{	
		return $this->dataCadastro;
	}
	public function getDataAtualizacao()
	{	
		return $this->dataAtualizacao;
	}

	public function getUsuario()
	{
		return $this->usuario;
	}
}