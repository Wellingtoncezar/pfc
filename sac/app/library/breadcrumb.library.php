<?php
/**
* Cria o breadcrumb das páginas
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class breadcrumb extends Controller{
	private $breadcrumbList;
	public function __construct()
	{
		$this->breadcrumbList .= '<li><a href="'.URL.'">Home</a></li>';
		$url = new url();

		if($url->getSegment(0) != false){
			$module = $this->getModule('0',$url->getSegment(0));
			if($module != false)
			{
				//modulo
				$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'">'.$module['nome_modulo'].'</a></li>';
				if($url->getSegment(1) != false)
				{

					$pagina = $this->getPaginas($module['id_modulo'],$url->getSegment(1));

					if($pagina != false)
					{
						//pagina do modulo
						$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$pagina['url_pagina'].'">'.$pagina['nome_pagina'].'</a></li>';

						if($url->getSegment(2) != false)
						{
							
							if($actionPag = $this->getAction($pagina['id_pagina'],$url->getSegment(2)))
							{
								$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$pagina['url_pagina'].'/'.$action['url_action'].'">'.$actionPag['nome_action'].'</a></li>';
							}
						}
					}else
					if($submodule = $this->getModule($module['id_modulo'],$url->getSegment(1)))
					{

						//submodulo
						$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$submodule['url_modulo'].'">'.$submodule['nome_modulo'].'</a></li>';

						if($url->getSegment(2) != false)//paginas
						{
							if($paginaSub = $this->getPaginas($submodule['id_modulo'],$url->getSegment(2)))
							{
								$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$submodule['url_modulo'].'/'.$paginaSub['url_pagina'].'">'.$paginaSub['nome_pagina'].'</a></li>';
							
								if($url->getSegment(3) != false)
								{
									
									if($actionSubPag = $this->getAction($paginaSub['id_pagina'],$url->getSegment(3)))
									{
										$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$submodule['url_modulo'].'/'.$paginaSub['url_pagina'].'/'.$actionSubPag['url_action'].'">'.$actionSubPag['nome_action'].'</a></li>';
									}
								}
							}
						}else
							$this->breadcrumbList .= '<li><a href="'.URL.$module['url_modulo'].'/'.$pagina['url_modulo'].'">'.$pagina['nome_modulo'].'</a></li>';
					}
					
				}
				
			}

		}
		print($this->breadcrumbList);
	}
	
	/**
	* retorna o módulo especificado
	*/
	private function getModule($idModulePai,$seg)
	{
		$this->clear();
		$this->setTabela('modulos');
		$this->setCondicao('status_modulo = "Ativo" and status_selecao="Ativo" AND url_modulo = "'.$seg.'" and id_modulo_pai = "'.$idModulePai.'"');
		$this->setOrderBy('posicao_modulo');
		$this->select(array('id_modulo,url_modulo,nome_modulo'));
		if($this->rowCount()>0)
		{
			return $this->result();
		}else
			return false;
	}

	/**
	* retorna a página especificada
	*/
	private function getPaginas($idModule,$seg)
	{
		$this->clear();
		$this->setTabela('paginas');
		$this->setCondicao('id_modulo = "'.$idModule.'" and url_pagina = "'.$seg.'" AND status_pagina = "Ativo" and status_selecao="Ativo"');
		$this->setOrderBy('posicao_pagina');
		$this->select(array('id_pagina,url_pagina,nome_pagina'));
		if($this->rowCount()>0)
		{
			return $this->result();

		}else
			return false;
	}


	/**
	* retorna a função especificada
	*/
	private function getAction($idPagina,$seg)
	{
		$this->clear();
		$this->setTabela('actions');
		$this->setCondicao('id_pagina = "'.$idPagina.'" and url_action = "'.$seg.'" AND status_action = "Ativo" and status_selecao="Ativo"');
		$this->setOrderBy('posicao_action');
		$this->select(array('id_action,url_action,nome_action'));
		if($this->rowCount()>0)
		{
			return $this->result();

		}else
			return false;
	}	
}

/**
*
*class: breadcrumb
*
*location : library/breadcrumb.class.php
*/