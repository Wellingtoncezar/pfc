<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class checkPermissao extends Library{
	private  $permissoes = null;
	private $actionButton; 
	private $url;
	public function __construct(){
		parent::__construct();
		$this->permissoes = json_decode(stripslashes($_SESSION['login_adm']['listaPermissao']) ,true );
		$this->url = new url();
	}

	/**
	* Checa a permissão da página
	*/
	public function checkPermissaoPagina($redirect = true)
	{	
		$retorno = false;
		if($_SESSION['login_adm']['listaPermissao'] != '')
		{
			$lastArray = null;
			if($this->url->getSegment(0) != false && array_key_exists($this->url->getSegment(0), $this->permissoes))
			{
				$lastArray = $this->permissoes[$this->url->getSegment(0)];
				if($this->url->getSegment(1) != false)//será procurado o submodulo
				{
					if(array_key_exists($this->url->getSegment(1), $lastArray['submodulos']))
					{

						if($this->url->getSegment(2) != false)
						{
							$lastArray = $lastArray['submodulos'][$this->url->getSegment(1)];
							if(array_key_exists($this->url->getSegment(2), $lastArray))
							{
								if($this->url->getSegment(3) != false)
								{
									$retorno = $this->acao($this->url->getSegment(3));
								}else{
									$retorno = true;
								}
							}else
								$retorno = false;
						}else
						{

							// if(array_key_exists('home', $lastArray))
							// {
							// 	$retorno = true;
								
							// }else
								$retorno = true;
						}
					}else
					if(array_key_exists($this->url->getSegment(1), $lastArray['paginas']))//paginas
					{
						if($this->url->getSegment(2) != false)
							$retorno = $this->acao($this->url->getSegment(2));
						else
							$retorno = true;
					}else
					{
						$retorno = false;
					}
				
				}else//senão deverá procurar dentro do módulo
				{
					if($this->actionButton != NULL)
					{
						//paginas do modulo
						if(array_key_exists($this->actionButton, $lastArray['paginas']['home']))
						{
							$retorno = true;
						}else
						{
							$retorno = false;
						}
					}else//senao é a home do módulo
						$retorno = true;
				}
				
			}else
				$retorno = false;
		}else
			$retorno = true;


		
		if($retorno == false)
		{
			if($redirect == true){
				header('Location:'.URL.'acesso_negado');
				exit;
			}else{
				return false;
			}
			//var_dump($retorno);
		}
		
	}

	/**
	* Verifica se a ação existe na lista de permissões
	*/
	public function acao($acao, $url = '')
	{
		$this->actionButton = $acao;
		if($_SESSION['login_adm']['listaPermissao'] != '')
		{
			if($url != '')
				$this->url->explodeUrl($url);

			return $this->getButtonPermission();
		}else
			return true;
	}



	/**
	* Verifica a permissão do botão
	*/
	private function getButtonPermission()
	{
		$retorno = false;
		$url = new url();
		$lastArray = null;

		if($this->url->getSegment(0) != false && array_key_exists($this->url->getSegment(0), $this->permissoes))
		{
			$lastArray = $this->permissoes[$this->url->getSegment(0)];
			if($this->url->getSegment(1) != false)//será procurado o submodulo
			{

				if(array_key_exists($this->url->getSegment(1), $lastArray['submodulos']))
				{
					if($this->url->getSegment(2) != false)
					{
						$lastArray = $lastArray['submodulos'][$this->url->getSegment(1)];
						if(array_key_exists($this->url->getSegment(2), $lastArray))
						{
							$lastArray = $lastArray[$this->url->getSegment(2)];
							if(array_key_exists($this->actionButton, $lastArray))
							{
								$retorno = true;
							}else
								$retorno = false;
						}else
							$retorno = false;
					}else
					{
						
						if(array_key_exists('home', $lastArray))
						{
							$lastArray = $lastArray['home'];
							if(array_key_exists($this->actionButton, $lastArray))
							{
								$retorno = true;
							}else
								$retorno = false;
						}else
							$retorno = false;
					}
				}else
				if(array_key_exists($this->url->getSegment(1), $lastArray['paginas']))//paginas
				{
					$lastArray = $lastArray['paginas'][$this->url->getSegment(1)];
					if(array_key_exists($this->actionButton, $lastArray))
					{
						$retorno = true;
					}else
					{
						$retorno = false;
					}
				}else
				{
					$retorno = false;
				}

			}else//senão deverá procurar dentro do módulo
			{

				$this->actionButton;
				if($this->actionButton != NULL)
				{
					if(isset($lastArray['paginas']['home']))
					{
						//paginas do modulo
						if(array_key_exists($this->actionButton, $lastArray['paginas']['home']))
						{
							$retorno = true;
						}else
						{
							$retorno = false;
						}
					}else
						$retorno = false;
				}else
				 	$retorno = true;
			}
		}else
			$retorno = false;


		return $retorno;
	}
}
