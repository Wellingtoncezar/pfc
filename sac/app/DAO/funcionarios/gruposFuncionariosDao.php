<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gruposFuncionariosDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	/**
	*Insere um novo grupo de permissão de acesso aos funcionarios e gerentes
	*/
	public function inserir(gruposFuncionariosModel $grupoUsuariosModel ){
		
		$data = array(
			'id_nivel_acesso' => $grupoUsuariosModel->getNivel()->getId(),
			'nome_usuarios_grupo' => $grupoUsuariosModel->getNome(),
			'permissao' => $grupoUsuariosModel->getPermissao(),
			'data_criacao_grupo' => date('Y-m-d H:i:s')
		);

		$this->db->clear();
		$this->db->setTabela('sys_usuarios_grupo');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
			return true;
		else
			return $this->db->getError();
	}


	/**
	*Atualiza um grupo de permissão de acesso
	*/
	public function atualizar(gruposUsuariosModel $grupoUsuariosModel){
		$data = array(
			'nome_usuarios_grupo' => $grupoUsuariosModel->getNome(),
			'permissao' => $grupoUsuariosModel->getPermissao()
		);
		
		$this->db->clear();
		$this->db->setTabela('sys_usuarios_grupo');
		$this->db->setCondicao('id_usuarios_grupo = "'.$grupoUsuariosModel->getId().'"');
		$this->db->update($data);
		if($this->db->rowCount() > 0)
			return true;
		else
			return false;
	}

	


	/**
	*retorna a listagem das permissões cadastradas
	*/
	public function listar(){
		$this->db->clear();
		$this->db->setTabela('sys_usuarios_grupo AS A, nivel_acesso AS B');
		$this->db->setCondicao("A.id_nivel_acesso = B.id_nivel_acesso");
		$this->db->select();
		$gruposFuncionarios = array();
		if($this->db->rowCount() > 0)
		{
			$grupos = $this->db->resultAll();
			$this->load->model('funcionarios/gruposFuncionariosModel');
			$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
			foreach ($grupos as $gr)
			{
				$gruposFuncionariosModel = new gruposFuncionariosModel();
				$gruposFuncionariosModel->setId($gr['id_usuarios_grupo']);
				$gruposFuncionariosModel->setNome($gr['nome_usuarios_grupo']);
				$gruposFuncionariosModel->setPermissao($gr['permissao']);

				$niveisAcessoModel = new niveisAcessoModel();
				$niveisAcessoModel->setId($gr['id_nivel_acesso']);
				$niveisAcessoModel->setNome($gr['nome_nivel_acesso']);
				$niveisAcessoModel->setIndice($gr['index_access_db_name']);

				$gruposFuncionariosModel->setNivel($niveisAcessoModel);
				
				array_push($gruposFuncionarios, $gruposFuncionariosModel);
				unset($gruposFuncionariosModel);
			}
		}

		
		return $gruposFuncionarios;
	}

	/**
	*Exclui permanentemente o gupo de usuário
	*/
	public function excluirGrupoUsuario($id)
	{
		
		$this->clear();
		$this->setTabela('sys_usuarios_grupo');
		$this->setCondicao('id_usuarios_grupo = "'.$id.'"');
		$this->delete();
		if($this->rowCount() > 0){
			return true;
		}
		else
			return false;
	}

	public function getGrupoFuncionario($id)
	{
		$this->db->clear();
		$this->db->setTabela('sys_usuarios_grupo');
		$this->db->setCondicao('id_usuarios_grupo = "'.$id.'"');
		$this->db->select();
		$this->load->model('funcionarios/gruposFuncionariosModel');
		$gruposFuncionariosModel = new gruposFuncionariosModel();
		if($this->db->rowCount() > 0)
		{
			$gr = $this->db->result();
			$gruposFuncionariosModel->setId($gr['id_usuarios_grupo']);
			$gruposFuncionariosModel->setNome($gr['nome_usuarios_grupo']);
			$gruposFuncionariosModel->setPermissao($gr['permissao']);
		}
			
		return $gruposFuncionariosModel;
	}



}