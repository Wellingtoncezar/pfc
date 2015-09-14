<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class Config extends Controller{
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



}