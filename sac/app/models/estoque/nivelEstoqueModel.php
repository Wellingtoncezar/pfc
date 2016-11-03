<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class nivelEstoqueModel{
	private $id;
	private $quantidade_minima;
	private $quantidade_maxima;
	private $localizacao = localizacoes::ARMAZEM;
	
	//set
	public function setId($id)
	{
		$this->id = $id;
	}
	
	public function setQuantidadeMinima($quantidade_minima)
	{
		$this->quantidade_minima = $quantidade_minima;
	}

	public function setQuantidadeMaxima($quantidade_maxima)
	{
		$this->quantidade_maxima = $quantidade_maxima;
	}
	public function setLocalizacao($localizacao)
	{
		$this->localizacao = $localizacao;
	}

	public function armazenar()
	{
		$this->localizacao = localizacoes::ARMAZEM; 
	}

	public function emprateleirar()
	{
		$this->localizacao = localizacoes::PRATELEIRA; 
	}

	public function descartar()
	{
		$this->localizacao = localizacoes::DESCARTADOS;
	}


	//get
	public function getId()
	{
		return $this->id;
	}
	
	public function getQuantidadeMinima()
	{
		return $this->quantidade_minima;
	}

	public function getQuantidadeMaxima()
	{
		return $this->quantidade_maxima;
	}

	public function getLocalizacao()
	{
		return $this->localizacao;
	}
}