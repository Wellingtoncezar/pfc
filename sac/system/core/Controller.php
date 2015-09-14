<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Controller extends Load
{
	protected $rout; //caminho para o controller
	private $controller;
	private $action;
	private $_idModulo;
	private $_idPagina = 0;
	private static $instance;

	public function __construct(){
		parent::__construct();
		//$this->db = new db;
		self::$instance =& $this;

	}
	public static function &get_instance()
	{
		return self::$instance;
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
	public function setRout($rout)
	{
		$this->rout = $rout;
	}



	/**
	*@return void
	*Salva o módulo, o controller e a action no banco
	*/
	public function saveModules(){
		/*********************************************/
		/*INSERINDO OS MÓDULOS*/
		$rota = rtrim($this->rout,DIRECTORY_SEPARATOR); //remove as barras do final da string
		$rota = ltrim($rota,DIRECTORY_SEPARATOR);
		$rota = explode(DIRECTORY_SEPARATOR,$rota);

		$this->_idModulo = 0;

		foreach ($rota as $modulo)
		{
			$this->clear();
			$this->setTabela(PREFIXTABLE.'modulos');
			$this->setCondicao('url_modulo = "'.$modulo.'"');
			$this->select();
			//verifica se o módulo já está cadastrado
			if($this->rowCount()>0)
			{
				//se tiver retorna o id do módulo
				$res = $this->result();
				$this->_idModulo = $res['id_modulo'];
			}else
			{
				//senão o insere 
				$dataValue = array(
					'url_modulo' => $modulo,
					'id_modulo_pai' =>$this->_idModulo,
					'status_modulo' =>'Inativo',
					'data_criacao' => date('Y-m-d H:i:s')
				);
				$this->insert($dataValue);
				if($this->rowCount() > 0)
				{
					//retorna o id do módulo inserido
					$this->query('SELECT id_modulo FROM '.PREFIXTABLE.'modulos ORDER BY id_modulo DESC LIMIT 1');
					$res = $this->result();
					$this->_idModulo = $res['id_modulo'];

				}
			}
		}

		$this->_idPagina = 0;
		//INSERINDO AS PÁGINAS
		$this->clear();

		$this->setTabela(PREFIXTABLE.'paginas');
		$this->setCondicao('url_pagina = "'.$this->controller.'" and id_modulo="'.$this->_idModulo.'"');
		$this->select();
		if($this->rowCount() > 0){
			$res = $this->result();
			$this->_idPagina = $res['id_pagina'];
		}else
		{
			$dataValue = array(
				'url_pagina'=> $this->controller,
				'id_modulo' => $this->_idModulo,
				'status_pagina' => 'Inativo',
				'data_criacao' => date('Y-m-d H:i:s')
			);
			$this->insert($dataValue);
			if($this->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->query('SELECT id_pagina FROM '.PREFIXTABLE.'paginas ORDER BY id_pagina DESC LIMIT 1');
				$res = $this->result();
				$this->_idPagina = $res['id_pagina'];

			}
		}



		

		/**************************************/
	}


	public function saveAction(){
		$this->saveModules();
		
		$_idAction = 0;
		//INSERINDO AS ACTIONS
		$this->clear();

		$this->setTabela(PREFIXTABLE.'actions');
		$this->setCondicao('url_action = "'.$this->action.'" and id_pagina="'.$this->_idPagina.'"');
		$this->select();
		if($this->rowCount() > 0){
			$res = $this->result();
			$_idAction = $res['id_action'];
		}else
		{
			$dataValue = array(
				'url_action'=> $this->action,
				'id_pagina' => $this->_idPagina,
				'status_action' => 'Inativo',
				'data_criacao' => date('Y-m-d H:i:s')
			);
			$this->insert($dataValue);
			if($this->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->query('SELECT id_action FROM '.PREFIXTABLE.'actions ORDER BY id_action DESC LIMIT 1');
				$res = $this->result();
				$this->_idPagina = $res['id_action'];
			}
		}
	}
}