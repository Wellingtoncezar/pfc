<?php
/**
 * Classe DAO de Relatorios
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class RelatoriosDao extends Dao{
	private $result;
	public function __construct(){
		parent::__construct();
	}


	public function consultarProdutosMaisVendidos(RelatoriosModel $relatorio)
	{
		$sql = '
			SELECT 
				PRODVEND.*,
				count(V.idvend) AS nVendas, /*quantidade de vendas*/
				(
					SELECT 
						SUM(PRODV.quantidade_produto_vendido)  as qtdprodv
					FROM
			    		produtos_vendidos as PRODV
					INNER JOIN vendas as VEND ON PRODV.id_venda = VEND.id_venda
			    	WHERE PRODV.id_produto = PRODVEND.id_produto
			    		AND VEND.data_venda between ? AND ?
				) AS qtdprod /*quantidade de produtos*/
			FROM
            	produtos_vendidos as PRODVEND
			    
			/*SELECIONA A QUANTIDADE DE VENDAS*/
            INNER JOIN (  
            	SELECT DISTINCT 
            		VEND.data_venda as datavenda,
                	PRODV.id_produto_vendido as idprodv,
                	PRODV.id_produto as idprod,
                	PRODV.id_venda as idvend 
            	FROM produtos_vendidos as PRODV
            	INNER JOIN vendas as VEND ON PRODV.id_venda = VEND.id_venda
            	GROUP BY PRODV.id_venda, PRODV.id_produto
            ) as V

            WHERE
            	V.idprod = PRODVEND.id_produto
                AND V.idvend = PRODVEND.id_venda
                AND V.idprodv = PRODVEND.id_produto_vendido
            	AND V.datavenda between ? AND ?

			GROUP BY PRODVEND.id_produto
			ORDER BY nVendas DESC
			LIMIT 10
			';
		$this->db->clear();
		$this->db->setParameter(1, $relatorio->getPeriodoDe());
		$this->db->setParameter(2, $relatorio->getPeriodoAte());
		$this->db->setParameter(3, $relatorio->getPeriodoDe());
		$this->db->setParameter(4, $relatorio->getPeriodoAte());
		if($this->db->query($sql)):

			$arrprodvend = Array();
			$result = $this->db->resultAll();
			foreach($result as $res)
			{
				$produtosModel = new produtosModel();
				$produtosModel->setId($res['id_produto']);

				$produtosVendidoModel = new produtosVendidoModel();
				$produtosVendidoModel->setProduto($produtosModel);
				$produtosVendidoModel->setUnidadeMedidaVendido($res['unidade_medida_vendido']);

				$ProdutosMaisVendidosModel = new ProdutosMaisVendidosModel();
				$ProdutosMaisVendidosModel->setProdutoVendido ($produtosVendidoModel);
				$ProdutosMaisVendidosModel->setQtdVendas($res['nVendas']);
				$ProdutosMaisVendidosModel->setQtdTotalProdutos($res['qtdprod']);

				$relatorio->addTipoRelatorio($ProdutosMaisVendidosModel);
			}
			return $relatorio;
		else:
			return NULL;
		endif;

	}
	

}