<?php
/**
  * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class listarPorFornecedor implements iListagemCotacoes{
	private $localizacao = localizacoes::ARMAZEM;
	public function listar($db)
	{
		$db->clear();
		$db->setParameter(1, $this->localizacao);
		$db->setParameter(2, $this->localizacao);
		$res = $db->query("select * from estoque 
					inner join produtos on estoque.id_produto = produtos.id_produto
				    inner join produto_lote on estoque.id_estoque = produto_lote.id_estoque
				    inner join localizacao_lote on produto_lote.id_produto_lote = localizacao_lote.id_produto_lote AND localizacao_lote.localizacao = ?
				    inner join nivel_estoque on estoque.id_estoque = nivel_estoque.id_estoque AND localizacao_estoque = ? 
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
