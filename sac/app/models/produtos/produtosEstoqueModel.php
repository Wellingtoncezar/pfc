<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosEstoqueModel extends produtosModel{
	private $idProdutoEstoque;
	private $quantidadeMaxima;
	private $quantidadeMinima;
	private $quantidade;
	private $lotes = Array();

 	//SETERS
 	public function setIdProdutoEstoque($idProdutoEstoque)
 	{
 		$this->idProdutoEstoque = $idProdutoEstoque;
 	}

 	public function setQuantidadeMinima($quantidadeMinima)
 	{
 		$this->quantidadeMinima;
 	}

 	public function setQuantidadeMaxima($quantidadeMaxima)
 	{
 		$this->quantidadeMaxima;
 	}

 	public function setPrecos($precos)
 	{
 		$this->precos = $precos;
 	}

 	public function addPreco(tabelaPrecosModel $preco)
 	{
 		array_push($this->precos, $preco);
 	}

 	public function setLotes($lotes)
 	{
 		$this->lotes = $lotes;
 	}

 	public function addLote(loteModel $lote)
 	{
 		array_push($this->lote, $lote);
 	}
}