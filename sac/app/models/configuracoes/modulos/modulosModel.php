<?php
/**
 * Entidade de manipulação da tabela sys_modulos
*@author Wellington cezar - wellington-cezar@hotmail.com
* @table=sys_modulos
*/
if(!defined('URL')) die('Acesso negado');
class modulosModel{
	/**
	 * @id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id_modulo")
     * @var int
     */
	private $id;
	/**
	 * @url
     * @Column(type="string", name="url_modulo")
     * @var string
     */
	private $url;
	/**
	 * @nome
     * @Column(type="string", name="nome_modulo")
     * @var string
     */
	private $nome;
	/**
	 * @posicao
     * @Column(type="integer", name="posicao_modulo")
     * @var int
     */
	private $posicao;
	/**
	 * @status
     * @Column(type="enum('ATIVO', 'INATIVO', 'EXCLUIDO')", name="status_modulo")
     * @var status
     */
	private $status;

	/**
	 * @status_selecao
     * @Column(type="enum('ATIVO', 'INATIVO', 'EXCLUIDO')", name="status_selecao_modulo")
     * @var status
     */
	private $status_selecao;

	/**
	 * @modulos
     * @OneToMany(targetEntity="modulosModel")
     * @var modulosModel[]
     **/
	private $modulos = Array();
	/**
	 * @paginas
     * @OneToMany(targetEntity="paginasModel")
     * @var paginasModel[]
     **/
	private $paginas = Array();
	/**
	 * @icone
     * @Column(type="string", name="icone_modulo")
     * @var string
     */
	private $icone;
	/**
	 * @dataCriacao
     * @Column(type="datetime", name="data_criacao_modulo")
     * @var datetime
     */
	private $dataCriacao;

	/**
	 * @acesso
     * @var boolean
     */
	private $acesso = false;


	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getPosicao(){
		return $this->posicao;
	}

	public function setPosicao($posicao){
		$this->posicao = $posicao;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}
	public function getStatus_selecao(){
		return $this->status_selecao;
	}

	public function setStatus_selecao($status_selecao){
		$this->status_selecao = $status_selecao;
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

	public function setAcesso($acesso)
	{
		$this->acesso = $acesso;
	}

	public function ativarSelecao()
	{
		$this->status_selecao = status::ATIVO;
	}
	public function inativarSelecao()
	{
		$this->status_selecao = status::INATIVO;
	}



	public function getModulo(){
		return $this->modulo;
	}

	public function setModulo($modulo){
		$this->modulo = $modulo;
	}

	public function addModulo(modulosModel $modulos){
		array_push($this->modulos, $modulos);
	}
	public function getModulos(){
		return $this->modulos;
	}
	public function setPaginas($paginas){
		$this->paginas = $paginas;
	}
	public function getPaginas(){
		return $this->paginas;
	}

	public function addPagina(paginasModel $paginas){
		array_push($this->paginas, $paginas);
	}

	public function getIcone(){
		return $this->icone;
	}

	public function setIcone($icone){
		$this->icone = $icone;
	}

	public function getDataCriacao(){
		return $this->dataCriacao;
	}

	public function setDataCriacao($dataCriacao){
		$this->dataCriacao = $dataCriacao;
	}
	public function getAcesso()
	{
		return $this->acesso;
	}
}