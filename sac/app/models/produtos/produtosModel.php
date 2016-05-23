<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosModel{
	private $id;
	private $foto;
	private $nome;
	private $marca;
	private $categoria;
	private $descricao;
	private $unidadeMedida = Array();
	private $precoVenda;
	private $markup;
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
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setMarca(marcasModel $marca)
	{
		$this->marca = $marca;
	}
	public function setCategoria(categoriasModel $categoria)
	{
		$this->categoria = $categoria;
	}
	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
	public function setUnidadeMedida(unidademedidaModel $unidadeMedida)
	{
		array_push($this->unidadeMedida, $unidadeMedida);
	}

	public function setPrecoVenda($precoVenda)
	{
		$this->precoVenda = $precoVenda;
	}
	public function setMarkup($markup)
	{
		$this->markup = $markup;
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
	public function getNome()
	{
		return $this->nome;
	}
	public function getMarca()
	{
		return $this->marca;
	}
	public function getCategoria()
	{
		return $this->categoria;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
		
	public function getUnidadeMedida()
	{
		return $this->unidadeMedida;
	}

	public function getPrecoVenda()
	{
		return $this->precoVenda;
	}

	public function getMarkup()
	{
		return $this->markup;
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