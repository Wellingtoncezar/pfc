<?php
/**
 * Entidade de manipulação da tabela sys_actions
*@author Wellington cezar - wellington-cezar@hotmail.com
* @table = sys_action
*/
if(!defined('URL')) die('Acesso negado');
class actionsModel{
	/**
	 * @id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id_action")
     * @var int
     */
	private $id;
	/**
	 * @url
     * @Column(type="string", name="url_action")
     * @var string
     */
	private $url;
	/**
	 * @nome
     * @Column(type="string", name="nome_action")
     * @var string
     */
	private $nome;
	/**
	 * @posicao
     * @Column(type="integer", name="posicao_action")
     * @var int
     */
	private $posicao;
	/**
	 * @status
     * @Column(type="enum('ATIVO', 'INATIVO', 'EXCLUIDO')", name="status_action")
     * @var status
     */
	private $status;
	/**
	 * @status_selecao
     * @Column(type="enum('ATIVO', 'INATIVO', 'EXCLUIDO')", name="status_selecao_action")
     * @var status
     */
	private $status_selecao;
	/**
	 * @dataCriacao
     * @Column(type="datetime", name="data_criacao_action")
     * @var datetime
     */
	private $dataCriacao;


	/**
	 * @acesso
     * @var boolean
     */
	private $acesso = false;

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
	public function setStatus_selecao($status_selecao)
	{
		$this->status_selecao = $status_selecao;
	}
	public function setIdModuloPai($idModuloPai)
	{
		$this->idModuloPai = $idModuloPai;
	}

	public function setDataCriacao($dataCriacao)
	{
		$this->dataCriacao = $dataCriacao;
	}

	public function ativar()
	{
		$this->status = status::ATIVO;
	}
	public function inativar()
	{
		$this->status = status::INATIVO;
	}
	public function excluir()
	{
		$this->status = status::EXCLUIDO;
	}

	public function ativarSelecao()
	{
		$this->status_selecao = status::ATIVO;
	}
	public function inativarSelecao()
	{
		$this->status_selecao = status::INATIVO;
	}

	public function setAcesso($acesso)
	{
		$this->acesso = $acesso;
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
	public function getStatus_selecao()
	{
		return $this->status_selecao;
	}
	public function getIdModuloPai()
	{
		return $this->idModuloPai;
	}

	public function getDataCriacao()
	{
		return $this->dataCriacao;
	}

	public function getAcesso()
	{
		return $this->acesso;
	}
}