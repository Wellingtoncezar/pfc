<?php
/**
 * Classe de consulta de caixas por ip
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaPorIp implements iConsultaCaixa{
	public function consultar(db $db, caixasModel $caixa)
	{
		$db->clear();
		$db->setTabela('caixas');
		$db->setCondicao("ip_maquina = ? ");
		$db->setParameter(1, $caixa->getIp());
		if($db->select())
			return $db->result();
		else
			return null;

	}
}