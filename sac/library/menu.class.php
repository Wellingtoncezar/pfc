<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso não permitido');
class menu extends Controller{
	private $_modulos = array();
	private $_menu = '';
	public function __construct()
	{
		/*
		$modulos['configuracoes']['url'] = 'configuracoes';
		$modulos['configuracoes']['nome'] = 'Configurações';
		$modulos['configuracoes']['nome'] = 'Configurações';
		$modulos['configuracoes']['submodulo'] = array();
		$modulos['configuracoes']['submodulo']['nome']
		*/

		
		$permissao = $_SESSION['login_adm']['permissao'];
		if($permissao != 'Administrador')
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
		$this->clear();
		$this->setTabela('modulos');
		$this->setCondicao('id_modulo_pai = "'.$id.'" and status_modulo = "Ativo" and status_selecao="Ativo"');
		$this->setOrderBy('posicao_modulo');
		$this->select(array('id_modulo,url_modulo,nome_modulo,foto_modulo'));
		if($this->rowCount()>0)
		{
			return $this->resultAll();

		}else
			return false;
	}

	/**
	* Retorna a página especificada
	*/
	private function getPaginas($id)
	{
		$this->clear();
		$this->setTabela('paginas');
		$this->setCondicao('id_modulo = "'.$id.'" and status_pagina = "Ativo" and status_selecao="Ativo"');
		$this->setOrderBy('posicao_pagina');
		$this->select(array('id_pagina,url_pagina,nome_pagina'));
		if($this->rowCount()>0)
		{
			return $this->resultAll();

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
		$permissoes = json_decode($_SESSION['login_adm']['listaPermissao'], true);
		$modulos = $this->getModule($id);
		foreach ($modulos as $keyMod => $mod)
		{
			
			if(array_key_exists($mod['url_modulo'], $permissoes))
			{

				$this->_modulos[$mod['url_modulo']]['id']= $mod['id_modulo'];
				$this->_modulos[$mod['url_modulo']]['url']= $mod['url_modulo'];
				$this->_modulos[$mod['url_modulo']]['nome']= $mod['nome_modulo'];
				$this->_modulos[$mod['url_modulo']]['foto']= $mod['foto_modulo'];
				if(!isset($this->_modulos[$mod['url_modulo']]['paginas']))
					$this->_modulos[$mod['url_modulo']]['paginas']= array();

				if(!isset($this->_modulos[$mod['url_modulo']]['submodulos']))
					$this->_modulos[$mod['url_modulo']]['submodulos']= array();

				//se existir submodulos
				$submodulos = $this->getModule($mod['id_modulo']);
				if($submodulos != false)
				{
					foreach ($submodulos as $keySubMod => $subMod)
					{
						if(array_key_exists($subMod['url_modulo'], $permissoes[$mod['url_modulo']]['submodulos']))
						{
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']] = array();
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['id'] = $subMod['id_modulo'];
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['nome'] = $subMod['nome_modulo'];
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['url'] = $subMod['url_modulo'];
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['paginas'] = array();

							$paginas = $this->getPaginas($subMod['id_modulo']);
							
							if($paginas != false)
							{
								foreach ($paginas as $keyPag => $pag)
								{
									if(array_key_exists($pag['url_pagina'], $permissoes[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]))
									{
										$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['paginas'][$pag['url_pagina']] =array(
											'id'=> $pag['id_pagina'],
											'url'=>$pag['url_pagina'], 
											'nome' => $pag['nome_pagina']
											);
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

						if(array_key_exists($pag['url_pagina'], $permissoes[$mod['url_modulo']]['paginas']))
						{
							$this->_modulos[$mod['url_modulo']]['paginas'][$pag['url_pagina']] = array(
								'id'=>$pag['id_pagina'],
								'url'=>$pag['url_pagina'], 
								'nome' => $pag['nome_pagina']
							);
						}
					}
				}
			}
		}
	}









	/**
	* Gera o array do menu para permissões administrativa
	*/
	public function geraArrayMenu($id){
		$modulos = $this->getModule($id);
		foreach ($modulos as $keyMod => $mod)
		{
			$this->_modulos[$mod['url_modulo']]['id']= $mod['id_modulo'];
			$this->_modulos[$mod['url_modulo']]['url']= $mod['url_modulo'];
			$this->_modulos[$mod['url_modulo']]['nome']= $mod['nome_modulo'];
			$this->_modulos[$mod['url_modulo']]['foto']= $mod['foto_modulo'];
			if(!isset($this->_modulos[$mod['url_modulo']]['paginas']))
				$this->_modulos[$mod['url_modulo']]['paginas']= array();

			if(!isset($this->_modulos[$mod['url_modulo']]['submodulos']))
				$this->_modulos[$mod['url_modulo']]['submodulos']= array();

			//se existir submodulos
			$submodulos = $this->getModule($mod['id_modulo']);
			if($submodulos != false)
			{
				foreach ($submodulos as $keySubMod => $subMod)
				{
					$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']] = array();
					$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['id'] = $subMod['id_modulo'];
					$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['nome'] = $subMod['nome_modulo'];
					$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['url'] = $subMod['url_modulo'];
					$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['paginas'] = array();

					$paginas = $this->getPaginas($subMod['id_modulo']);
					
					if($paginas != false)
					{
						foreach ($paginas as $keyPag => $pag)
						{
							$this->_modulos[$mod['url_modulo']]['submodulos'][$subMod['url_modulo']]['paginas'][$pag['url_pagina']] =array(
										'id'=> $pag['id_pagina'],
										'url'=>$pag['url_pagina'], 
										'nome' => $pag['nome_pagina']
										);
						}
					}

				}
			}



			$paginas = $this->getPaginas($mod['id_modulo']);

			if($paginas != false)
			{

				foreach ($paginas as $keyPag => $pag)
				{
					$this->_modulos[$mod['url_modulo']]['paginas'][$pag['url_pagina']] = array(
							'id'=>$pag['id_pagina'],
							'url'=>$pag['url_pagina'], 
							'nome' => $pag['nome_pagina']
						);
				}
			}
		}
	}


	/**
	* Retorna o número de registros na lixeira
	*/
	private function getNumLixeira(){
		$this->loadModel('lixeira/lixeiraModel');
		$lixeira = new lixeiraModel();
		$nLixo = $lixeira->getNumLixeira();
		if($nLixo > 0)
			return '<span class="badge" style="  position: absolute;
  				top: 0;
  				right: 1px;
  				background-color: #FFF;
  				color: #0E5E34;
  				box-shadow: 1px 1px 5px 0px #000;
  				font-size: 10px;
  				padding: 3px 5px;">'.$nLixo.'</span>';
		else 
			return '';
	}

	/**
	* Cria o menu a partir do array gerado pela permissão
	*/
	public function geraMenu()
	{	
		$url = new url();
		$menu = '<ul class="nav navbar-nav" id="main-menu">';
        	foreach ($this->_modulos as $modulo):
        		if($modulo['url'] == 'lixeira')
        			$numLixo = $this->getNumLixeira();
        		else
        			$numLixo = '';

				echo $$modulo['url'] = '';
				if($url->getSegment(0) == $modulo['url'])
					$$modulo['url'] = 'active';
				if(!empty($modulo['paginas']) || !empty($modulo['submodulos'])):
					$menu .= '<li class="menu-item dropdown">';
			            $menu .= '<a href="javascript:void(0)" title="'.$modulo['nome'].'" class="dropdown-toggle '.$$modulo['url'].'" data-toggle="dropdown"><figure><img src="'.URL.'uploads/modulos/mod_'.$modulo['id'].'/'.$modulo['foto'].'"></figure>'.$modulo['nome'].$numLixo.'<span class="caret"></span></a>';
		            		$menu .= '<ul class="dropdown-menu">';
					if(!empty($modulo['paginas'])):
			            foreach ($modulo['paginas'] as $pag):
			                $menu .='<li><a href="'.URL.$modulo['url'].'/'.$pag['url'].'">'.$pag['nome'].'</a></li>';
			            endforeach;
					endif;
					if(!empty($modulo['submodulos'])):
				        foreach ($modulo['submodulos'] as $subMod):
						    if(!empty($subMod['paginas'])):
								$menu .= '<li class="menu-item dropdown dropdown-submenu">';
									$menu .= '<a href="javascript:void(0)" title="'.$subMod['nome'].'" class="dropdown-toggle" data-toggle="dropdown">'.$subMod['nome'].'</a>';
							    	$menu .= '<ul class="dropdown-menu">';
						       		foreach ($subMod['paginas'] as $pag):
						        		$menu .= '<li class="menu-item"><a href="'.URL.$modulo['url'].'/'.$subMod['url'].'/'.$pag['url'].'">'.$pag['nome'].'</a></li>';
						            endforeach;
			        				$menu .= '</ul>';
						        $menu .= '</li>';
							else:
								$menu .='<li class="menu-item"><a href="'.URL.$modulo['url'].'/'.$subMod['url'].'" title="'.$subMod['nome'].'">'.$subMod['nome'].'</a></li>';
							endif;
				        endforeach;

					endif;
			        		$menu .= '</ul>';
			        $menu .= '</li>';
				else:
					$menu .= '<li class="menu-item"><a href="'.URL.$modulo['url'].'" title="'.$modulo['nome'].'" class="'.$$modulo['url'].'"><figure><img src="'.URL.'uploads/modulos/mod_'.$modulo['id'].'/'.$modulo['foto'].'"></figure>'.$modulo['nome'].$numLixo.'</a></li>';
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
		