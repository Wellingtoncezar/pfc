<?php
/**
 * realiza a consulta do funcionario pelo id
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaFuncionarioPorUsuario implements IListagemFuncionarios{
	private $usuario;
	public function __construct(usuariosModel $usuario)
	{
		$this->usuario = $usuario;
	}
	public function listar(db $db){

	}

	public function consultar(db $db, funcionariosModel $funcionario, $status)
	{
		$db->clear();
		$db->setTabela('funcionarios as A, sys_usuarios as B');
		$db->setCondicao("A.id_funcionario = B.id_funcionario AND B.id_usuario = ? and A.status_funcionario in ('".implode("','", $status)."')");
		$db->setParameter(1, $this->usuario->getId());
		if($db->select())
		{
			return $db->result();
		}else
			return null;
	}
}