<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class requisicoesModel{
	private $id;
	private $codigo;
	private $titulo;
	private $observacoes;
	private $data;
	private $status = statusRequisicoes::NOVO;
	private $produtosRequisitados = Array();
	private $usuarioCadastrado;
	private $usuarioAprovado;
	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setCodigo($codigo)
	{
		$this->codigo = $codigo;
	}
	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}
	public function setObservacoes($observacoes)
	{
		$this->observacoes = $observacoes;
	}
	public function setData($data)
	{
		$this->data = $data;
	}

	public function addProdutoRequisitado(requisicaoProdutoModel $produtosRequisitado)
	{
		array_push($this->produtosRequisitados, $produtosRequisitado);
	}
	public function setUsuarioCadastrado(usuariosModel $usuarioCadastrado)
	{
		$this->usuarioCadastrado = $usuarioCadastrado;
	}
	public function setUsuarioAprovado(usuariosModel $usuarioAprovado)
	{
		$this->usuarioAprovado = $usuarioAprovado;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function aprovar()
	{
		$this->status = statusRequisicoes::APROVADO;
	}
	public function reprovar()
	{
		$this->status = statusRequisicoes::REPROVADO;
	}

	public function cancelar()
	{
		$this->status = statusRequisicoes::CANCELADO;
	}
	

	//GETERS
	public function getId()
	{
		return $this->id;
	}
	public function getCodigo()
	{
		return $this->codigo;
	}
	public function getTitulo()
	{
		return $this->titulo;
	}
	public function getObservacoes()
	{
		return $this->observacoes;
	}
	public function getData()
	{
		return $this->data;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getProdutosRequisitados()
	{
		return $this->produtosRequisitados;
	}
	public function getUsuarioCadastrado()
	{
		return $this->usuarioCadastrado;
	}
		public function getUsuarioAprovado()
	{
		return $this->usuarioAprovado;
	}
}