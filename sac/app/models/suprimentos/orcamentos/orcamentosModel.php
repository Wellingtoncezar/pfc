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
	private $anexo;
	private $status = statusOrcamentos::NOVO;
	private $produtosOrcamentos = Array();
	private $usuarioCadastrado;
	
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
		public function setAnexo($anexo)
	{
		$this->anexo = $anexo;
	}

	public function addProdutoOrcamentos(orcamentosProdutosModel $produtosOrcamentos)
	{
		array_push($this->produtosOrcamentos, $produtosOrcamentos);
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
		$this->status = statusOrcamentos::APROVADO;
	}
	public function reprovar()
	{
		$this->status = statusOrcamentos::REPROVADO;
	}
	public function pendente()
	{
		$this->status = statusOrcamentos::PENDENTE;
	}
	public function cancelar()
	{
		$this->status = statusOrcamentos::CANCELADO;
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
	public function getAnexo()
	{
		return $this->anexo;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getProdutosOrcamentos()
	{
		return $this->produtosOrcamentos;
	}
	public function getUsuarioCadastrado()
	{
		return $this->usuarioCadastrado;
	}
}