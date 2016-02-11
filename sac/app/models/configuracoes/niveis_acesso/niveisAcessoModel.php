<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class niveisAcessoModel{
	private $id;
	private $nome;
	private $permissoes;
	private $indice;

	//SET
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setPermissoes($permissoes)
	{
		$this->permissoes = $permissoes;
	}
	public function setIndice($indice)
	{
		$this->indice = $indice;
	}


	//GET
	public function getId()
	{
		return $this->id;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getPermissoes()
	{
		return $this->permissoes;
	}
	public function getIndice()
	{
		return $this->indice;
	}
}
