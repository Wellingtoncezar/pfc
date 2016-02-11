<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class paginasModel{
	private $id;
	private $url;
	private $nome;
	private $posicao;
	private $status;
	private $statusSelecao;
	private $idModulo;
	private $dataCriacao;
	private $actions = Array();

	public function setId($id)
	{
		$this->id = $id;
	}
	public function setUrl($url)
	{
		$this->url = $url;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setPosicao($posicao)
	{
		$this->posicao = $posicao;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}
	public function setStatusSelecao($statusSelecao)
	{
		$this->statusSelecao = $statusSelecao;
	}
	public function setIdModuloPai($idModuloPai)
	{
		$this->idModuloPai = $idModuloPai;
	}

	public function setDataCriacao($dataCriacao)
	{
		$this->dataCriacao = $dataCriacao;
	}

	public function setActions(actionsModel $actions)
	{
		$this->actions[$actions->getId()] = $actions;
	}



	public function getId()
	{
		return $this->id;
	}
	public function getUrl()
	{
		return $this->url;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getPosicao()
	{
		return $this->posicao;
	}
	public function getStatus()
	{
		return $this->status;
	}
	public function getStatusSelecao()
	{
		return $this->statusSelecao;
	}
	public function getIdModuloPai()
	{
		return $this->idModuloPai;
	}

	public function getDataCriacao()
	{
		return $this->dataCriacao;
	}

	public function getActions($id = null)
	{
		if($id != null)
			return $this->actions[$id];
		else
			return $this->actions;
	}
}