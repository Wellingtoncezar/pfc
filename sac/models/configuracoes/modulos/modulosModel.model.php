<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class modulosModel extends Controller{
	private $tree = array();
	private $tipo;
	private $id;
	private $campo;
	private $valor;

	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}

	public function setId($id)
	{
		$this->id = $id;
	}
	public function setValor($valor)
	{
		$this->valor = $valor;
	}
	public function setCampo($campo)
	{
		$this->campo = $campo;
	}

	/**
	* Listagem dos módulos
	*/
	public function listar($id_modulo)
	{
		$modulo = $this->getSubModulos($id_modulo);
		if($modulo != false)
		{
			foreach ($modulo as $mod)
			{
				$this->tree[$mod['id_modulo']] = array(
					'nome' 			=> $mod['nome_modulo'],
					'url' 			=> $mod['url_modulo'],
					'status'		=> $mod['status_modulo'],
					'status_selecao'		=> $mod['status_selecao'],
					'submodulos' 	=> array(),
					'paginas'		=> array(),
				);
				$auxSubmod = array();
				$submodulo = $this->getSubModulos($mod['id_modulo']);
				//pegando os submodulos
				if($submodulo != false)
				{
					foreach ($submodulo as $submod)
					{
						$this->tree[$mod['id_modulo']]['submodulos'][$submod['id_modulo']] = array(
							'nome' 			=> $submod['nome_modulo'],
							'url' 			=> $submod['url_modulo'],
							'status'		=> $submod['status_modulo'],
							'status_selecao'		=> $submod['status_selecao'],
							'paginas'		=> array(),
						);
						//pegando as páginas
						$auxPag = array();
						$paginasModulo = $this->getPaginas($submod['id_modulo']);
						if($paginasModulo != false)
						{
							foreach ($paginasModulo as $pagina)
							{
								$this->tree[$mod['id_modulo']]['submodulos'][$submod['id_modulo']]['paginas'][$pagina['id_pagina']] = array(
									'nome' 		=> $pagina['nome_pagina'],
									'url' 		=> $pagina['url_pagina'],
									'status'	=> $pagina['status_pagina'],
									'status_selecao'	=> $pagina['status_selecao'],
									'acoes' 	=> array()
								);

								//pegando as actions
								$acoes = $this->getAcoes($pagina['id_pagina']);
								$auxAcao = array();
								if($acoes != false)
								{
									foreach ($acoes as $acao)
									{
										$this->tree[$mod['id_modulo']]['submodulos'][$submod['id_modulo']]['paginas'][$pagina['id_pagina']]['acoes'][$acao['id_action']] = array(
											'nome' 		=> $acao['nome_action'],
											'url' 		=> $acao['url_action'],
											'status'	=> $acao['status_action'],
											'status_selecao'	=> $acao['status_selecao'],
		 								);
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
						$this->tree[$mod['id_modulo']]['paginas'][$pagina['id_pagina']] = array(
							'nome' 		=> $pagina['nome_pagina'],
							'url' 		=> $pagina['url_pagina'],
							'status'	=> $pagina['status_pagina'],
							'status_selecao'	=> $pagina['status_selecao'],
							'acoes' 	=> array()
						);

						$acoes = $this->getAcoes($pagina['id_pagina']);
						$auxAcao = array();
						if($acoes != false)
						{
							foreach ($acoes as $acao)
							{
								$this->tree[$mod['id_modulo']]['paginas'][$pagina['id_pagina']]['acoes'][$acao['id_action']] = array(
									'nome' 		=> $acao['nome_action'],
									'url' 		=> $acao['url_action'],
									'status'	=> $acao['status_action'],
									'status_selecao'	=> $acao['status_selecao'],
 								);
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
		$this->setTabela('modulos');
		$this->setCondicao('id_modulo = "'.$id_modulo.'" and status_modulo = "Ativo"');
		$this->select();
		if($this->rowCount() > 0){
			return $this->result();
		}
		else
			return false;
	}


	public function getSubModulos($id_modulo){
		$this->clear();
		$this->setTabela('modulos');
		$this->setCondicao('id_modulo_pai = "'.$id_modulo.'" and id_modulo<> "0"');
		$this->setOrderBy('posicao_modulo');
		$this->select();
		if($this->rowCount() > 0){
			return $this->resultAll();
		}
		else
			return false;
	}

	public function getPaginas($id_modulo){
		$this->clear();
		$this->setTabela('paginas');
		$this->setCondicao('id_modulo = "'.$id_modulo.'"');
		$this->setOrderBy('posicao_pagina');
		$this->select();
		if($this->rowCount() > 0){
			return $this->resultAll();
		}
		else
			return false;
	}

	public function getAcoes($id_pagina){
		$this->clear();
		$this->setTabela('actions');
		$this->setCondicao('id_pagina = "'.$id_pagina.'"');
		$this->setOrderBy('posicao_action');
		$this->select();
		if($this->rowCount() > 0){
			return $this->resultAll();
		}
		else
			return false;
	}


	private function atualizaModulos($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->clear();
		$this->setTabela('modulos');
		$this->setCondicao('id_modulo = "'.$id.'"');
		$this->update($data);
		if($this->rowCount()>0)
			return true;
		else
			return false;
	}


	private function atualizaPaginas($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->clear();
		$this->setTabela('paginas');
		$this->setCondicao('id_pagina = "'.$id.'"');
		$this->update($data);
		if($this->rowCount()>0)
			return true;
		else
			return false;
	}

	private function atualizaAcoes($id,$campo,$valor)
	{
		$data = array(
			$campo => $valor
		);
		$this->clear();
		$this->setTabela('actions');
		$this->setCondicao('id_action = "'.$id.'"');
		$this->update($data);
		if($this->rowCount()>0)
			return true;
		else
			return false;
	}

	public function atualizar()
	{	
		$tipos = array(
			'modulo' 	=> 'atualizaModulos',
			'submodulo' => 'atualizaModulos',
			'pagina'	=> 'atualizaPaginas',
			'acao'		=> 'atualizaAcoes'
		);
		return $this->$tipos[$this->tipo]($this->id, $this->campo, $this->valor);
	}


	public function updatePosition($positions)
	{
		$error = 0;
		foreach ($positions as $position => $item)
	    {
	    	$item = str_replace('listItem_','',$item);
	      	try{
				$this->setTabela('modulos');
				$arr = array(
					'posicao_modulo' => $position
				);
				$this->setCondicao("id_modulo = '$item'");
				$this->update($arr);
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

/**
*
*class: modulosModel
*
*location : models/configuracoes/modulos/modulosModel.model.php
*/