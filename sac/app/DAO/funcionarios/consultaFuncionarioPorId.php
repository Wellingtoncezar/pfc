<?php
/**
 * realiza a consulta do funcionario pelo id
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaFuncionarioPorId implements IListagemFuncionarios{
	public function listar(db $db){

	}

	public function consultar(db $db, funcionariosModel $funcionario, $status)
	{
		$db->clear();
		$db->setTabela('funcionarios');
		$db->setCondicao("id_funcionario = ? and status_funcionario in ('".implode("','", $status)."')");
		$db->setParameter(1, $funcionario->getId());
		if($db->select())
		{
			return $db->result();
		}else
			return null;
	}
}