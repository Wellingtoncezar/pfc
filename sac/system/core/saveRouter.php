<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('URL')) die('Acesso não permitido');
class saveRouter
{
	private $db;
	private $route = ROUTE;
	private $controller = CONTROLLER;
	private $action = ACTION;
	private $_idModulo;
	private $_idPagina = 0;
	private $load = null;

	public function __construct(){
		$this->load = Load::getInstance();
        $this->load->_autoloadComplement();
        
		$this->load->library('db');
		$this->db = new db();
	}

	/**
	*@return void
	*Seta o controller atual para inserir no banco
	*/
	public function setController($controller)
	{
		$this->controller = $controller;
	}




	/**
	*@return void
	*Seta a action atual para inserir no banco
	*/
	public function setAction($action)
	{
		$this->action = $action;
	}


	/**
	*@return void
	*Seta o rota (caminho até o controller) atual para inserir no banco
	*/
	public function setRout($route)
	{
		$this->route = $route;
	}



	/**
	*@return void
	*Salva o módulo, o controller e a action no banco
	*/
	public function saveModule(){

		/*********************************************/
		/*INSERINDO OS MÓDULOS*/
		$rota = rtrim($this->route,DIRECTORY_SEPARATOR); //remove as barras do final da string
		$rota = ltrim($rota,DIRECTORY_SEPARATOR);
		$rota = explode(DIRECTORY_SEPARATOR,$rota);

		$this->_idModulo = 0;

		foreach ($rota as $modulo)
		{
			$this->db->clear();
			$this->db->setTabela('sys_modulos');
			$this->db->setCondicao('url_modulo = "'.$modulo.'"');
			$this->db->select();
			//verifica se o módulo já está cadastrado
			if($this->db->rowCount()>0)
			{
				//se tiver retorna o id do módulo
				$res = $this->db->result();
				$this->_idModulo = $res['id_modulo'];
			}else
			{

				//senão o insere 
				$dataValue = array(
					'url_modulo' => $modulo,
					'id_modulo_pai' =>$this->_idModulo,
					'status_modulo' =>'INATIVO',
					'status_selecao_modulo' =>'INATIVO',
					'data_criacao_modulo' => date('Y-m-d H:i:s')
				);

				$this->db->insert($dataValue);
			
				if($this->db->rowCount() > 0)
				{
					//retorna o id do módulo inserido
					$this->db->query('SELECT id_modulo FROM sys_modulos ORDER BY id_modulo DESC LIMIT 1');
					$res = $this->db->result();
					$this->_idModulo = $res['id_modulo'];

				}else{
					echo 'erro';
				}
			}
		}

		$this->_idPagina = 0;
		//INSERINDO AS PÁGINAS
		$this->db->clear();

		$this->db->setTabela('sys_paginas');
		$this->db->setCondicao('url_pagina = "'.$this->controller.'" and id_modulo="'.$this->_idModulo.'"');
		$this->db->select();
		if($this->db->rowCount() > 0){
			$res = $this->db->result();
			$this->_idPagina = $res['id_pagina'];
		}else
		{
			$dataValue = array(
				'url_pagina'=> $this->controller,
				'id_modulo' => $this->_idModulo,
				'status_pagina' => 'INATIVO',
				'status_selecao_pagina' => 'INATIVO',
				'data_criacao_pagina' => date('Y-m-d H:i:s')
			);
			$this->db->insert($dataValue);
			if($this->db->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->db->query('SELECT id_pagina FROM sys_paginas ORDER BY id_pagina DESC LIMIT 1');
				$res = $this->db->result();
				$this->_idPagina = $res['id_pagina'];

			}
		}



		

		/**************************************/
	}


	public function saveAction(){
		$_idAction = 0;
		//INSERINDO AS ACTIONS
		$this->db->clear();

		$this->db->setTabela('sys_actions');
		$this->db->setCondicao('url_action = "'.$this->action.'" and id_pagina="'.$this->_idPagina.'"');
		$this->db->select();
		if($this->db->rowCount() > 0){
			$res = $this->db->result();
			$_idAction = $res['id_action'];
		}else
		{
			$dataValue = array(
				'url_action'=> $this->action,
				'id_pagina' => $this->_idPagina,
				'status_action' => 'INATIVO',
				'status_selecao_action' => 'INATIVO',
				'data_criacao_action' => date('Y-m-d H:i:s')
			);
			$this->db->insert($dataValue);
			if($this->db->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->db->query('SELECT id_action FROM sys_actions ORDER BY id_action DESC LIMIT 1');
				$res = $this->db->result();
				$this->_idPagina = $res['id_action'];
			}
		}
	}
}