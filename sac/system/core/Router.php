<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class Router extends Common{
	private $url;
	private $currentUrl;

	public function __construct()
	{
		if (!defined('URL'))
		{
			if (isset($_SERVER['HTTP_HOST']))
			{
				$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
				$base_url .= '://'. $_SERVER['HTTP_HOST'];
				$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
			}else
			{
				$base_url = 'http://localhost/';
			}

			define('URL',$base_url);
			
		}
		
		$server = 'http://'.$_SERVER['SERVER_NAME'].'/'; 
		$endereco = $_SERVER ['REQUEST_URI'];
		$endereco = rtrim($endereco,'/'); //remove as barras do final da string
		$endereco = ltrim($endereco,'/'); //remove as barras do começo da string
		$url = $server.$endereco.'/';//endereço completo
		$this->currentUrl = $url;
		$url = str_replace(URL, '', $url);//remove o endereço original e fica apenas o caminho
		$url = explode('/',$url);
		$url =array_filter($url);//remove todos os índices vazios
		$newArr =array();
		foreach ($url as $value) { //para ordenar o array pelo índice
			$newArr[] = $value;
		}
		$this->url = $newArr;
		unset($url);
		unset($newArr);

		parent::__construct();
	}


	public function getUrl()
	{
		return $this->url;//retorna o array da url
	}

	public function getCurrentUrl()
	{
		return $this->currentUrl;
	}


	public function getSegment($chave)//retorna o segmento da url
	{
		if(array_key_exists($chave, $this->url))//se existir a categoria
			return strtolower($this->url[$chave]);
		else
			return false;
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
			$this->db->clear();
			$this->db->setTabela(PREFIXTABLE.'modulos');
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
					'status_modulo' =>'Inativo',
					'data_criacao' => date('Y-m-d H:i:s')
				);
				$this->db->insert($dataValue);
				if($this->db->rowCount() > 0)
				{
					//retorna o id do módulo inserido
					$this->db->query('SELECT id_modulo FROM '.PREFIXTABLE.'modulos ORDER BY id_modulo DESC LIMIT 1');
					$res = $this->db->result();
					$this->_idModulo = $res['id_modulo'];

				}
			}
		}

		$this->_idPagina = 0;
		//INSERINDO AS PÁGINAS
		$this->db->clear();

		$this->db->setTabela(PREFIXTABLE.'paginas');
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
				'status_pagina' => 'Inativo',
				'data_criacao' => date('Y-m-d H:i:s')
			);
			$this->db->insert($dataValue);
			if($this->db->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->db->query('SELECT id_pagina FROM '.PREFIXTABLE.'paginas ORDER BY id_pagina DESC LIMIT 1');
				$res = $this->db->result();
				$this->_idPagina = $res['id_pagina'];

			}
		}



		

		/**************************************/
	}


	public function saveAction(){
		$this->saveModules();
		
		$_idAction = 0;
		//INSERINDO AS ACTIONS
		$this->db->clear();

		$this->db->setTabela(PREFIXTABLE.'actions');
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
				'status_action' => 'Inativo',
				'data_criacao' => date('Y-m-d H:i:s')
			);
			$this->db->insert($dataValue);
			if($this->db->rowCount() > 0)
			{
				//retorna o id do módulo inserido
				$this->db->query('SELECT id_action FROM '.PREFIXTABLE.'actions ORDER BY id_action DESC LIMIT 1');
				$res = $this->db->result();
				$this->_idPagina = $res['id_action'];
			}
		}
	}


}