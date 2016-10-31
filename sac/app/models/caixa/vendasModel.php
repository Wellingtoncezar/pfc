<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class vendasModel{
	private $id;
	private $dataVenda;
	private $horaVenda;
	private $formapagamento = formapagamento::DINHEIRO;
	private $valorpago = 0;
	private $produtosVendido = Array();
	
 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setDataVenda($dataVenda)
 	{
 		$this->dataVenda = $dataVenda;
 	}

 	public function setHoraVenda($horaVenda)
 	{
 		$this->horaVenda = $horaVenda;
 	}
 	public function setProdutoVendido($produtosVendido)
 	{
 		$this->produtosVendido = $produtosVendido;
 	}
 	public function addProdutoVendido(produtosVendidoModel $produtoVendido)
 	{
 		array_push($this->produtosVendido, $produtoVendido);
 	}
 	public function setValorPago($valorpago)
 	{
 		$this->valorpago = $valorpago;
 	}

 	public function pagarComDinheiro()
 	{
 		$this->formapagamento = formapagamento::DINHEIRO;
 	}
 	public function pagarComCartaoCredito()
 	{
 		$this->formapagamento = formapagamento::CARTAOCREDITO;
 	}
 	public function pagarComCartaoDebito()
 	{
 		$this->formapagamento = formapagamento::CARTAODEBITO;
 	}



 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getDataVenda()
 	{
 		return $this->dataVenda;
 	}

 	public function getHoraVenda()
 	{
 		return $this->horaVenda;
 	}
 	public function getProdutosVendidos()
 	{
 		return $this->produtosVendido;
 	}
 	public function getValorPago()
 	{
 		return $this->valorpago;
 	}
 	
 	public function getFormaPagamento()
 	{
 		return $this->formapagamento;
 	}
 	
}