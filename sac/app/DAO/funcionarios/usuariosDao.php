<?php
/**
 * Classe DAO de usuários
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class usuariosDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos Usuarios
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('funcionarios/usuariosModel');
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$this->load->model('funcionarios/funcionariosModel');
		$usuarios = Array();

		$this->db->clear();
		$sql="select * from sys_usuarios as a inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso inner join funcionarios as c on a.id_funcionario = c.id_funcionario where a.status_usuario <> '".status::EXCLUIDO."'"; 
		$this->db->query($sql);

		if($this->db->rowCount() > 0):

			$result = $this->db->resultAll();

			foreach ($result as $value)
			{
				$usuariosModel = new usuariosModel();
				$nivelAcessoModel = new niveisAcessoModel();
				$funcionariosModel = new funcionariosModel();
				$usuariosModel->setId($value['id_usuario']);
				$nivelAcessoModel->setId($value['id_nivel_acesso']);
				$nivelAcessoModel->setNome($value['nome_nivel_acesso']);
				$funcionariosModel->setId($value['id_funcionario']);
				$funcionariosModel->setNome($value['nome_funcionario']);
				$funcionariosModel->setSobrenome($value['sobrenome_funcionario']);
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

	public function consultar(usuariosModel $usuariosModel)
	{
		$this->load->model('funcionarios/usuariosModel');
		$this->load->model('funcionarios/gruposFuncionariosModel');
		$this->load->model('funcionarios/funcionariosModel');

		$this->db->clear();
		$sql="select * from sys_usuarios as a 
								inner join sys_usuarios_grupo as b on a.id_usuarios_grupo = b.id_usuarios_grupo
							    inner join funcionarios as c on a.id_funcionario = c.id_funcionario 
							    where a.id_usuario = '".$usuariosModel->getId()."' and a.status_usuario <> '".status::EXCLUIDO."'"; 
		$this->db->query($sql);

		if($this->db->rowCount() > 0):
			$result = $this->db->result();
			
			$gruposFuncionariosModel = new gruposFuncionariosModel();
			$funcionariosModel = new funcionariosModel();
			$usuariosModel->setId($result['id_usuario']);
			$gruposFuncionariosModel->setId($result['id_usuarios_grupo']);
			$gruposFuncionariosModel->setNome($result['nome_usuarios_grupo']);
			$funcionariosModel->setId($result['id_funcionario']);
			$funcionariosModel->setNome($result['nome_funcionario']);
			$funcionariosModel->setSobrenome($result['sobrenome_funcionario']);
	        $usuariosModel->setGrupoFuncionario($gruposFuncionariosModel);
			$usuariosModel->setFuncionario($funcionariosModel);
			$usuariosModel->setLogin($result['login_usuario']);
			$usuariosModel->setEmail($result['email_usuario']);
			$usuariosModel->setStatus(status::getAttribute($result['status_usuario']));
	
			

		endif;
		
		return $usuariosModel;
	}

	



	/**
	 * Insere novos usuarios
	 * @return boolean, json
	 */
 	public function inserir(usuariosModel $usuarios)
 	{
 		$senha = bcrypt::hash( $usuarios->getSenha());
		$data = array(
 			'id_funcionario' => $usuarios->getFuncionario(),
 			'id_nivel_acesso' => $usuarios->getNivelAcesso(),
 			'email_usuario' => $usuarios->getEmail(),
 			'login_usuario' => $usuarios->getLogin(),
 			'senha_usuario' => $senha,
 			'status_usuario' => $usuarios->getStatus(),
 			'data_criacao_usuario' => $usuarios->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}

	}

	/**
	 * Atualiza funcionários
	 * @return boolean, json
	 */
 	public function atualizar(usuariosModel $usuarios)
 	{

		$data = array(
 			'id_usuarios_grupo' => $usuarios->getGrupoFuncionario(),
 			'email_usuario' => $usuarios->getEmail(),
 			'login_usuario' => $usuarios->getLogin(),

 		);


		$this->db->clear();
		$this->db->setTabela('sys_usuarios');
		$this->db->setCondicao("id_usuario = '".$usuarios->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount() > 0)
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
			

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