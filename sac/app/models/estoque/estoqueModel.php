<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class estoqueModel{
	private $id;
	private $produto;
	private $quantidade_minima;
	private $quantidade_maxima;
	private $quantidade_total;
	private $lotes = Array();
	
	//set
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setProduto(produtosModel $produto)
	{
		$this->produto = $produto;
	}
	public function setQuantidadeMinima($quantidade_minima)
	{
		$this->quantidade_minima = $quantidade_minima;
	}
	public function setQuantidadeMaxima($quantidade_maxima)
	{
		$this->quantidade_maxima = $quantidade_maxima;
	}
	public function setQuantidadeTotal($quantidade_total)
	{
		$this->quantidade_total = $quantidade_total;
	}
	public function setLotes($lotes)
	{
		$this->lotes = $lotes;
	}
	public function addLote(lotesModel $lote)
	{
		array_push($this->lotes, $lote);
	}


	//get
	public function getId()
	{
		return $this->id;
	}
	public function getProduto()
	{
		return $this->produto;
	}
	public function getQuantidadeMinima()
	{
		return $this->quantidade_minima;
	}
	public function getQuantidadeMaxima()
	{
		return $this->quantidade_maxima;
	}
	public function getQuantidadeTotal()
	{	
		$valorUndEstoque = 0;
		foreach ($this->lotes as $lotes){
			foreach ($lotes->getLocalizacao() as $localizacao){
				$fatorUnidadeLote = $localizacao->getUnidadeMedidaEstoque()->getFator();
				$qtdLoteLocal = $localizacao->getQuantidade(); //quantidade do lote por localização
				$valorUndEstoque += ((double)$qtdLoteLocal * (double)$fatorUnidadeLote) / $this->getUnidadeMedidaParaEstoque()->getFator();
			}
		}

		$this->quantidade_total = $valorUndEstoque;


		return $this->quantidade_total;
	}

	public function getUnidadeMedidaParaEstoque()
	{
		$unidadeMedidaEstoque = null;
		foreach ($this->produto->getUnidadeMedidaEstoque() as $undMed){
			if($undMed->getParaEstoque()){
				$unidadeMedidaEstoque = $undMed;
			}
		}
		return $unidadeMedidaEstoque;
	}

	public function getLotes()
	{
		return $this->lotes;
	}



}