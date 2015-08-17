<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class checkPermissao extends Controller{
	private  $permissoes = null;
	private $actionButton; 
	public function __construct(){
		parent::__construct();
		$this->permissoes = json_decode($_SESSION['login_adm']['listaPermissao'] ,true );
	}

	/**
	* Checa a permissão da página
	*/
	public function checkPermissaoPagina()
	{	
		$retorno = false;
		if($_SESSION['login_adm']['listaPermissao'] != '')
		{
			$url = new url();
			$lastArray = null;
			if($url->getSegment(0) != false && array_key_exists($url->getSegment(0), $this->permissoes))
			{
				$lastArray = $this->permissoes[$url->getSegment(0)];
				if($url->getSegment(1) != false)//será procurado o submodulo
				{
					
					if(array_key_exists($url->getSegment(1), $lastArray['submodulos']))
					{
						if($url->getSegment(2) != false)
						{
							$lastArray = $lastArray['submodulos'][$url->getSegment(1)];
							if(array_key_exists($url->getSegment(2), $lastArray))
							{
								$retorno = true;
								
							}else
								$retorno = false;
						}else
						{
							if(array_key_exists('home', $lastArray))
							{
								$retorno = true;
								
							}else
								$retorno = false;
						}
					}else
					if(array_key_exists($url->getSegment(1), $lastArray['paginas']))//paginas
					{
						$retorno = true;
					}else
					{
						$retorno = false;
					}
				
				}else//senão deverá procurar dentro do módulo
				{
					//paginas do modulo
					if(array_key_exists($this->actionButton, $lastArray['paginas']['home']))
					{
						$retorno = true;
					}else
					{
						$retorno = false;
					}
					
				}
				
			}else
				$retorno = false;
		}else
			$retorno = true;


		
		if($retorno == false)
		{
			header('Location:'.URL.'acesso_negado');
			exit;
			//var_dump($retorno);
		}
		
	}

	/**
	* Verifica se a ação existe na lista de permissões
	*/
	public function acao($acao)
	{
		$this->actionButton = $acao;
		if($_SESSION['login_adm']['listaPermissao'] != '')
		{
			if(method_exists($this, $acao))
			{
				return $this->$acao();
			}else
				return false;
		}else
			return true;
	}

	
	private function cadastrar()
	{
		return $this->getButtonPermission();
	}

	private function editar()
	{
		return $this->getButtonPermission();
	}

	private function excluir()
	{
		return $this->getButtonPermission();
	}

	/**
	* Verifica a permissão do botão
	*/
	private function getButtonPermission()
	{
		$retorno = false;
		$url = new url();
		$lastArray = null;

		if($url->getSegment(0) != false && array_key_exists($url->getSegment(0), $this->permissoes))
		{
			$lastArray = $this->permissoes[$url->getSegment(0)];
			if($url->getSegment(1) != false)//será procurado o submodulo
			{

				if(array_key_exists($url->getSegment(1), $lastArray['submodulos']))
				{
					if($url->getSegment(2) != false)
					{
						$lastArray = $lastArray['submodulos'][$url->getSegment(1)];
						if(array_key_exists($url->getSegment(2), $lastArray))
						{
							$lastArray = $lastArray[$url->getSegment(2)];
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
				if(array_key_exists($url->getSegment(1), $lastArray['paginas']))//paginas
				{
					$lastArray = $lastArray['paginas'][$url->getSegment(1)];
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
				//paginas do modulo
				if(array_key_exists($this->actionButton, $lastArray['paginas']['home']))
				{
					$retorno = true;
				}else
				{
					$retorno = false;
				}
			}
		}else
			$retorno = false;


		return $retorno;
	}
}


/**
*
*class: checkPermissao
*
*location : library/checkPermissao.class.php
*/