<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('URL')) die('Acesso negado');
class niveisAcessoDao extends Dao{
	
	public function __construct(){
		parent::__construct();
	}

	
	public function listar()
	{
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$niveis = Array();
		$this->db->clear();
		$this->db->setTabela('nivel_acesso');
		if( $this->db->select())
		{
			$res = $this->db->resultAll();

			foreach ($res as $nivel)
			{
				$lv = new niveisAcessoModel();
				$lv->setId($nivel['id_nivel_acesso']);
				$lv->setNome($nivel['nome_nivel_acesso']);
				$lv->setPermissoes($nivel['permissoes']);
				$lv->setIndice($nivel['index_access_db_name']);
				array_push($niveis, $lv);
				unset($lv);
			}
		}
		
		return $niveis;
		
	}


	public function getNivelAcesso($id, $campo = 'id_nivel_acesso')
	{
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$lv = new niveisAcessoModel();

		$this->db->clear();
		$this->db->setTabela('nivel_acesso');
		$this->db->setCondicao($campo.' = "'.$id.'"');
		if($this->db->select())
		{
			$nivel = $this->db->result();
			$lv->setId($nivel['id_nivel_acesso']);
			$lv->setNome($nivel['nome_nivel_acesso']);
			$lv->setPermissoes($nivel['permissoes']);
			$lv->setIndice($nivel['index_access_db_name']);
		}

		return $lv;
	}


	
	/**
	*Atualiza um grupo de permissão de acesso
	*/
	public function atualizar(niveisAcessoModel $niveisAcessoModel){
		$data = array(
			'permissoes' => $niveisAcessoModel->getPermissoes()
			
		);

		$this->db->clear();
		$this->db->setTabela('nivel_acesso');
		$this->db->setCondicao('id_nivel_acesso = "'.$niveisAcessoModel->getId().'"');
		$this->db->update($data);
		if($this->db->rowCount() > 0)
			return true;
		else
			return $this->db->getError();
	}


}
