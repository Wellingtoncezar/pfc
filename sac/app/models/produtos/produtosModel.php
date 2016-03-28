<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosModel{
	private $id;
	private $codigo_barras;
	private $foto;
	private $nome;
	private $marca;
	private $categoria;
	private $descricao;
	private $produtoFornecedor = Array();
	private $precocusto;
	private $precovenda;
	private $markup;
	private $unidade_medida;
	private $status;
	private $dataCadastro;
	

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setCodigoBarras($codigo_barras)
	{
		$this->codigo_barras = $codigo_barras;
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
	public function setFornecedores(produtofornecedorModel $produtoFornecedor)
	{
		array_push($this->produtoFornecedor, $produtoFornecedor);
	}

	public function setPrecocusto($precocusto)
	{
		$this->precocusto = $precocusto;
	}
	public function setPrecovenda($precovenda)
	{
		$this->precovenda = $precovenda;
	}
	public function setMarkup($markup)
	{
		$this->markup = $markup;
	}
	
	public function setUnidadeMedida(unidademedidaModel $unidade_medida)
	{
		$this->unidade_medida = $unidade_medida;
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
 	public function getCodigoBarras()
	{
		return $this->codigo_barras;
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
	public function getFornecedores()
	{
		return $this->produtoFornecedor;
	}

	public function getPrecocusto()
	{
		return $this->precocusto;
	}
	public function getPrecovenda()
	{
		return $this->precovenda;
	}
	public function getMarkup()
	{
		return $this->markup;
	}
	
	public function getUnidadeMedida()
	{
		return $this->unidade_medida;
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