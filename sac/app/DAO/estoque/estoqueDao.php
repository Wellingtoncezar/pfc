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
		$this->load->model('estoque/estoqueModel');
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
				$estoqueModel = new estoqueModel();
				$estoqueModel->setId($value['id_estoque']);
				$estoqueModel->setQuantidadeMinima($value['quantidade_minima']);
				$estoqueModel->setQuantidadeMaxima($value['quantidade_maxima']);

				$produtoModel = new produtosModel();
				$produtoModel->setId($value['id_produto']);
				$produtoModel->setFoto($value['foto_produto']);
				$produtoModel->setCodigoBarra($value['codigo_barra_gti']);
				$produtoModel->setNome($value['nome_produto']);

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
						$unidadeMedidaModel = new unidadeMedidaModel();
						$unidadeMedidaModel->setId($unidade['id_unidade_medida']);
						$unidadeMedidaModel->setNome($unidade['nome_unidade_medida']);
						$unidadeMedidaModel->setAbreviacao($unidade['abreviacao_unidade_medida']);

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
	}

	public function getJsonEstoque($estoque)
	{
		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$_arEstoque = Array();
		foreach ($estoque as $estoqueProd):
			$foto = $estoqueProd->getProduto()->getFoto() != '' ? URL.'skin/uploads/produtos/p/'.$estoqueProd->getProduto()->getFoto() : URL.'skin/img/imagens/forn.jpg';
			$aux = array(
				    	'id'=> $estoqueProd->getId(),
				    	'codigobarras' => $estoqueProd->getProduto()->getCodigoBarra(),
						'produto'=> $estoqueProd->getProduto()->getNome(),
						'foto'=> $foto,
						'qtdtotal'=> $dataformat->formatar($estoqueProd->getQuantidadeTotal(),'decimal').' '.$estoqueProd->getUnidadeMedidaParaEstoque()->getUnidadeMedida()->getNome(),
						'min'=> $dataformat->formatar($estoqueProd->getQuantidadeMinima(),'decimal'),
						'max'=> $dataformat->formatar($estoqueProd->getQuantidadeMaxima(),'decimal'),
						'nivel'=> (($estoqueProd->getQuantidadeTotal()- $estoqueProd->getQuantidadeMinima()) * 100) / ($estoqueProd->getQuantidadeMaxima() - $estoqueProd->getQuantidadeMinima()),
						'progressclass' => "progress-bar-success",
						'acoes'=> "",
				      	'lotes'=> array()
				    );
			$arrLotes = array();
			foreach ($estoqueProd->getLotes() as $lotes){
				$valorUndEstoque = 0;
				foreach ($lotes->getLocalizacao() as $localizacao){
					$fatorUnidadeLote = $localizacao->getUnidadeMedidaEstoque()->getFator();
					$qtdLoteLocal = $localizacao->getQuantidade(); //quantidade do lote por localização
					$valorUndEstoque += (double)$qtdLoteLocal;
				}
		        $aux2 = array( 
				        	'id' => $lotes->getId(),
							'codigo' => $lotes->getCodigoLote(),
							'codigogti' => ($lotes->getCodigoBarrasGti() != '') ? $lotes->getCodigoBarrasGti() : $estoqueProd->getProduto()->getCodigoBarra(),
							'codigogst' => $lotes->getCodigoBarrasGst(),
							'validade' => $dataformat->formatar($lotes->getDataValidade(),'data'),
							'quantidade' => $valorUndEstoque. ' '.$lotes->getLocalizacao()[0]->getUnidadeMedidaEstoque()->getUnidadeMedida()->getNome(),
							'acoes' => "",
							'linkvisualizar' => ""
				    	);

				array_push($aux['lotes'], $aux2);
			}

			array_push($_arEstoque, $aux);
        endforeach;

        return json_encode($_arEstoque);
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
				    		WHERE produto_lote.id_estoque =? GROUP BY produto_lote.id_produto_lote ORDER BY produto_lote.id_produto_lote DESC");
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







}