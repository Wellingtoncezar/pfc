<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class lotesModel{
	private $id;
	private $codigoBarra;
	private $preco;
	private $pedido;
	private $quantidade;
	private $dataValidade;
	private $ocorrencia;
	private $observacoes;
	private $lotes = Array();

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}

 	public function setCodigoBarra($codigoBarra)
 	{
 		$this->codigoBarra = $codigoBarra;
 	}
 	public function setPreco($preco)
 	{
 		$this->preco = $preco;
 	}
 	public function setPedido(pedido $pedido)
 	{
 		$this->pedido = $pedido;
 	}
 	public function setQuantidade($quantidade)
 	{
 		$this->quantidade = $quantidade;
 	}

 	public function setDataValidade($dataValidade)
 	{
 		$this->dataValidade = $dataValidade;
 	}
 	public function setOcorrencia(Ocorrencia $ocorrencia)
 	{
 		$this->ocorrencia = $ocorrencia;
 	}
 	public function setObservacoes($observacoes)
 	{
 		$this->observacoes = $observacoes;
 	}
 	
}