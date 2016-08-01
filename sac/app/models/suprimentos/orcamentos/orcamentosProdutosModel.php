<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class orcamentosProdutosModel{
	private $id;
	private $produto;
	private $quantidade;
	private $preco;
	private $status = statusRequisicoes::NOVO;
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
		public function setPreco($preco)
	{
		$this->preco = $preco;
	}

	public function aprovar()
	{
		$this->status = statusRequisicoes::APROVADO;
	}
	public function reprovar()
	{
		$this->status = statusRequisicoes::REPROVADO;
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
	public function getPreco()
	{
		return $this->preco;
	}
	public function getStatus()
	{
		return $this->status;
	}
}