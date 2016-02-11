<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class modulosModel{
	private $id;
	private $url;
	private $nome;
	private $posicao;
	private $status;
	private $statusSelecao;
	private $idModuloPai;
	private $fotoModulo;
	private $dataCriacao;
	private $submodulos = Array();
	private $paginas = Array();
	private $tipo;
	private $campo;
	private $valor;

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
	public function setFotoModulo($fotoModulo)
	{
		$this->fotoModulo = $fotoModulo;
	}
	public function setDataCriacao($dataCriacao)
	{
		$this->dataCriacao = $dataCriacao;
	}
	public function setSubModulos(modulosModel $submodulos, $tipo = 'id')
	{
		if($tipo == 'id')
			$this->submodulos[$submodulos->getId()] = $submodulos;
		else
			$this->submodulos[$submodulos->$tipo()] = $submodulos;
	}
	public function setPaginas(paginasModel $paginas, $tipo = 'id')
	{	
		if($tipo == 'id')
			$this->paginas[$paginas->getId()] = $paginas;
		else
			$this->paginas[$paginas->$tipo()] = $paginas;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	public function setCampo($campo){
		$this->campo = $campo;
	}
	public function setValor($valor){
		$this->valor = $valor;
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
	public function getFotoModulo()
	{
		return $this->fotoModulo;
	}
	public function getDataCriacao()
	{
		return $this->dataCriacao;
	}
	public function getSubModulos($id = null)
	{
		if($id != null)
			return $this->submodulos[$id];
		else
			return $this->submodulos;
	}
	public function getPaginas($id = null)
	{
		if($id != null)
			return $this->paginas[$id];
		else
			return $this->paginas;
	}

	public function getTipo(){
		return $this->tipo;
	}
	public function getCampo(){
		return $this->campo;
	}
	public function getValor(){
		return $this->valor;
	}
}
