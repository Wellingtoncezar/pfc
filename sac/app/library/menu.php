<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso não permitido');
class menu extends Library{
	private $_modulos = array();
	private $_menu = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('configuracoes/modulos/modulosModel');
		$this->load->model('configuracoes/modulos/paginasModel');
		$this->load->model('configuracoes/modulos/actionsModel');

		/*
		$modulos['configuracoes']['url'] = 'configuracoes';
		$modulos['configuracoes']['nome'] = 'Configurações';
		$modulos['configuracoes']['nome'] = 'Configurações';
		$modulos['configuracoes']['submodulo'] = array();
		$modulos['configuracoes']['submodulo']['nome']
		*/

		if(isset($_SESSION['user']))
			$permissao = unserialize($_SESSION['user'])->getNivelAcesso()->getPermissoes();
		else
			$permissao = "*";
		//$permissao = 'Administrador';
		if($permissao != '*')
		{
			$this->geraArrayMenuPermissao(0);
		}else
		{
			$this->geraArrayMenu(0);	
		}
	}

	/**
	* Retorna o módulo especificado
	*/
	private function getModule($id)
	{
		$this->db->clear();
		$this->db->setTabela('sys_modulos');
		$this->db->setCondicao('id_modulo_pai = "'.$id.'" and status_modulo = "ATIVO"');
		$this->db->setOrderBy('posicao_modulo');
		$this->db->select();
		if($this->db->rowCount()>0)
		{
			return $this->db->resultAll();

		}else
			return false;
	}

	/**
	* Retorna a página especificada
	*/
	private function getPaginas($id)
	{
		$this->db->clear();
		$this->db->setTabela('sys_paginas');
		$this->db->setCondicao('id_modulo = "'.$id.'" and status_pagina = "ATIVO"');
		$this->db->setOrderBy('posicao_pagina');
		$this->db->select();
		if($this->db->rowCount()>0)
		{
			return $this->db->resultAll();

		}else
			return false;
	}

	private function getArrayMenu()
	{
		return $this->_modulos;
	}


	/**
	* Gera o array do menu para os diferentes níveis de permissões
	*/
	public function geraArrayMenuPermissao($id){

		$permissoes = json_decode(html_entity_decode(unserialize($_SESSION['user'])->getNivelAcesso()->getPermissoes()), true);

		$modulos = $this->getModule($id);
		if(!empty($modulos)):
		foreach ($modulos as $keyMod => $mod)
		{
			if(isset($permissoes[$mod['url_modulo']]))
			{
				$modulosModel = new modulosModel();
				$modulosModel->setId($mod['id_modulo']);
				$modulosModel->setNome($mod['nome_modulo']);
				$modulosModel->setUrl($mod['url_modulo']);
				$modulosModel->setStatus($mod['status_modulo']);
				$modulosModel->setStatusSelecao($mod['status_selecao_modulo']);
				$modulosModel->setFotoModulo($mod['icone_modulo']);


				$this->_modulos[$mod['url_modulo']] = $modulosModel;
				
				unset($modulosModel);

				//se existir submodulos
				$submodulos = $this->getModule($mod['id_modulo']);
				if($submodulos != false)
				{
					foreach ($submodulos as $keySubMod => $subMod)
					{
						if(isset($permissoes[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']] ))
						{
							$subModulosModel = new modulosModel();
							$subModulosModel->setId($subMod['id_modulo']);
							$subModulosModel->setNome($subMod['nome_modulo']);
							$subModulosModel->setUrl($subMod['url_modulo']);
							$subModulosModel->setStatus($subMod['status_modulo']);
							$subModulosModel->setStatusSelecao($subMod['status_selecao_modulo']);

							$this->_modulos[$mod['url_modulo']]->setSubModulos($subModulosModel,'getUrl');

							$paginas = $this->getPaginas($subMod['id_modulo']);
							
							if($paginas != false)
							{
								foreach ($paginas as $keyPag => $pag)
								{
									if(isset($permissoes[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']][$pag['url_pagina']] ))
									{
										$paginasModel = new paginasModel();
										$paginasModel->setId($pag['id_pagina']);
										$paginasModel->setNome($pag['nome_pagina']);
										$paginasModel->setUrl($pag['url_pagina']);
										$paginasModel->setStatus($pag['status_pagina']);
										$paginasModel->setStatusSelecao($pag['status_selecao_pagina']);
										$this->_modulos[$mod['url_modulo']]->getSubModulos($subMod['url_modulo'])->setPaginas($paginasModel);
									}
								}
							}
						}

					}
				}



				$paginas = $this->getPaginas($mod['id_modulo']);

				if($paginas != false)
				{

					foreach ($paginas as $keyPag => $pag)
					{
						if(isset($permissoes[$mod['url_modulo']]['paginas'][$pag['url_pagina']] ))
						{
							$paginasModel = new paginasModel();
							$paginasModel->setId($pag['id_pagina']);
							$paginasModel->setNome($pag['nome_pagina']);
							$paginasModel->setUrl($pag['url_pagina']);
							$paginasModel->setStatus($pag['status_pagina']);
							$paginasModel->setStatusSelecao($pag['status_selecao_pagina']);
							$this->_modulos[$mod['url_modulo']]->setPaginas($paginasModel, 'getUrl');
						}
					}
				}
			}
		}
		endif;
	}









	/**
	* Gera o array do menu para permissões administrativa
	*/
	public function geraArrayMenu($id){
		$modulos = $this->getModule($id);
		if(!empty($modulos)):
		foreach ($modulos as $keyMod => $mod)
		{
			$modulosModel = new modulosModel();
			$modulosModel->setId($mod['id_modulo']);
			$modulosModel->setNome($mod['nome_modulo']);
			$modulosModel->setUrl($mod['url_modulo']);
			$modulosModel->setStatus($mod['status_modulo']);
			$modulosModel->setStatusSelecao($mod['status_selecao_modulo']);
			$modulosModel->setFotoModulo($mod['icone_modulo']);


			$this->_modulos[$mod['url_modulo']] = $modulosModel;
			
			unset($modulosModel);

			//se existir submodulos
			$submodulos = $this->getModule($mod['id_modulo']);
			if($submodulos != false)
			{
				foreach ($submodulos as $keySubMod => $subMod)
				{
					$subModulosModel = new modulosModel();
					$subModulosModel->setId($subMod['id_modulo']);
					$subModulosModel->setNome($subMod['nome_modulo']);
					$subModulosModel->setUrl($subMod['url_modulo']);
					$subModulosModel->setStatus($subMod['status_modulo']);
					$subModulosModel->setStatusSelecao($subMod['status_selecao_modulo']);

					$this->_modulos[$mod['url_modulo']]->setSubModulos($subModulosModel,'getUrl');

					$paginas = $this->getPaginas($subMod['id_modulo']);
					
					if($paginas != false)
					{
						foreach ($paginas as $keyPag => $pag)
						{
							$paginasModel = new paginasModel();
							$paginasModel->setId($pag['id_pagina']);
							$paginasModel->setNome($pag['nome_pagina']);
							$paginasModel->setUrl($pag['url_pagina']);
							$paginasModel->setStatus($pag['status_pagina']);
							$paginasModel->setStatusSelecao($pag['status_selecao_pagina']);
							$this->_modulos[$mod['url_modulo']]->getSubModulos($subMod['url_modulo'])->setPaginas($paginasModel);

						}
					}
					

				}
			}



			$paginas = $this->getPaginas($mod['id_modulo']);

			if($paginas != false)
			{

				foreach ($paginas as $keyPag => $pag)
				{
					$paginasModel = new paginasModel();
					$paginasModel->setId($pag['id_pagina']);
					$paginasModel->setNome($pag['nome_pagina']);
					$paginasModel->setUrl($pag['url_pagina']);
					$paginasModel->setStatus($pag['status_pagina']);
					$paginasModel->setStatusSelecao($pag['status_selecao_pagina']);
					$this->_modulos[$mod['url_modulo']]->setPaginas($paginasModel, 'getUrl');
					
				}
			}
		}
		endif;
	}


	/**
	* Cria o menu a partir do array gerado pela permissão
	*/
	public function geraMenu()
	{	
		$url = new url();
		$activeHome = ( $url->getSegment(0) == false || strtolower($url->getSegment(0)) == 'home') ? 'active' : '';
		$menu = '<ul class="nav navbar-nav">';
        	foreach ($this->_modulos as $modulo):


        		$aux = $modulo->getUrl();
				$$aux = '';
				if($url->getSegment(0) == $modulo->getUrl()){
					$aux = $modulo->getUrl();
					$$aux = 'active';
				}

				if(!empty($modulo->getPaginas()) || !empty($modulo->getSubModulos())):
					$menu .= '<li class="dropdown">';
			            $menu .= '<a href="'.URL.$modulo->getUrl().'" class="dropdown-toggle '.$$aux.'" title="'.$modulo->getNome().'" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="'.$modulo->getFotoModulo().'"></span><p>'.$modulo->getNome().'</p><span class="caret"></span></a>';
		            		//inicion do submenu
		            		$menu .= '<ul class="dropdown-menu">';
					if(!empty($modulo->getPaginas())):
			            foreach ($modulo->getPaginas() as $pag):
			                $menu .='<li><a href="'.URL.$modulo->getUrl().'/'.$pag->getUrl().'">'.$pag->getNome().'</a></li>';
			            endforeach;
					endif;
					if(!empty($modulo->getSubModulos())):
				        foreach ($modulo->getSubmodulos() as $subMod):
						    if(!empty($subMod->getPaginas())):
								$menu .= '<li class="dropdown">';
									$menu .= '<a href="'.URL.$modulo->getUrl().'/'.$subMod->getUrl().'" title="'.$subMod->getNome().'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$subMod->getNome().'</a>';
									    	$menu .= '<ul class="dropdown-menu">';
								       		foreach ($subMod->getPaginas() as $pag):
								        		$menu .= '<li><a href="'.URL.$modulo->getUrl().'/'.$subMod->getUrl().'/'.$pag->getUrl().'">'.$pag->getNome().'</a></li>';
								            endforeach;
					        				$menu .= '</ul>';
						        $menu .= '</li>';
							else:
								$menu .='<li><a href="'.URL.$modulo->getUrl().'/'.$subMod->getUrl().'" title="'.$subMod->getNome().'">'.$subMod->getNome().'</a></li>';
							endif;
				        endforeach;

					endif;
			        		$menu .= '</ul>';

			        $menu .= '</li>';
				else:
					$menu .= '<li class="'.$$aux.'"><a href="'.URL.$modulo->getUrl().'" title="'.$modulo->getNome().'"><span class="'.$modulo->getFotoModulo().'"></span><p>'.$modulo->getNome().'</p></a></li>';
				endif;
			endforeach; 
        $menu .= '</ul>';
		return $menu;
	}
}



/**
*
*class: menu
*
*location : library/menu.class.php
*/
		