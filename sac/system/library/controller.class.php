<?php
if(!defined('URL')) die('Acesso não permitido');
abstract class Controller extends load
{
	private $rout; //caminho para o controller
	protected $controller = DEFAULT_CONTROLLER;
	public function __construct()
	{
		parent::__construct();
		$this->rout = BASEPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR;

		if($this->getSegment(0) != false) //verifica se existe o 1º segmento na url
		{
			//se existir verifica o primeiro se é um diretório
			if(is_dir($this->rout.$this->getSegment(0)))
			{
				$this->rout 		.= $this->getSegment(0);//adciona à rota
				$this->controller 	= $this->getSegment(0);
				//verifica e existe o proximo segmento
				if($this->getSegment(1) != false) //verifica se existe o 2º segmento na url
				{
					//se existir verifica o primeiro se é um diretório
					if(is_dir($this->rout.$this->getSegment(1)))
					{
						$this->rout 		.= $this->getSegment(1);//adciona à rota
						$this->controller 	.= $this->getSegment(1);
					}


				}else
				{
					//senão inclui o controller default 
					$this->controller 	= DEFAULT_CONTROLLER;
					//echo 'nao existe é o controller default';
				}

				
					echo '<p>'.$this->rout.'</p>';
			}else
			{
				echo 'diretório não encontrado';
			}

			
				


			/*if(file_exists('controllers'.DIRECTORY_SEPARATOR.$this->getSegment(0).'.class.php')){
				$_controller = $this->getSegment(0);
				$this->controller = new $_controller();
			}
			else{
				$_errorControler = _404_OVERRRIDE;
				$this->controller = new $_errorControler();
			}

			if($this->getSegment(1) != false)
			{
				if(method_exists($this->controller, $this->getSegment(1)))
				{
					$action = $this->getSegment(1);
					$this->controller->$action();
				}else
					echo 'Não existe o método';
			}else
			{
				$this->controller->index();
			}
			*/
		}else
		{
			$_controler = DEFAULT_CONTROLLER;
			$this->controller = new $_controler();
			$this->controller->index();
		}



		$_controller = $this->controller.'.class.php';
		//echo $_controller;
		//require_once($this->rout);
		//$this->controller = new $_controller();
		//$this->controller->index();

	}




	public function load($controller,$param = array())
	{
		if(!empty($param)){
			return new $controller();
		}

	}

	public function view($view,$content = array())
	{
		$ge = $this;
		extract ($content, EXTR_PREFIX_SAME, "_");
		if(file_exists(VIEWS.DIRECTORY_SEPARATOR.$view))
			include(VIEWS.DIRECTORY_SEPARATOR.$view);
		else
			echo 'erro ao incluir';
	}
}