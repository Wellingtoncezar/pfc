<?php
/**
 * Classe de listagem de funcionários (ATIVOS E INATIVOS)
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class listarAtivos implements iListagemFuncionarios{
	public function listar(db $db)
	{
		$db->clear();
		$db->setTabela('funcionarios AS A, cargos AS B');
		$db->setCondicao(" A.status_funcionario in('".status::ATIVO."') AND A.id_cargo = B.id_cargo");
		$campos = array('A.id_funcionario','A.codigo_funcionario','A.foto_funcionario','A.nome_funcionario','A.sobrenome_funcionario','B.nome_cargo','B.setor_cargo','A.cpf_funcionario','A.status_funcionario', 'A.timestamp');
		if($db->select($campos))
		{
			return $db->resultAll();
		}
	}

	public function consultar(db $db, funcionariosModel $funcionarios, $status)
	{

	}
}