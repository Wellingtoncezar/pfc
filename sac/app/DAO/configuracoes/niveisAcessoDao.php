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
				// $lv->setPermissoes($nivel['permissoes']);
				$lv->setIndice($nivel['index_access_db_name']);
				array_push($niveis, $lv);
				unset($lv);
			}
		}
		
		return $niveis;
		
	}


	public function getNivelAcesso(niveisAcessoModel $niveisAcessoModel, $modulos )
	{
		$this->load->model('configuracoes/niveis_acesso/niveisAcessoModel');
		$lv = new niveisAcessoModel();

		$this->db->clear();
		$this->db->setTabela('nivel_acesso');
		$this->db->setCondicao('id_nivel_acesso = ? ');
		$this->db->setParameter(1, $niveisAcessoModel->getId());
		if($this->db->select())
		{
			$nivel = $this->db->result();
			$lv->setId($nivel['id_nivel_acesso']);
			$lv->setNome($nivel['nome_nivel_acesso']);
			if($nivel['tipo_permissao'] == tipopermissao::ADMINISTRADOR)
				$lv->setTipoPermissaoAdministrador();
			else
				$lv->setTipoPermissaoUsuario();
			$lv->setPermissoes($this->getPermissoes($lv, $modulos));
			$lv->setIndice($nivel['index_access_db_name']);
		}

		return $lv;
	}

	/**
	 * valida todos os módulos conforme as permissões de acesso de cada um
	 * @param niveisAcessoModel, modulosModel
	 * @return modulosModel
	 * */
	public function getPermissoes($lv, $modulos)
	{
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');

		$this->db->clear();
		$sqlAction = "SELECT id_action FROM acesso_action WHERE acesso_action.id_nivel_acesso = ?";
		$sqlPagina = "SELECT id_pagina FROM acesso_pagina WHERE acesso_pagina.id_nivel_acesso = ?";
		$sqlModulo = "SELECT id_modulo FROM acesso_modulo WHERE acesso_modulo.id_nivel_acesso = ?";
		$this->db->setParameter(1, $lv->getId());
		$acessosActions = array();
		$acessosPaginas = array();
		$acessosModulos = array();
		if($this->db->query($sqlAction)){
			$res = $this->db->resultAll();
			$acessosActions = array_column($res, 'id_action');
		}

		$this->db->setParameter(1, $lv->getId());
		if($this->db->query($sqlPagina)){
			$res = $this->db->resultAll();
			$acessosPaginas = array_column($res, 'id_pagina');
		}

		$this->db->setParameter(1, $lv->getId());
		if($this->db->query($sqlModulo)){
			$res = $this->db->resultAll();
			$acessosModulos = array_column($res, 'id_modulo');
		}


		foreach($modulos as $modulo)
		{
			if(in_array($modulo->getId(), $acessosModulos))
				$modulo->setAcesso(true);

			foreach ($modulo->getModulos() as $submodulo)
			{
				if(in_array($submodulo->getId(), $acessosModulos))
					$submodulo->setAcesso(true);
				foreach ($submodulo->getPaginas() as $paginas) 
				{
					if(in_array($paginas->getId(), $acessosPaginas))
						$paginas->setAcesso(true);
					foreach($paginas->getActions() as $actions)
					{
						if(in_array($actions->getId(), $acessosActions))
							$actions->setAcesso(true);
					}
				}
			}
			foreach ($modulo->getPaginas() as $paginas) 
			{
				if(in_array($paginas->getId(), $acessosPaginas))
					$paginas->setAcesso(true);
				foreach($paginas->getActions() as $actions)
				{
					if(in_array($actions->getId(), $acessosActions))
						$actions->setAcesso(true);
				}
			}
		}
		// echo '<pre>';
		// print_r($modulos);
		// echo '</pre>';
		return $modulos;
	}





	
	/**
	*Atualiza um grupo de permissão de acesso
	*/
	public function atualizar(niveisAcessoModel $niveisAcessoModel){
		try {
			$noDeleteModulos = Array();
			$noDeletePaginas = Array();
			$noDeleteActions = Array();

			if(!empty($niveisAcessoModel->getPermissoes()))
			{
				foreach($niveisAcessoModel->getPermissoes() as $modulos)
				{
					if(!in_array($modulos->getId(), $noDeleteModulos))
						array_push($noDeleteModulos, $modulos->getId());
					foreach ($modulos->getModulos() as $modulo)
					{
						if(!in_array($modulo->getId(), $noDeleteModulos))
							array_push($noDeleteModulos, $modulo->getId());
						foreach ($modulo->getPaginas() as $paginas) 
						{
							if(!in_array($paginas->getId(), $noDeletePaginas))
								array_push($noDeletePaginas, $paginas->getId());
							foreach($paginas->getActions() as $actions)
							{
								if(!in_array($actions->getId(), $noDeleteActions))
									array_push($noDeleteActions, $actions->getId());
							}
						}
					}
					foreach ($modulos->getPaginas() as $paginas) 
					{
						if(!in_array($paginas->getId(), $noDeletePaginas))
								array_push($noDeletePaginas, $paginas->getId());
						foreach($paginas->getActions() as $actions)
						{
							if(!in_array($actions->getId(), $noDeleteActions))
								array_push($noDeleteActions, $actions->getId());
						}
					}
				}
			}


			$this->atualizaAcessoModulos($niveisAcessoModel->getId(), $noDeleteModulos);
			$this->atualizaAcessoPaginas($niveisAcessoModel->getId(), $noDeletePaginas);
			$this->atualizaAcessoAction($niveisAcessoModel->getId(), $noDeleteActions);
			return true;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
	}

	private function atualizaAcessoAction($idNivelAcesso, $actions)
	{

		foreach ($actions as $idAction)
		{
			$data = array(
				'id_nivel_acesso' 	=> $idNivelAcesso,
				'id_action' 		=> $idAction
			);
			$this->db->clear();
			$this->db->setTabela('acesso_action');
			$this->db->setCondicao('id_nivel_acesso = ? AND id_action = ?');
			$this->db->setParameter(1, $idNivelAcesso);
			$this->db->setParameter(2, $idAction);

			if($this->db->select())
			{
				$this->db->update($data);
			}else
			{
				$this->db->insert($data);
			}
		}

		$cond = '';
		if(!empty($actions )){
			$actions = implode(',', $actions);
			$cond = ' AND id_action NOT IN ('.$actions.')';
		}
		$this->db->clear();
		$this->db->setParameter(1, $idNivelAcesso);
		$sql = "DELETE FROM acesso_action
				WHERE id_nivel_acesso = ? 
				$cond";
		$this->db->query($sql);
	}


	private function atualizaAcessoPaginas($idNivelAcesso, $paginas)
	{

		foreach ($paginas as $idPagina)
		{
			$data = array(
				'id_nivel_acesso' 	=> $idNivelAcesso,
				'id_pagina' 		=> $idPagina
			);


			$this->db->clear();
			$this->db->setTabela('acesso_pagina');
			$this->db->setCondicao('id_nivel_acesso = ? AND id_pagina = ?');
			$this->db->setParameter(1, $idNivelAcesso);
			$this->db->setParameter(2, $idPagina);

			if($this->db->select())
			{
				$this->db->update($data);
			}else
			{
				$this->db->insert($data);
			}

		}

		$cond = '';
		if(!empty($paginas )){
			$paginas = implode(',', $paginas);
			$cond = ' AND id_pagina NOT IN ('.$paginas.')';
		}
		$this->db->clear();
		$this->db->setParameter(1, $idNivelAcesso);
		$sql = "DELETE FROM acesso_pagina
				WHERE id_nivel_acesso = ? 
				$cond";
		$this->db->query($sql);
	}

	private function atualizaAcessoModulos($idNivelAcesso, $modulos)
	{
		foreach ($modulos as $idModulo)
		{
			$data = array(
				'id_nivel_acesso' 	=> $idNivelAcesso,
				'id_modulo' 		=> $idModulo
			);

			$this->db->clear();
			$this->db->setTabela('acesso_modulo');
			$this->db->setCondicao('id_nivel_acesso = ? AND id_modulo = ?');
			$this->db->setParameter(1, $idNivelAcesso);
			$this->db->setParameter(2, $idModulo);

			if($this->db->select())
			{
				$this->db->update($data);
			}else
			{
				$this->db->insert($data);
			}
		}

		$cond = '';
		if(!empty($modulos )){
			$modulos = implode(',', $modulos);
			$cond = ' AND id_modulo NOT IN ('.$modulos.')';
		}
		$this->db->clear();
		$this->db->setParameter(1, $idNivelAcesso);
		$sql = "DELETE FROM acesso_modulo
				WHERE id_nivel_acesso = ? 
				$cond";
		$this->db->query($sql);
	}
}
