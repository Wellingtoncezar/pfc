<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
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
	public function listar($id_modulo)
	{
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');

		$modulo = $this->getSubModulos($id_modulo);
		if($modulo != false)
		{
			foreach ($modulo as $mod)
			{

				$modulosModel = new modulosModel();
				$modulosModel->setId($mod['id_modulo']);
				$modulosModel->setNome($mod['nome_modulo']);
				$modulosModel->setUrl($mod['url_modulo']);
				$modulosModel->setStatus($mod['status_modulo']);
				$modulosModel->setStatusSelecao($mod['status_selecao_modulo']);


				$this->tree[$mod['id_modulo']] = $modulosModel;

				
				/*
				$this->tree[$mod['id_modulo']] = array(
					'nome' 			=> $mod['nome_modulo'],
					'url' 			=> $mod['url_modulo'],
					'status'		=> $mod['status_modulo'],
					'status_selecao'		=> $mod['status_selecao'],
					'submodulos' 	=> array(),
					'paginas'		=> array()
				);*/

				$auxSubmod = array();
				$submodulo = $this->getSubModulos($mod['id_modulo']);
				//pegando os submodulos
				if($submodulo != false)
				{
					foreach ($submodulo as $submod)
					{
						$submodulosModel = new modulosModel();
						$submodulosModel->setId($submod['id_modulo']);
						$submodulosModel->setNome($submod['nome_modulo']);
						$submodulosModel->setUrl($submod['url_modulo']);
						$submodulosModel->setStatus($submod['status_modulo']);
						$submodulosModel->setStatusSelecao($submod['status_selecao_modulo']);

						$this->tree[$mod['id_modulo']]->setSubModulos($submodulosModel);

						//pegando as páginas
						$auxPag = array();
						$paginasModulo = $this->getPaginas($submod['id_modulo']);
						if($paginasModulo != false)
						{
							foreach ($paginasModulo as $pagina)
							{
								$paginasModel = new paginasModel();
								$paginasModel->setId($pagina['id_pagina']);
								$paginasModel->setNome($pagina['nome_pagina']);
								$paginasModel->setUrl($pagina['url_pagina']);
								$paginasModel->setStatus($pagina['status_pagina']);
								$paginasModel->setStatusSelecao($pagina['status_selecao_pagina']);

								$this->tree[$mod['id_modulo']]->getSubModulos($submod['id_modulo'])->setPaginas($paginasModel);


								//pegando as actions
								$acoes = $this->getAcoes($pagina['id_pagina']);
								$auxAcao = array();
								if($acoes != false)
								{
									foreach ($acoes as $acao)
									{

										$actionsModel = new actionsModel();
										$actionsModel->setId($acao['id_action']);
										$actionsModel->setNome($acao['nome_action']);
										$actionsModel->setUrl($acao['url_action']);
										$actionsModel->setStatus($acao['status_action']);
										$actionsModel->setStatusSelecao($acao['status_selecao_action']);
										$this->tree[$mod['id_modulo']]->getSubModulos($submod['id_modulo'])->getPaginas($pagina['id_pagina'])->setActions($actionsModel);

										// $this->tree[$mod['id_modulo']]['submodulos'][$submod['id_modulo']]['paginas'][$pagina['id_pagina']]['acoes'][$acao['id_action']] = array(
										// 	'nome' 		=> $acao['nome_action'],
										// 	'url' 		=> $acao['url_action'],
										// 	'status'	=> $acao['status_action'],
										// 	'status_selecao'	=> $acao['status_selecao'],
		 							// 	);
									}
								}

							}
						}
					}
				}

				//pegando paginas
				$auxPag = array();
				$paginasModulo = $this->getPaginas($mod['id_modulo']);
				if($paginasModulo != false)
				{
					foreach ($paginasModulo as $pagina)
					{
						$paginasModel = new paginasModel();
						$paginasModel->setId($pagina['id_pagina']);
						$paginasModel->setNome($pagina['nome_pagina']);
						$paginasModel->setUrl($pagina['url_pagina']);
						$paginasModel->setStatus($pagina['status_pagina']);
						$paginasModel->setStatusSelecao($pagina['status_selecao_pagina']);

						$this->tree[$mod['id_modulo']]->setPaginas($paginasModel);


						

						/*$this->tree[$mod['id_modulo']]['paginas'][$pagina['id_pagina']] = array(
							'nome' 		=> $pagina['nome_pagina'],
							'url' 		=> $pagina['url_pagina'],
							'status'	=> $pagina['status_pagina'],
							'status_selecao'	=> $pagina['status_selecao'],
							'acoes' 	=> array()
						);*/

						$acoes = $this->getAcoes($pagina['id_pagina']);
						$auxAcao = array();
						if($acoes != false)
						{
							foreach ($acoes as $acao)
							{
								$actionsModel = new actionsModel();
								$actionsModel->setId($acao['id_action']);
								$actionsModel->setNome($acao['nome_action']);
								$actionsModel->setUrl($acao['url_action']);
								$actionsModel->setStatus($acao['status_action']);
								$actionsModel->setStatusSelecao($acao['status_selecao_action']);

								
								//print_r($this->tree[$mod['id_modulo']]->getPaginas($pagina['id_pagina']));
								$this->tree[$mod['id_modulo']]->getPaginas($pagina['id_pagina'])->setActions($actionsModel);
								 // = array(
									// 'nome' 		=> $acao['nome_action'],
									// 'url' 		=> $acao['url_action'],
									// 'status'	=> $acao['status_action'],
									// 'status_selecao'	=> $acao['status_selecao'],
 								// );
							}
							//$auxPag[$pagina['id_pagina']]['acoes'] = $auxAcao;
						}


					}
					//$this->tree[$mod['id_modulo']]['paginas'] = $auxPag;
				}
			}
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
			return false;
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
			return false;
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
			return false;
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
			return false;
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
