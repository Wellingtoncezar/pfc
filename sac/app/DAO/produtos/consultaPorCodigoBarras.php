<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaPorCodigoBarras implements IConsultaProduto{
	public function consultar(db $db, produtosModel $produto, $status)
	{
		try{
			$db->clear();
			$db->setTabela('produtos as a, categorias as b , marcas as c');
			$db->setCondicao("a.codigo_barra_gti = ? and b.id_categoria = a.id_categoria and c.id_marca = a.id_marca AND a.status_produto in ('".implode("','", $status)."')");
			$db->setParameter(1, $produto->getCodigoBarra());

			if($db->select())
				return $db->result();
		} catch (dbException $e) {
			return $e->gerMessageErro();
		}
	}
}