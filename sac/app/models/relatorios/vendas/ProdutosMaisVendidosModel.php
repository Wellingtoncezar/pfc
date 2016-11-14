<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class ProdutosMaisVendidosModel implements IRelatoriosModel{
	private $produtosVendidos;
	private $qtdVendas = 0;
	private $qtdTotalProdutos = 0;

	public function setProdutoVendido(produtosVendidoModel $produtosVendidos){
		$this->produtosVendidos = $produtosVendidos;
	}
	public function getProdutosVendido(){
		return $this->produtosVendidos;
	}



	public function setQtdVendas($qtdVendas)
	{
		$this->qtdVendas = $qtdVendas;
	}
	public function getQtdVendas()
	{
		return $this->qtdVendas;
	}


	public function setQtdTotalProdutos($qtdTotalProdutos)
	{
		$this->qtdTotalProdutos = $qtdTotalProdutos;
	}
	public function getQtdTotalProdutos()
	{
		return $this->qtdTotalProdutos;
	}


	public function consultar()
	{
		return $this->produtosVendidos;
	}

}