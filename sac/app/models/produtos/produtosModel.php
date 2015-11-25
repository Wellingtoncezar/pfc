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
	private $fornecedor;
	private $precocompra;
	private $porcentagemlucro;
	private $precovenda;
	private $peso;
	private $quantidade;
	private $uni_medida;
	private $estoque_max;
	private $estoque_min;
	private $dataAdmissao;
	private $salario;
	private $status;
	private $dataCadastro;
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
	public function setMarca($marca)
	{
		$this->marca = $marca;
	}
	public function setCategoria($categoria)
	{
		$this->categoria = $categoria;
	}
	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
	public function setFornecedor($fornecedor)
	{
		$this->fornecedor = $fornecedor;
	}
	public function setPrecocompra($precocompra)
	{
		$this->precocompra = $precocompra;
	}
	public function setPorcentagemlucro($porcentagemlucro)
	{
		$this->porcentagemlucro = $porcentagemlucro;
	}
	public function setPrecovenda($precovenda)
	{
		$this->precovenda = $precovenda;
	}
	public function setPeso($peso)
	{
		$this->peso = $peso;
	}
	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}
	public function setUni_medida($uni_medida)
	{
		$this->uni_medida = $uni_medida;
	}
	public function setEstoque_max($estoque_max)
	{
		$this->estoque_max = $estoque_max;
	}
	public function setEstoque_min($estoque_min)
	{
		$this->estoque_min = $estoque_min;
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
	public function getFornecedor()
	{
		return $this->fornecedor;
	}
	public function getPrecocompra()
	{
		return $this->precocompra;
	}
	public function getPorcentagemlucro()
	{
		return $this->porcentagemlucro;
	}
	public function getPrecovenda()
	{
		return $this->precovenda;
	}
	public function getPeso()
	{
		return $this->peso;
	}
	public function getQuantidade()
	{
		return $this->quantidade;
	}
	public function getUni_medida()
	{
		return $this->uni_medida;
	}
	public function getEstoque_max()
	{
		return $this->estoque_max;
	}
	public function getEstoque_min()
	{
		return $this->estoque_min;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getDataCadastro()
	{	
		return $this->dataCadastro;
	}