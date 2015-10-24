<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class exemploModel extends Model{
	private $id;
	private $nome;
	private $idade;

	public function __construct(){
		parent::__construct();
	}

	//id
	public function setId($id)
	{
		$this->id = $id;
	}
	public function getId()
	{
		return $this->id;
	}

	//nome
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function getNome()
	{
		return $this->nome;
	}

	//idade
	public function setIdade($idade)
	{
		$this->idade = $idade;
	}
	public function getIdade()
	{
		return $this->idade;
	}
}