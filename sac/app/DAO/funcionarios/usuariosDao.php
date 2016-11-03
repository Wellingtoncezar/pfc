<?php
/**
 * Classe DAO de usuários
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class usuariosDao extends Dao{
	public function __construct(){
		parent::__construct();
		$this->load->model('funcionarios/usuariosModel');
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
	}


	/**
	 * Lista os registros dos Usuarios
	 * @return Array
	 */
	public function listar()
	{
		$usuarios = Array();

		$this->db->clear();
		$sql="select * from sys_usuarios as a inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso inner join funcionarios as c on a.id_funcionario = c.id_funcionario where a.status_usuario <> '".status::EXCLUIDO."'"; 
		$this->db->query($sql);

		if($this->db->rowCount() > 0):

			$result = $this->db->resultAll();

			foreach ($result as $value)
			{
				//niveis de acesso
				$nivelAcessoModel = new niveisAcessoModel();
				$nivelAcessoModel->setId($value['id_nivel_acesso']);

				//funcionario
				$funcionariosModel = new funcionariosModel();
				$funcionariosModel->setId($value['id_funcionario']);
				$funcionariosModel->setNome($value['nome_funcionario']);
				$funcionariosModel->setSobrenome($value['sobrenome_funcionario']);
				
				//usuario
				$usuariosModel = new usuariosModel();
				$usuariosModel->setId($value['id_usuario']);
                $usuariosModel->setNivelAcesso($nivelAcessoModel);
				$usuariosModel->setFuncionario($funcionariosModel);
				$usuariosModel->setLogin($value['login_usuario']);
				$usuariosModel->setEmail($value['email_usuario']);
				$usuariosModel->setStatus(status::getAttribute($value['status_usuario']));
				array_push($usuarios, $usuariosModel);
				unset($usuariosModel);
			}
			return $usuarios;
		else:
			return $usuarios;
		endif;
	}

	public function consultar(IUsuarios $iusuario, usuariosModel $usuario, $status)
	{
		$result = $iusuario->consultar($this->db, $usuario, $status);	

		if($result != null):
			//niveis de acesso
			$nivelAcessoModel = new niveisAcessoModel();
			$nivelAcessoModel->setId($result['id_nivel_acesso']);

			//usuarios
			$usuariosModel = new usuariosModel();
			$usuariosModel->setId($result['id_usuario']);
			$usuariosModel->setNivelAcesso($nivelAcessoModel);
			$usuariosModel->setLogin($result['login_usuario']);
			$usuariosModel->setEmail($result['email_usuario']);
			$usuariosModel->setStatus(status::getAttribute($result['status_usuario']));
			return $usuariosModel;
		else:
			return null;
		endif;
		
	}

	



	/**
	 * Insere novos usuarios
	 * @return boolean, json
	 */
 	public function inserir(usuariosModel $usuarios)
 	{
 		$senha = bcrypt::hash( $usuarios->getSenha());
		$data = array(
 			'id_funcionario' => $usuarios->getFuncionario()->getId(),
 			'id_nivel_acesso' => $usuarios->getNivelAcesso(),
 			'email_usuario' => $usuarios->getEmail(),
 			'login_usuario' => $usuarios->getLogin(),
 			'senha_usuario' => $senha,
 			'status_usuario' => $usuarios->getStatus(),
 			'data_criacao_usuario' => $usuarios->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		
		try 
		{
			if($this->db->insert($data))
			{
				return true;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		}catch (dbException $e) {
			echo $e->getMessageError();
			//echo $this->db->getCode();
		}

	}

	/**
	 * Atualiza funcionários
	 * @return boolean, json
	 */
 	public function atualizar(usuariosModel $usuarios)
 	{

		$data = array(
			'id_funcionario' => $usuarios->getFuncionario()->getId(),
 			'id_nivel_acesso' => $usuarios->getNivelAcesso(),
 			'email_usuario' => $usuarios->getEmail()
 		);

		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->setCondicao("id_usuario = '".$usuarios->getId()."'");
		try {
			if($this->db->update($data))
			{
				return true;
			}else{
				return $this->db->getError();
			}
		} catch (Exception $e) {
			return $e->getMessageError();
		}
	}


	public function checkFuncionarioDuplicado(funcionariosModel $funcionarioModel, $id_usuario = null)
	{
		$cond = "";
		if($id_usuario != null)
			$cond = " and id_usuario not in ('".$id_usuario."')";

		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->setCondicao("id_funcionario = ? $cond");
		$this->db->setParameter(1, $funcionarioModel->getId());
		try {
			if($this->db->select())
			{
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			return $e->getMessageError();
		}
		
	}


	/**
	 * verifica se um usuário é administrador do sistema
	 * @return boolean 
	 **/
	public function isUsuarioAdministrador(usuariosModel $usuario)
	{
		//checagem de funcionário administrador
		$sql="select * from sys_usuarios as a 
				inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso
		    	where a.id_usuario = ? and b.permissoes = '*'";
		$this->db->clear();  
		$this->db->setParameter(1, $usuaio->getId());
		if($this->db->query($sql))
		{
			return true;
		}else
			return false;
	}

	



	/**
 	 * Atualiza o status
 	 * @return boolean
 	 */
	public function atualizarStatus(usuariosModel $usuarios)
	{
		$data = array('status_usuario'=>$usuarios->getStatus());
		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->setCondicao("id_usuario = '".$usuarios->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}

}