<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosModel{
	private $id;
	private $foto;
	private $codigoBarra;
	private $nome;
	private $marca;
	private $categoria;
	private $descricao;
	private $fornecedores = array();
	private $unidadeMedidaEstoque = Array();
	private $unidadeMedidaVenda;
	private $fatorUnidadeMedidaVenda;
	private $status = status::ATIVO;
	private $dataValidadeControlada = false;
	private $precos = array();
	private $dataCadastro;
	private $ultimaAtualizacao;
	

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setFoto($foto)
	{
		$this->foto = $foto;
	}
	public function setCodigoBarra($codigoBarra)
	{
		$this->codigoBarra = $codigoBarra;
	}
	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function setMarca(marcasModel $marca)
	{
		$this->marca = $marca;
	}
	public function setCategoria(categoriasModel $categoria)
	{
		$this->categoria = $categoria;
	}
	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
	}
	public function addFornecedor(produtofornecedorModel $fornecedor)
	{
		array_push($this->fornecedores, $fornecedor);
	}
	public function setFornecedores($fornecedores)
	{
		$this->fornecedores = $fornecedores;
	}
	public function setUnidadeMedidaEstoque($unidadeMedidaEstoque)
	{
		$this->unidadeMedidaEstoque = $unidadeMedidaEstoque;
	}
	public function addUnidadeMedidaEstoque(unidadeMedidaEstoqueModel $unidadeMedidaEstoque)
	{
		array_push($this->unidadeMedidaEstoque, $unidadeMedidaEstoque);
	}
	public function setUnidadeMedidaVenda(unidadeMedidaModel $unidadeMedidaVenda)
	{
		$this->unidadeMedidaVenda = $unidadeMedidaVenda;
	}
	public function setFatorUnidadeMedidaVenda($fatorUnidadeMedidaVenda)
	{
		$this->fatorUnidadeMedidaVenda = $fatorUnidadeMedidaVenda;
	}

	public function ativarControleValidade(){
		$this->dataValidadeControlada = true;
	}

	public function desativarControleValidade(){
		$this->dataValidadeControlada = false;
	}

	public function setStatus($status)
	{
		$this->status = $status;
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

	public function addPreco(precosModel $preco)
	{
		array_push($this->precos, $preco);
	}
	public function setPrecos($precos)
	{
		$this->precos = $precos;
	}

	public function setDataCadastro($dataCadastro)
	{	
		$this->dataCadastro = $dataCadastro;
	}
	public function setUltimaAtualizacao($ultimaAtualizacao)
	{	
		$this->ultimaAtualizacao = $ultimaAtualizacao;
	}




	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getFoto()
	{
		return $this->foto;
	}

	public function getCodigoBarra()
	{
		return $this->codigoBarra;
	}
	public function getNome()
	{
		return $this->nome;
	}
	public function getMarca()
	{
		return $this->marca;
	}
	public function getCategoria()
	{
		return $this->categoria;
	}
	public function getDescricao()
	{
		return $this->descricao;
	}
	public function getFornecedores()
	{
		return $this->fornecedores;
	}
		
	public function getUnidadeMedidaEstoque()
	{
		return $this->unidadeMedidaEstoque;
	}
	public function getUnidadeMedidaVenda()
	{
		return $this->unidadeMedidaVenda;
	}
	public function getFatorUnidadeMedidaVenda()
	{
		return $this->fatorUnidadeMedidaVenda;
	}

	public function getControleValidade(){
		return $this->dataValidadeControlada;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	public function getPrecos()
	{
		return $this->precos;
	}
	public function getDataCadastro()
	{	
		return $this->dataCadastro;
	}
	public function getUltimaAtualizacao()
	{	
		return $this->ultimaAtualizacao;
	}


	/**
	 * retorna o objeto da unidade de medida relacionada ao controle de estoque (armazém)
	 * @return object unidadeMedidaEstoque
	 * */
	public function getUnidadeMedidaParaEstoque()
	{
		$unidadeMedidaEstoque = null;
		foreach ($this->getUnidadeMedidaEstoque() as $undMed){
			if($undMed->getParaEstoque()){
				$unidadeMedidaEstoque = $undMed;
			}
		}
		return $unidadeMedidaEstoque;
	}


	/**
	 * retorna o objeto da unidade de medida relacionada ao controle de prateleiras (venda)
	 * @return object unidadeMedidaEstoque
	 * */
	public function getUnidadeMedidaParaVenda()
	{
		$unidadeMedidaVenda = null;
		foreach ($this->getUnidadeMedidaEstoque() as $undMed){
			if($undMed->getParaVenda()){
				$unidadeMedidaVenda = $undMed;
			}
		}
		return $unidadeMedidaVenda;
	}
}