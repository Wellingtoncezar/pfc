<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class checkPermissao extends Library{
	private  $permissoes = null;
	private $url;
	private $lastArray = Array();
	private $latType;
	public function __construct(){
		parent::__construct();
		
	}

	private function checkpermissao($value)
	{
		// echo '<pre>';
		// echo '<h2>'.$value.'</h2>';
		// print_r($this->lastArray);
		// echo '</pre>';
		//VERIFICA EXISTE O ÍNDICE de "$VALUE" NO ULTIMO ARRAY PERCORRIDO
		if(array_key_exists($value, $this->lastArray))
		{
			$this->latType = "modulo";
			$this->lastArray = $this->lastArray[$value];
			return true;
		}elseif(isset($this->lastArray['submodulos']) && array_key_exists($value, $this->lastArray['submodulos']))//SE FOR PARA SUBMODULOS
		{	
			$this->latType = "submodulo";
			$this->lastArray = $this->lastArray['submodulos'][$value];
			return true;
		}elseif(isset($this->lastArray['paginas']) && array_key_exists($value, $this->lastArray['paginas']))//SE FOR PARA PÁGINAS (CONTROLLERS)
		{
			$this->latType = "pagina";
			$this->lastArray = $this->lastArray['paginas'][$value];
			return true;
		}else
		{
			$this->lastArray = Array();
			return false;
			
		}
	}

	/**
	* Checa a permissão da página
	*/
	public function check($redirect = true, $url = '')
	{	
		//verifica se está logado, se existe usuário na sessão
		if(!isset($_SESSION['user'])){
			session_destroy();
			header('Location: '.URL.'login');
			return false;
		}

		if(unserialize($_SESSION['user'])->getNivelAcesso()->getPermissoes() != '*'){
			$this->permissoes = unserialize($_SESSION['user'])->getNivelAcesso()->getPermissoes();
			$this->permissoes = json_decode(html_entity_decode($this->permissoes),true);
			$this->lastArray = $this->permissoes;	
		}
		else
			return true;

		$this->url = new url($url);
		$retorno = false;
		//se for diferente de administrador

			//se for diferente da tela inicial 
			if(!empty($this->url->getUrl())){
				//percorre todos os segmentos da url par verificação da permissão
				foreach ($this->url->getUrl() as $key => $value) 
				{
					if(!is_array($this->lastArray) || empty($this->lastArray))
						break;
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

			//se o retorno for false
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
