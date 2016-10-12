<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class estoqueModel{
	private $id;
	private $produto;
	private $nivelestoque;
	private $quantidade_total;
	private $lotes = Array();
	
	//set
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setProduto(produtosModel $produto)
	{
		$this->produto = $produto;
	}

	public function setNivelEstoque(nivelEstoqueModel $nivelestoque)
	{
		$this->nivelestoque = $nivelestoque;
	}

	public function setQuantidadeTotal($quantidade_total)
	{
		$this->quantidade_total = $quantidade_total;
	}
	public function setLotes($lotes)
	{
		$this->lotes = $lotes;
	}
	public function addLote(lotesModel $lote)
	{
		array_push($this->lotes, $lote);
	}


	//get
	public function getId()
	{
		return $this->id;
	}
	public function getProduto()
	{
		return $this->produto;
	}
	public function getNivelEstoque()
	{
		return $this->nivelestoque;
	}


	/**
	 * retorna a quantidade total do produto em estoque relacionada à unidade de medida 
	 * que está sendo controlada
	 * @return double
	 * */
	public function getQuantidadeTotal()
	{	
		$valorUndEstoque = 0;
		foreach ($this->lotes as $lotes){
			foreach ($lotes->getLocalizacao() as $localizacao){
				$fatorUnidadeLote = $localizacao->getUnidadeMedidaEstoque()->getFator();
				$qtdLoteLocal = $localizacao->getQuantidade(); //quantidade do lote por localização
				if(localizacoes::ARMAZEM == $localizacao->getLocalizacao())
				{
					$fator = $this->getUnidadeMedidaParaEstoque()->getFator();
					if($this->getUnidadeMedidaParaEstoque()->getId() != $localizacao->getUnidadeMedidaEstoque()->getId()){
						$qtd = ($qtdLoteLocal * $localizacao->getUnidadeMedidaEstoque()->getFator()) / $fator;
					}else
						$qtd = ($qtdLoteLocal * $fator) / $localizacao->getUnidadeMedidaEstoque()->getFator();
					
				}else
				if(localizacoes::PRATELEIRA == $localizacao->getLocalizacao())
				{
					$fator = $this->getUnidadeMedidaParaVenda()->getFator();

					if($this->getUnidadeMedidaParaEstoque()->getId() != $localizacao->getUnidadeMedidaEstoque()->getId()){
						$qtd = ($qtdLoteLocal * $localizacao->getUnidadeMedidaEstoque()->getFator()) / $fator;
					}else
						$qtd = ($qtdLoteLocal * $fator) / $localizacao->getUnidadeMedidaEstoque()->getFator();

				}


				// $valorUndEstoque += ((double)$qtdLoteLocal * (double)$fatorUnidadeLote) / $fator;
				$valorUndEstoque += $qtd;//(double)$qtdLoteLocal / $fator;
			}
		}

		$this->quantidade_total = $valorUndEstoque;

		return $this->quantidade_total;
	}

	/**
	 * retorna o objeto da unidade de medida relacionada ao controle de estoque (armazém)
	 * @return object unidadeMedidaEstoque
	 * */
	public function getUnidadeMedidaParaEstoque()
	{
		$unidadeMedidaEstoque = null;
		foreach ($this->produto->getUnidadeMedidaEstoque() as $undMed){
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
		foreach ($this->produto->getUnidadeMedidaEstoque() as $undMed){
			if($undMed->getParaVenda()){
				$unidadeMedidaVenda = $undMed;
			}
		}
		return $unidadeMedidaVenda;
	}






	public function getLotes()
	{
		return $this->lotes;
	}



}