<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class localizacaoLoteModel{
	private $id;
	private $unidadeMedidaEstoque;
	private $localizacao = localizacoes::RESERVADO;
	private $quantidade;
	private $observacoes;
	private $ultimaAtualizacao;
	
	//SET
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setUnidadeMedidaEstoque(unidadeMedidaEstoqueModel $unidadeMedidaEstoque)
	{
		$this->unidadeMedidaEstoque = $unidadeMedidaEstoque;
	}
	public function setLocalizacao($localizacao)
	{
		$this->localizacao = $localizacao; 
	}
	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade; 
	}
	public function setObservacoes($observacoes)
	{
		$this->observacoes = $observacoes; 
	}
	public function setUltimaAtualizacao($ultimaAtualizacao)
	{
		$this->ultimaAtualizacao = $ultimaAtualizacao; 
	}

	public function reservar()
	{
		$this->localizacao = localizacoes::RESERVADO; 
	}

	public function separar()
	{
		$this->localizacao = localizacoes::SEPARADO; 
	}

	public function disponivel()
	{
		$this->localizacao = localizacoes::DISPONIVEL;
	}

	public function perdido()
	{
		$this->localizacao = localizacoes::PERDIDO;
	}



	//GET
	public function getId()
	{
		return $this->id;
	}
	public function getUnidadeMedidaEstoque()
	{
		return $this->unidadeMedidaEstoque;
	}
	public function getLocalizacao()
	{
		return $this->localizacao;
	}
	public function getQuantidade()
	{
		return $this->quantidade;
	}
	public function getObservacoes()
	{
		return $this->observacoes;
	}
	public function getUltimaAtualizacao()
	{
		return $this->ultimaAtualizacao;
	}
}
