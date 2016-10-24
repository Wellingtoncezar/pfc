<?php
/**
 * Classe de consulta de caixas por ip
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaPorId implements iConsultaCaixa{
	public function consultar(db $db, caixasModel $caixa)
	{
		$db->clear();
		$db->setTabela('caixas');
		$db->setCondicao("id_caixa = '".$caixa->getId()."'");
		if($db->select())
			return $db->result();
		else
			return null;

	}
}