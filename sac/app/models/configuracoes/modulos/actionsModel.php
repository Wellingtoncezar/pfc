<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('URL')) die('Acesso negado');
class actionsModel{
	private $id;
	private $url;
	private $nome;
	private $posicao;
	private $status;
	private $statusSelecao;
	private $idPagina;
	private $dataCriacao;

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


}