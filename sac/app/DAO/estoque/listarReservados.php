<?php
/**
 * Classe de listagem de funcionários (ATIVOS E INATIVOS)
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class listarReservados implements iListagemEstoque{
	private $localizacao = localizacoes::RESERVADO;
	public function listar($db)
	{
		$db->clear();
		$db->setParameter(1, $this->localizacao);
		$res = $db->query("select * from estoque 
					inner join produtos on estoque.id_produto = produtos.id_produto
				    inner join produto_lote on estoque.id_estoque = produto_lote.id_estoque
				    inner join localizacao_lote on produto_lote.id_produto_lote = localizacao_lote.id_produto_lote AND localizacao_lote.localizacao = ?
					GROUP BY produtos.id_produto");
		if($res)
		{
			return $db->resultAll();
		}else
			return null;
	}
	public function getLocalizacao()
	{
		return $this->localizacao;
	}
}