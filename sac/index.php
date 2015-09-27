<?php 

//TEMPO DE EXECUÇÃO
// Iniciamos o "contador"
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;

/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/

if (!version_compare(PHP_VERSION, '5.4.0', '>=')) {
   echo 'I am at least PHP version 5.4.0, my version: ' . PHP_VERSION . "\n";
   exit;
}
define('APPPATH','app');

require_once('include.php');

class _initialize extends Router{
	public function __construct(){
		parent::__construct();
		$this->rout = '';

		if($this->getSegment(0) != false) //verifica se existe o 1º segmento na url
		{
			//se existir verifica primeiro se é um diretório
			if($this->checkDir($this->rout.$this->getSegment(0)))
			{
				$this->rout.= $this->getSegment(0).DIRECTORY_SEPARATOR;//adciona à rota

				//verifica e existe o proximo segmento
				if($this->getSegment(1) != false) //verifica se existe o 2º segmento na url
				{
					//se existir verifica o primeiro se é um diretório
					if($this->checkDir($this->rout.$this->getSegment(1)))
					{
						$this->rout .= $this->getSegment(1).DIRECTORY_SEPARATOR;//adciona à rota
						
						if($this->getSegment(2) != false)
						{
							$this->controller = $this->getSegment(2);
							if($this->getSegment(3) != false)
								$this->action = $this->getSegment(3);
							else
								$this->action = "index";
						}else
						{
							//senão inclui o controller default 
							$this->controller 	= DEFAULT_CONTROLLER;
							$this->action = "index";
						}
					}else
					{
						$this->controller 	= $this->getSegment(1);
						if($this->getSegment(2) != false)
							$this->action = $this->getSegment(2);
						else
							$this->action = "index";
					}
				}else
				{
					//senão inclui o controller default 
					$this->controller 	= DEFAULT_CONTROLLER;
					$this->action = "index";
				}

			}else
			{
				//será um método
				$this->controller = $this->getSegment(0);
				if($this->getSegment(1) != false)
					$this->action = $this->getSegment(1);
				else
					$this->action = "index";
			}
		}else
		{
			$this->controller = DEFAULT_CONTROLLER;
			$this->action = "index";
		}

		/*
		apenas para checagem dos caminhos
		//echo '<p>ROUT FILE: '.$routFile.'</p>';
		echo '<pre style="position:fixed; z-index:99999">';
		echo '<p>ROTA COMPLETA: '.$this->rout.'</p>';
		echo '<p>NOME Controller: '.$this->controller.'</p>';
		echo '<p>NOME METODO: '.$this->action.'</p>';
		echo '</pre>';
		*/
		$_controller = $this->controller;
		

		$thiser = $this->load->controller($this->rout.$this->controller);
		if($thiser)
		{
			

			$_controller = $this->controller;

			//echo $this->rout;
			$action = $this->action;
			if(method_exists($this->$_controller, $action))
			{
				//cadastra os módulos, controllers e actions da pagina antes de chama-la
				$this->setAction($action);
				$this->setController($this->controller);
				$this->setRout($this->rout);
				
				$this->saveModules();
				//echo $this->controller;
				$this->$_controller->$action();
			}
			else{
				$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
				require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
			}
		}else{
			$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
			require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
		}
	}
}

new _initialize;

//$this->load('url');





// Tempo de execução
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
//echo '<pre style="position: absolute;width: 100%;bottom: 0;margin: 0;z-index: 999;background-color: #383838;color: #FFF;font-size: 17px;">Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb</pre>';
