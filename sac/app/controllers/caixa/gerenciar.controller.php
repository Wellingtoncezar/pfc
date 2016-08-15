<?php
/*
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/*---------------------------
	- PÁGINAS
	=============================*/


	/**
	*Página index
	*/
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Caixa'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/home',$data);
		$this->load->view('includes/footer',$data);
	}

	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Cadastrar caixas',
			'template' => new templateFactory()

		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('caixa/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();

		$data = array(
			'titlePage' => 'Editar caixa',
			'template' => new templateFactory()
		);
		//ID
		$idCaixas = intval($this->load->url->getSegment(3));
		
		//caixa MODEL
		$this->load->model('caixa/caixasModel');
		$caixasModel = new caixasModel();
		$caixasModel->setId($idCaixas);

		//caixa DAO
		$this->load->dao('caixa/caixasDao');
		$caixasDao = new caixasDao();
		$data['caixa'] = $caixasDao->consultar($caixasModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat', null, true);
		$data['dataFormat'] = $this->load->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('caixa/editar',$data);
		$this->load->view('includes/footer',$data);
	}


	/*----------------------------
	- AÇÕES
	=============================*/
	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		
		$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
		$ip = $this->getIp();
	

		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Codigo', $codigo, 'codigo')->is_required()->min_length(2);
		$this->load->dataValidator->set('Ip', $ip, 'ip')->is_required();

		
		if ($this->load->dataValidator->validate())
		{
		
			//CAIXAS
			$this->load->model('caixa/caixasModel');
			$caixasModel = new caixasModel();
			
			$caixasModel->setCodigo($codigo);
			$caixasModel->setIp($ip);
			$caixasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//caixas DAO
			$this->load->dao('caixa/caixasDao');
			$caixasDao = new caixasDao();
			echo $caixasDao->inserir($caixasModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}



	/**
	 * Ação do editar
	 */
	/**
	 * Ação do cadastrar
	 */
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var($_POST['id']) : '';
		$codigo = isset($_POST['codigo']) ? filter_var($_POST['codigo']) : '';
		$ip = $this->getIp();



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Codigo', $codigo, 'codigo')->is_required()->min_length(2);
		$this->load->dataValidator->set('Ip', $ip, 'ip')->is_required();

		
		if ($this->load->dataValidator->validate())
		{
		
			//CAIXAS
			$this->load->model('caixa/caixasModel');
			$caixasModel = new caixasModel();
			$caixasModel->setId($id);
			$caixasModel->setCodigo($codigo);
			$caixasModel->setIp($ip);
			$caixasModel->setDataCadastro(date('Y-m-d h:i:s'));


			//caixas DAO
			$this->load->dao('caixa/caixasDao');
			$caixasDao = new caixasDao();
			echo $caixasDao->atualizar($caixasModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}
	private function getIp()
    	{
    	    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    	    {
    	        return $_SERVER['HTTP_CLIENT_IP'];
    	    }
    	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    	    {
    	        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    	    }
    	    else{
    	        return $_SERVER['REMOTE_ADDR'];
    	    }
    	}

public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$this->atualizarStatus();
	}


	public function getjsoncaixa()
	{
		$this->load->dao('caixa/caixasDao');
		$this->load->dao('caixa/iListagemCaixa');
		$caixasDao = new caixasDao();
		$caixa = $caixasDao->listar();
		echo $caixasDao->listar($caixa);
	}
}

/**
*
*class: home
*
*location : controllers/home.controller.php
*/
