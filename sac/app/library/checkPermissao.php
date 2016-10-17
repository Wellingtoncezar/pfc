<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('URL')) die('Acesso negado');
class checkPermissao extends Library{
	private  $permissoes = null;
	private $lastArray = Array();
	private $latType;
	public function __construct(){
		parent::__construct();
		
	}

	private function searchInObject($object, $slug)
	{
		foreach ($object as $key => $value) 
		{
			if($value->getUrl() == $slug && $value->getAcesso() == true)
			{
				$this->lastArray = $value;
				return true;
			}
			
		}
		return false;
	}

	private function checkpermissao($slug)
	{
		 
		if($this->searchInObject($this->lastArray, $slug))
			return true;

		if(method_exists($this->lastArray, 'getModulos'))
			if($this->searchInObject($this->lastArray->getModulos(), $slug))
				return true;

		if(method_exists($this->lastArray, 'getPaginas'))
			if($this->searchInObject($this->lastArray->getPaginas(), $slug))
				return true;
				
		if(method_exists($this->lastArray, 'getActions'))
			if($this->searchInObject($this->lastArray->getActions(), $slug))
				return true;

		return false;
	}

	/**
	* Checa a permissão da página
	*/
	public function check($redirect = true, $url = '')
	{	
		//verifica se está logado, se existe usuário na sessão
		if($redirect== true && !isset($_SESSION['user']) ){
			session_destroy();
			header('Location: '.URL.'login');
			return false;
		}

		if($redirect == false && !isset($_SESSION['user']))
		{
			return false;
		}

		if(unserialize($_SESSION['user'])->getNivelAcesso()->gettipoPermissao() != tipopermissao::ADMINISTRADOR){
			$this->permissoes = unserialize($_SESSION['user'])->getNivelAcesso()->getPermissoes();
			$this->lastArray = $this->permissoes;	
		}
		else
			return true;


		$this->load->url = new url($url);
		$retorno = false;
		//se for diferente de administrador

		//se for diferente da tela inicial 
		if(!empty($this->load->url->getUrl())){
			//percorre todos os segmentos da url par verificação da permissão

			foreach ($this->load->url->getUrl() as $key => $value) 
			{
				if(empty($this->lastArray)){
					break;
				}
				//verifica a permissão e define o retorno
				if($this->checkpermissao($value))
					$retorno = true;
				else{
					$retorno = false;
					break;
				}
			}
		}else{
			$retorno = true;
		}

		// //se o retorno for false
		if($retorno == false)
		{	
			// e o redirecionamento for true, faz o redirecionamento e para tudo o que for executado depois do redirecionamento
			if($redirect == true){
				header('Location:'.URL.'acesso_negado');
				exit;
			}else{
				return false;
			}
		}else
			return true;
		
	}

}
