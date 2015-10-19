<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosModel extends Model{
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
	private $salario;
	

	public function __construct(){
		parent::__construct();
	}

 	//SETERS
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
	public function setEndereco($endereco)
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
	public function setSalario($salario)
	{
		$this->salario = $salario;
	}



	//GETERS
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
	public function getSalario()
	{
		return $this->salario;
	}



}