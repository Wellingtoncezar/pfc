<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class estoqueDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	public function listar(iListagemEstoque $listaestoque)
	{
		try {
			$this->load->model('estoque/estoqueModel');
			$this->load->model('estoque/nivelEstoqueModel');
			$this->load->model('produtos/produtosModel');
			$this->load->model('produtos/unidademedidaModel');
			$this->load->model('produtos/unidadeMedidaEstoqueModel');
			$this->load->model('produtos/unidadeMedidaModel');

			$estoque = Array();
			$result = $listaestoque->listar($this->db);
			if($result != null)
			{
				foreach ($result as $value)
				{
					//nivel estoque
					$nivelEstoqueModel = new nivelEstoqueModel();
					$nivelEstoqueModel->setQuantidadeMinima($value['quantidade_minima']);
					$nivelEstoqueModel->setQuantidadeMaxima($value['quantidade_maxima']);
					$nivelEstoqueModel->setLocalizacao(localizacoes::getAttribute($value['localizacao_estoque']));
					
					//produtos
					$produtoModel = new produtosModel();
					$produtoModel->setId($value['id_produto']);
					$produtoModel->setFoto($value['foto_produto']);
					$produtoModel->setCodigoBarra($value['codigo_barra_gti']);
					$produtoModel->setNome(html_entity_decode($value['nome_produto']));

					//estoque
					$estoqueModel = new estoqueModel();
					$estoqueModel->setId($value['id_estoque']);
					$estoqueModel->setNivelEstoque($nivelEstoqueModel);
					$estoqueModel->setProduto($produtoModel);

					$this->db->clear();
					$this->db->setTabela('unidade_medida as A, unidade_medida_produto AS B');
					$this->db->setCondicao("B.id_produto = ? AND A.id_unidade_medida = B.id_unidade_medida");
					$this->db->setOrderBy("B.ordem");
					$this->db->setParameter(1, $value['id_produto']);
					if($this->db->select())
					{
						$unidadeMedida = $this->db->resultAll();
						foreach ($unidadeMedida as $unidade)
						{
							//unidade medida
							$unidadeMedidaModel = new unidadeMedidaModel();
							$unidadeMedidaModel->setId($unidade['id_unidade_medida']);
							$unidadeMedidaModel->setNome($unidade['nome_unidade_medida']);
							$unidadeMedidaModel->setAbreviacao($unidade['abreviacao_unidade_medida']);

							//unidade medida estoque
							$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
							$unidadeMedidaEstoqueModel->setId($unidade['id_unidade_medida_produto']);
							$unidadeMedidaEstoqueModel->setUnidadeMedida($unidadeMedidaModel);
							$unidadeMedidaEstoqueModel->setParaVenda((bool)$unidade['para_venda']);
							$unidadeMedidaEstoqueModel->setParaEstoque((bool)$unidade['para_estoque']);
							$unidadeMedidaEstoqueModel->setFator($unidade['fator_unidade_medida']);
							$unidadeMedidaEstoqueModel->setOrdem($unidade['ordem']);
							$produtoModel->addUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
						}
					}

					$estoqueModel->setLotes($this->listarLotes($estoqueModel, $listaestoque->getLocalizacao()));

					array_push($estoque, $estoqueModel);
					unset($estoqueModel);
				}		
			}

			return $estoque;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
	}

	


	public function listarLotes(estoqueModel $estoque, $localizacao)
	{
		$this->load->model('estoque/lotesModel');
		$this->load->model('estoque/localizacaoLoteModel');
		$this->load->model('produtos/unidadeMedidaEstoqueModel');
		$this->load->model('produtos/unidademedidaModel');
		$this->db->clear();
		$this->db->setParameter(1,localizacoes::getAttribute($localizacao));
		$this->db->setParameter(2,$estoque->getId());
		$res = $this->db->query("select * from produto_lote 
							inner join localizacao_lote on produto_lote.id_produto_lote = localizacao_lote.id_produto_lote AND localizacao_lote.localizacao = ?
				    		WHERE produto_lote.id_estoque =? and localizacao_lote.quantidade_localizacao > 0 GROUP BY produto_lote.id_produto_lote ORDER BY produto_lote.id_produto_lote DESC");
		$arrLotes = Array();
		if($res)
		{
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$lotes = new lotesModel();
				$lotes->setId($value['id_produto_lote']);
				$lotes->setCodigoLote($value['codigo_lote']);
				$lotes->setCodigoBarrasGti($value['codigo_barras_gti']);
				$lotes->setCodigoBarrasGst($value['codigo_barras_gst']);
				$lotes->setDataValidade($value['data_validade']);
				$lotes->setUltimaAtualizacao($value['timestamp']);


				$this->db->clear();
				$this->db->setParameter(1,localizacoes::getAttribute($localizacao));
				$this->db->setParameter(2,$value['id_produto_lote']);
				$res = $this->db->query("select * from localizacao_lote
									INNER JOIN unidade_medida_produto ON localizacao_lote.id_unidade_medida_produto = unidade_medida_produto.id_unidade_medida_produto
						    		INNER JOIN unidade_medida ON unidade_medida_produto.id_unidade_medida = unidade_medida.id_unidade_medida
						    		WHERE localizacao_lote.localizacao = ? AND localizacao_lote.id_produto_lote = ? ");
				if($res)
				{
					$resultLocal = $this->db->resultAll();
					
					foreach ($resultLocal as $valueLocal)
					{
						$localizacaoLoteModel = new localizacaoLoteModel();
						$localizacaoLoteModel->setId($valueLocal['id_localizacao_lote']);
						$localizacaoLoteModel->setLocalizacao(localizacoes::getAttribute($valueLocal['localizacao']));
						$localizacaoLoteModel->setQuantidade($valueLocal['quantidade_localizacao']);
						$localizacaoLoteModel->setObservacoes($valueLocal['observacoes_localizacao_lote']);
						$localizacaoLoteModel->setUltimaAtualizacao($valueLocal['timestamp']);

						$unidademedidaModel = new unidademedidaModel();
						$unidademedidaModel->setId($valueLocal['id_unidade_medida']);
						$unidademedidaModel->setNome($valueLocal['nome_unidade_medida']);
						$unidademedidaModel->setAbreviacao($valueLocal['abreviacao_unidade_medida']);

						$unidadeMedidaEstoqueModel = new unidadeMedidaEstoqueModel();
						$unidadeMedidaEstoqueModel->setId($valueLocal['id_unidade_medida_produto']);
						$unidadeMedidaEstoqueModel->setFator($valueLocal['fator_unidade_medida']);
						$unidadeMedidaEstoqueModel->setParaVenda((bool)$valueLocal['para_venda']);
						$unidadeMedidaEstoqueModel->setParaEstoque((bool)$valueLocal['para_estoque']);
						$unidadeMedidaEstoqueModel->setOrdem($valueLocal['ordem']);
						$unidadeMedidaEstoqueModel->setUnidadeMedida($unidademedidaModel);

						$localizacaoLoteModel->setUnidadeMedidaEstoque($unidadeMedidaEstoqueModel);
						$lotes->addLocalizacao($localizacaoLoteModel);
					}
				}

				array_push($arrLotes, $lotes);

			}
		}
		
		return $arrLotes;
	}


	public function emprateleirar(lotesModel $lotesModel)
	{
		try {
			$this->db->clear();
			$this->db->query('BEGIN');

			$this->db->setTabela('localizacao_lote, produto_lote, estoque, produtos, unidade_medida_produto');
			$this->db->setCondicao("
						produto_lote.id_produto_lote = ?
						AND produto_lote.id_produto_lote = localizacao_lote.id_produto_lote 
						AND localizacao_lote.localizacao = ?
						AND produto_lote.id_estoque = estoque.id_estoque
						AND estoque.id_produto = produtos.id_produto
						AND unidade_medida_produto.id_produto = produtos.id_produto
						AND unidade_medida_produto.para_venda = ?
						");
			$this->db->setParameter(1, $lotesModel->getId());
			$this->db->setParameter(2, localizacoes::ARMAZEM);
			$this->db->setParameter(3, true);
			if($this->db->select())
			{
				$lote = $this->db->result();

				//obtençao da quantidade que será transferida à prateleira, 
				//A quantidade está relacionada com a unidade de venda
				$qtdLocalTransferencia = $lotesModel->getLocalizacao()[0]->getQuantidade();

				//converção da unidade de venda para a menor unidade de medida cadastrada
				$qtdLocalTransferencia = $qtdLocalTransferencia * $lote['fator_unidade_medida'];

				//verificando se a quantidade a ser transferido é suficiênte para realizá-lo
				if($qtdLocalTransferencia <= $lote['quantidade_localizacao'])
				{
					//return 'quantidade suficiente';
					// //verificando se 
					// if($lote['data_validade_controlada'])
					// 	$this->verificaDataValidade($lote['data_validade_controlada'], $lote['data_validade'], $lote['id_estoque'] );

					//dados do lote coletado para transferência
					$data = array(
						'quantidade_localizacao' => ($lote['quantidade_localizacao'] - $qtdLocalTransferencia)
					);

					$this->db->clear();
					$this->db->setTabela('localizacao_lote');
					$this->db->setCondicao("id_localizacao_lote = ?");
					$this->db->setParameter(1, $lote['id_localizacao_lote']);
					if($this->db->update($data))
					{
						//dados do lote a ser transferido para a nova localidade
						$data = array(
							'id_produto_lote' => $lotesModel->getId(),
							'id_unidade_medida_produto' => $lotesModel->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getId(),
							'localizacao' => localizacoes::PRATELEIRA,
							'quantidade_localizacao' => $qtdLocalTransferencia,
							'observacoes_localizacao_lote' => $lotesModel->getLocalizacao()[0]->getObservacoes()
						);
						return $this->atualizaLoteLocalizacao($data, $lotesModel->getId(), localizacoes::PRATELEIRA);
					}

				}else
				{
					return 'Quantidade para transferência insuficiênte';
				}


			}else
			{
				return 'Lote não encontrado';
			}


		} catch (dbException $e) {
			$this->db->query('rollback');
			return $e->getMessageError();
		}

	}


	// private function verificaDataValidade($data_validade, $id_estoque)
	// {
	// 	if($data_validade_controlada)
	// 	{

	// 	}

	// }

	private function atualizaLoteLocalizacao($data, $id_produto_lote, $localizacao)
	{
		try {
			$this->db->clear();
			$this->db->setTabela('localizacao_lote');
			$this->db->setCondicao("id_produto_lote = ? AND localizacao = ?");
			$this->db->setParameter(1, $id_produto_lote);
			$this->db->setParameter(2, $localizacao);
			if($this->db->select())
			{
				$res = $this->db->result();
				$data['quantidade_localizacao'] = $res['quantidade_localizacao']+$data['quantidade_localizacao'];
				if($this->db->update($data))
				{
					$this->db->query('COMMIT');
					return true;
				}else
				{

					$this->db->query('rollback');
					return false;
				}
			}else
			{
				$this->db->insert($data);
				$this->db->query('COMMIT');
			}
		} catch (dbException $e) {
			$this->db->query('rollback');
			return $e->getMessageError();
		}

	}

	/**
	 * Define o limite do lote no estoque de acordo com a localização
	 * */
	public function limitar(estoqueModel $estoqueModel)
	{
		/*
		try {
			$this->db->clear();
			$this->db->setTabela('localizacao_lote');
			$this->db->setCondicao("id_produto_lote = ? AND localizacao = ?");
			$this->db->setParameter(1, $id_produto_lote);
			$this->db->setParameter(2, $localizacao);
			if($this->db->select())
			{
				$res = $this->db->result();
				$data['quantidade_localizacao'] = $res['quantidade_localizacao']+$data['quantidade_localizacao'];
				if($this->db->update($data))
				{
					$this->db->query('COMMIT');
					return true;
				}else
				{
					$this->db->query('rollback');
					return false;
				}
			}else
			{
				$this->db->insert($data);
				$this->db->query('COMMIT');
			}
		} catch (dbException $e) {
			$this->db->query('rollback');
			return $e->getMessageError();
		}
		*/
	}

	public function armazenarLote(estoqueModel $estoqueModel)
	{
		try {
			$this->db->clear();
			$this->db->query('BEGIN');
			$estoque = $this->atualizaEstoque($estoqueModel);
			// echo 'passou';
			// echo $estoque->getId();
			// exit;
			$data = array(
				'id_estoque' => $estoque->getId(),
				'codigo_lote' => $estoque->getLotes()[0]->getCodigoLote(),
				'codigo_barras_gti' => $estoque->getLotes()[0]->getCodigoBarrasGti(),
				'codigo_barras_gst' => $estoque->getLotes()[0]->getCodigoBarrasGst(),
				'data_validade' => $estoque->getLotes()[0]->getDataValidade()
			);	
			
			$this->db->clear();
			$this->db->setTabela('produto_lote');
			if($this->db->insert($data))
			{
				$id_lote = $this->db->getUltimoId();
				//dados do lote a ser transferido para a nova localidade
				$fator_unidade_medida = $this->getFatorUnidadeEstoque($estoque);

				//Se a unidade de venda for diferente à unidade que está querendo converter 
				if($estoque->getUnidadeMedidaParaVenda()->getId() != $estoque->getLotes()[0]->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getId()){
					$qtd = ($estoque->getLotes()[0]->getLocalizacao()[0]->getQuantidade() * $fator_unidade_medida) / 1;
				}else
					$qtd = ($estoque->getLotes()[0]->getLocalizacao()[0]->getQuantidade() * 1) / $fator_unidade_medida;

				$data = array(
					'id_produto_lote' => $id_lote,
					'id_unidade_medida_produto' => $estoque->getLotes()[0]->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getId(),
					'localizacao' => $estoque->getLotes()[0]->getLocalizacao()[0]->getLocalizacao(),
					'quantidade_localizacao' => $qtd,
					'observacoes_localizacao_lote' => $estoque->getLotes()[0]->getLocalizacao()[0]->getObservacoes()
				);
				$this->atualizaLoteLocalizacao($data, $id_lote, $estoque->getLotes()[0]->getLocalizacao()[0]->getLocalizacao());
				$this->db->query('COMMIT');
				echo 'passou';
			}else{
				$this->db->query('ROLLBACK');
				echo 'erro ao cadastrar';
			}

			// 	$res = $this->db->result();
			// 	$data['quantidade_localizacao'] = $res['quantidade_localizacao']+$data['quantidade_localizacao'];
			// 	if($this->db->update($data))
			// 	{
			// 		$this->db->query('COMMIT');
			// 		return true;
			// 	}else
			// 	{
			// 		$this->db->query('rollback');
			// 		return false;
			// 	}
			// }else
			// {
			// 	$this->db->insert($data);
			// 	$this->db->query('COMMIT');
			// }
		} catch (dbException $e) {
			$this->db->query('ROLLBACK');
			return $e->getMessageError();
		}
	}

	private function getFatorUnidadeEstoque(estoqueModel $estoque)
	{
		try{
			$this->db->clear();
			$this->db->setTabela('unidade_medida_produto');
			$this->db->setCondicao("id_unidade_medida_produto = ?");
			$this->db->setParameter(1, $estoque->getLotes()[0]->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getId());
			if($this->db->select())
			{
				$res = $this->db->result();
				return $res['fator_unidade_medida'];

			}
		} catch (dbException $e) {
			$this->db->query('ROLLBACK');
			return $e->getMessageError();
		}
	}
	/**
	 * Obtem o id do estoque
	 * */
	private function atualizaEstoque(estoqueModel $estoque)
	{
		try {
			$this->db->clear();
			$this->db->setTabela('estoque');
			$this->db->setCondicao("id_produto = ?");
			$this->db->setParameter(1, $estoque->getProduto()->getId());
			if($this->db->select())
			{
				$res = $this->db->result();
				$estoque->setId($res['id_estoque']);

			}else{
				$data = array(
					'id_produto' => $estoque->getProduto()->getId()
				);
				$this->db-> clear();
				$this->db->setTabela('estoque');
				if($this->db->insert($data))
				{
					$estoque->setId($this->db->getUltimoId());
					$this->atualizaNivelEstoque($estoque);
				}else
				{
					$this->db->query('ROLLBACK');
				}
			}
			
			return $estoque;
		} catch (dbException $e) {
			$this->db->query('ROLLBACK');
			return $e->getMessageError();
		}
	}

	private function atualizaNivelEstoque(estoqueModel $estoque)
	{
		try {
			$this->db->clear();
			$this->db->setTabela('nivel_estoque');
			$this->db->setCondicao("id_estoque = ? AND localizacao_estoque = ?");
			$this->db->setParameter(1, $estoque->getId());
			$this->db->setParameter(2, $estoque->getLotes()[0]->getLocalizacao()[0]->getLocalizacao());
			if($this->db->select())
			{
				//$res = $this->db->result();
				//$estoque->setId($res['id_estoque']);
			}else
			{
				$data = array(
					'id_estoque' => $estoque->getId(),
					'localizacao_estoque' => $estoque->getLotes()[0]->getLocalizacao()[0]->getLocalizacao()
				);
				$this->db-> clear();
				$this->db->setTabela('nivel_estoque');
				$this->db->insert($data);
			}
		} catch (dbException $e) {

			$this->db->query('ROLLBACK');
			return $e->getMessageError();
		}
	}


}