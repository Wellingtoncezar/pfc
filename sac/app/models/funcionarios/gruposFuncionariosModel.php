<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gruposFuncionariosModel extends Model{
	private $id;
	private $nome;
	private $permissao;
	private $nivel;

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

	//permissao
	public function setPermissao($permissao)
	{
		$this->permissao = $permissao;
	}
	public function getPermissao()
	{
		return $this->permissao;
	}

	//Nível
	public function setNivel(niveisAcessoModel $nivel)
	{
		$this->nivel = $nivel;
	}
	public function getNivel()
	{
		return $this->nivel;
	}

}