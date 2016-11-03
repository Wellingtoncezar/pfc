<?php
/**
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class consultaUsuarioPorId implements IUsuarios{
	public function consultar(db $db, usuariosModel $usuario, $status)
	{
		$db->clear();
		$sql="select * from sys_usuarios as a 
						    inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso
						    inner join funcionarios as c on a.id_funcionario = c.id_funcionario 
						    where a.id_usuario = ? and a.status_usuario in ('".implode("','", $status)."')"; 
		
		$db->setParameter(1, $usuario->getId());
		if($db->query($sql))
		{
			return $db->result();
		}else
			return null;
	}
}