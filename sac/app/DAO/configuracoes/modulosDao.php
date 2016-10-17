<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('URL')) die('Acesso negado');
class modulosDao extends Dao{
	private $tree = array();
	
	public function __construct(){
		parent::__construct();
	}

	/**
	* Listagem dos módulos
	*/
	public function listar($id_modulo = 0)
	{
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');

		$modulo = $this->getSubModulos($id_modulo);

		foreach ($modulo as $mod)
		{
			$modulosModel = new modulosModel();
			$modulosModel->setId($mod['id_modulo']);
			$modulosModel->setNome($mod['nome_modulo']);
			$modulosModel->setUrl($mod['url_modulo']);
			$modulosModel->setIcone($mod['icone_modulo']);
			$modulosModel->setStatus(status::getAttribute($mod['status_modulo']));
			$modulosModel->setStatus_selecao(status::getAttribute($mod['status_selecao_modulo']));

			$submodulo = $this->getSubModulos($modulosModel->getId());
			//pegando os submodulos
			foreach ($submodulo as $submod)
			{
				$submodulosModel = new modulosModel();
				$submodulosModel->setId($submod['id_modulo']);
				$submodulosModel->setNome($submod['nome_modulo']);
				$submodulosModel->setUrl($submod['url_modulo']);
				$submodulosModel->setStatus(status::getAttribute($submod['status_modulo']));
				$submodulosModel->setStatus_selecao(status::getAttribute($submod['status_selecao_modulo']));

				
				
				//pegando as páginas
				$paginasModulo = $this->getPaginas($submodulosModel->getId());
				foreach ($paginasModulo as $pagina)
				{
					$paginasModel = new paginasModel();
					$paginasModel->setId($pagina['id_pagina']);
					$paginasModel->setNome($pagina['nome_pagina']);
					$paginasModel->setUrl($pagina['url_pagina']);
					$paginasModel->setStatus(status::getAttribute($pagina['status_pagina']));
					$paginasModel->setStatus_Selecao(status::getAttribute($pagina['status_selecao_pagina']));

					//pegando as actions
					$acoes = $this->getAcoes($paginasModel->getId());
					foreach ($acoes as $acao)
					{

						$actionsModel = new actionsModel();
						$actionsModel->setId($acao['id_action']);
						$actionsModel->setNome($acao['nome_action']);
						$actionsModel->setUrl($acao['url_action']);
						$actionsModel->setStatus(status::getAttribute($acao['status_action']));
						$actionsModel->setStatus_selecao(status::getAttribute($acao['status_selecao_action']));
						
						$paginasModel->addAction($actionsModel);
					}

					$submodulosModel->addPagina($paginasModel);

				}
				$modulosModel->addModulo($submodulosModel);
			}
			
			//pegando paginas
			$auxPag = array();
			$paginasModulo = $this->getPaginas($modulosModel->getId());
				foreach ($paginasModulo as $pagina)
				{
					$paginasModel = new paginasModel();
					$paginasModel->setId($pagina['id_pagina']);
					$paginasModel->setNome($pagina['nome_pagina']);
					$paginasModel->setUrl($pagina['url_pagina']);
					$paginasModel->setStatus(status::getAttribute($pagina['status_pagina']));
					$paginasModel->setStatus_selecao(status::getAttribute($pagina['status_selecao_pagina']));

					$acoes = $this->getAcoes($pagina['id_pagina']);
					foreach ($acoes as $acao)
					{
						$actionsModel = new actionsModel();
						$actionsModel->setId($acao['id_action']);
						$actionsModel->setNome($acao['nome_action']);
						$actionsModel->setUrl($acao['url_action']);
						$actionsModel->setStatus(status::getAttribute($acao['status_action']));
						$actionsModel->setStatus_selecao(status::getAttribute($acao['status_selecao_action']));

						$paginasModel->addAction($actionsModel);
					}

					$modulosModel->addPagina($paginasModel);

				}

			array_push($this->tree, $modulosModel);
		}

		return $this->tree;
		
	}


	public function getModulo($id){
		$this->clear();
		$this->setTabela('sys_modulos');
		$this->setCondicao('id_modulo = "'.$id_modulo.'"');
		$this->select();
		if($this->rowCount() > 0){
			return $this->result();
		}
		else
			return Array();
	}


	public function getSubModulos($id_modulo){
		$this->db->clear();
		$this->db->setTabela('sys_modulos');
		$this->db->setCondicao('id_modulo_pai = "'.$id_modulo.'" and id_modulo<> "0"');
		$this->db->setOrderBy('posicao_modulo');
		$this->db->select();
		if($this->db->rowCount() > 0){
			return $this->db->resultAll();
		}
		else
			return Array();
	}

	public function getPaginas($id_modulo){
		$this->db->clear();
		$this->db->setTabela('sys_paginas');
		$this->db->setCondicao('id_modulo = "'.$id_modulo.'"');
		$this->db->setOrderBy('posicao_pagina');
		$this->db->select();
		if($this->db->rowCount() > 0){
			return $this->db->resultAll();
		}
		else
			return Array();
	}

	public function getAcoes($id_pagina){
		$this->db->clear();
		$this->db->setTabela('sys_actions');
		$this->db->setCondicao('id_pagina = "'.$id_pagina.'"');
		$this->db->setOrderBy('posicao_action');
		$this->db->select();
		if($this->db->rowCount() > 0){
			return $this->db->resultAll();
		}
		else
			return Array();
	}


	private function atualizaModulos($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->db->clear();
		$this->db->setTabela('sys_modulos');
		$this->db->setCondicao('id_modulo = "'.$id.'"');
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


	private function atualizaPaginas($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->db->clear();
		$this->db->setTabela('sys_paginas');
		$this->db->setCondicao('id_pagina = "'.$id.'"');
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}

	private function atualizaAcoes($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->db->clear();
		$this->db->setTabela('sys_actions');
		$this->db->setCondicao('id_action = "'.$id.'"');
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}

	public function atualizar($modulo)
	{	
		$tipos = array(
			'modulo' 	=> 'atualizaModulos',
			'submodulo' => 'atualizaModulos',
			'pagina'	=> 'atualizaPaginas',
			'acao'		=> 'atualizaAcoes'
		);
		return $this->$tipos[$modulo->getTipo()]($modulo->getId(), $modulo->getCampo(), $modulo->getValor());
	}


	public function updatePosition($positions)
	{
		$error = 0;
		foreach ($positions as $position => $item)
	    {
	    	$item = str_replace('listItem_','',$item);
	      	try{
				$this->db->setTabela('sys_modulos');
				$arr = array(
					'posicao_modulo' => $position
				);
				$this->db->setCondicao("id_modulo = '$item'");
				$this->db->update($arr);
	      	}catch (PDOException $e) 
			{
				$error++;
				die('Erro: '.$e->getMessage());
			}
	    }
	    if($error == 0)
	    	return true;
	    else
	    	return 'Erro ao posicionar os módulos';
	}
}
