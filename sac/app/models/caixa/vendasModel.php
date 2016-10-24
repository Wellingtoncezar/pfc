<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class vendasModel{
	private $id;
	private $dataVenda;
	private $horaVenda;
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
 	
 	
 	
}