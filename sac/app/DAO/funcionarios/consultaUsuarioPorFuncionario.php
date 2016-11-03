<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaUsuarioPorFuncionario	implements IUsuarios{
	private $funcionario;
	public function __construct(funcionariosModel $funcionario)
	{
		$this->funcionario = $funcionario;
	}

	public function consultar(db $db, usuariosModel $usuario, $status)
	{
		$db->clear();
		$sql="select * from sys_usuarios as a 
						    inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso
						    inner join funcionarios as c on a.id_funcionario = c.id_funcionario AND c.id_funcionario = ?
						    where a.status_usuario in ('".implode("','", $status)."')"; 
		
		$db->setParameter(1, $this->funcionario->getId());
		if($db->query($sql))
		{
			return $db->result();
		}else
			return null;

	}
}