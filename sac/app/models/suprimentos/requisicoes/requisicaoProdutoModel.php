<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class requisicaoProdutoModel{
	private $id;
	private $produto;
	private $quantidade;
	private $status;
	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function addProduto(produtosModel $produto)
	{
		$this->produto = $produto;
	}
	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}
	

	//GETERS
	public function getId()
	{
		return $this->id;
	}
	public function getProdutos()
	{
		return $this->produto;
	}
	public function getQuantidade()
	{
		return $this->quantidade;
	}
	public function getStatus()
	{
		return $this->status;
	}
}