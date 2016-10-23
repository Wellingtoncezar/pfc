<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosVendidoModel{
	private $id;
	private $produto;
	private $quantidade;
	private $precoVendido;
	
 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setProduto(produtosModel $produto)
 	{
 		$this->produto = $produto;
 	}

 	public function setQuantidade($quantidade)
 	{
 		$this->quantidade = $quantidade;
 	}
 	public function setPrecoVendido($precoVendido)
 	{
 		$this->precoVendido = $precoVendido;
 	}
 	
 	


 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getProduto()
 	{
 		return $this->produto;
 	}

 	public function getQuantidade()
 	{
 		return $this->quantidade;
 	}
 	public function getPrecoVendido()
 	{
 		return $this->precoVendido;
 	}
 	
 	
 	
}