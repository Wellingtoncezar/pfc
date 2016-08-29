<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class lotesModel{
	private $id;
	private $codigolote;
	private $codigoBarrasGti;
	private $codigoBarrasGst;
	private $dataValidade;
	private $localizacoes = Array();
	private $ultimaAtualizacao;
	
	//set
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setCodigoLote($codigolote)
	{
		$this->codigolote = $codigolote;
	}

	public function setCodigoBarrasGti($codigoBarrasGti)
	{
		$this->codigoBarrasGti = $codigoBarrasGti;
	}
	public function setCodigoBarrasGst($codigoBarrasGst)
	{
		$this->codigoBarrasGst = $codigoBarrasGst;
	}
	public function setDataValidade($dataValidade)
	{
		$this->dataValidade = $dataValidade;
	}
	public function setUltimaAtualizacao($ultimaAtualizacao)
	{
		$this->ultimaAtualizacao = $ultimaAtualizacao;
	}
	public function setLocalizacao($localizacao)
	{
		$this->localizacoes = $localizacao;
	}
	public function addLocalizacao(localizacaoLoteModel $localizacao)
	{
		array_push($this->localizacoes, $localizacao);
	}



	//get
	public function getId()
	{
		return $this->id;
	}
	public function getCodigoLote()
	{
		return $this->codigolote;
	}

	public function getCodigoBarrasGti()
	{
		return $this->codigoBarrasGti;
	}
	public function getCodigoBarrasGst()
	{
		return $this->codigoBarrasGst;
	}
	public function getDataValidade()
	{
		return $this->dataValidade;
	}
	public function getUltimaAtualizacao()
	{
		return $this->ultimaAtualizacao;
	}
	public function getLocalizacao()
	{
		return $this->localizacoes;
	}

	/**
	 * retorna a quantidade relacionada ao lote, localização e unidade de medida do lote
	 * @return double
	 * */
	public function getQuantidadeLotePorLocalizacao()
	{
		$valorUndEstoque = 0;
		foreach ($this->localizacoes as $localizacao){
			$fatorUnidadeLote = $localizacao->getUnidadeMedidaEstoque()->getFator();
			$qtdLoteLocal = $localizacao->getQuantidade(); //quantidade do lote por localização

			$valorUndEstoque += (double)$qtdLoteLocal / $fatorUnidadeLote;
		}
		return $valorUndEstoque;
	}
}