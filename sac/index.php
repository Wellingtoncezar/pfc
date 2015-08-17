<?php 
/*
TEMPO DE EXECUXÃO
// Iniciamos o "contador"
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;
*/
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
require_once('include.php');

$url = new url();
$load = new load();
$load->loadLibrary('url');
$url = new url();
$load->rout = '';//BASEPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR;

if($url->getSegment(0) != false) //verifica se existe o 1º segmento na url
{
	//se existir verifica primeiro se é um diretório
	if($load->checkDir($load->rout.$url->getSegment(0)))
	{
		$load->rout.= $url->getSegment(0).DIRECTORY_SEPARATOR;//adciona à rota
		//verifica e existe o proximo segmento
		if($url->getSegment(1) != false) //verifica se existe o 2º segmento na url
		{
			//se existir verifica o primeiro se é um diretório

			if($load->checkDir($load->rout.$url->getSegment(1)))
			{
				$load->rout .= $url->getSegment(1).DIRECTORY_SEPARATOR;//adciona à rota
				
				if($url->getSegment(2) != false)
				{
					$load->controller = $url->getSegment(2);
					if($url->getSegment(3) != false)
						$load->action = $url->getSegment(3);
					else
						$load->action = "index";
				}else
				{
					//senão inclui o controller default 
					$load->controller 	= DEFAULT_CONTROLLER;
					$load->action = "index";
				}
			}else
			{
				$load->controller 	= $url->getSegment(1);
				if($url->getSegment(2) != false)
					$load->action = $url->getSegment(2);
				else
					$load->action = "index";
			}
		}else
		{
			//senão inclui o controller default 
			$load->controller 	= DEFAULT_CONTROLLER;
			$load->action = "index";
		}

	}else
	{
		//será um método
		$load->controller = $url->getSegment(0);
		if($url->getSegment(1) != false)
			$load->action = $url->getSegment(1);
		else
			$load->action = "index";
	}
}else
{
	$load->controller = DEFAULT_CONTROLLER;
	$load->action = "index";
}

/*
apenas para checagem dos caminhos
echo '<p>ROUT FILE: '.$routFile.'</p>';
echo '<p>ROTA COMPLETA: '.$load->rout.'</p>';
echo '<p>NOME Controller: '.$load->controller.'</p>';
echo '<p>NOME METODO: '.$load->action.'</p>';
*/

$_controller = $load->controller;
$loader = $load->loadController($load->rout.$load->controller);
if($loader)
{
	$_controller = new $load->controller();

	//echo $load->rout;
	$action = $load->action;
	if(method_exists($_controller, $action))
	{
		//cadastra os módulos, controllers e actions da pagina antes de chama-la
		$_controller->setAction($action);
		$_controller->setController($load->controller);
		$_controller->setRout($load->rout);
		$_controller->saveModules();
		$_controller->$action();
	}
	else{
		$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
						<p>A página que você procura não foi encontrada.</p>
						<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
		require_once(BASEPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
	}
}else{
	$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
						<p>A página que você procura não foi encontrada.</p>
						<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
	require_once(BASEPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
}

/*

// Terminamos o "contador" e exibimos
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
// Exibimos uma mensagem
echo 'Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb';
*/