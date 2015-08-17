<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class superintendentes extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
		$checkPermissao = new checkPermissao();
		$checkPermissao->checkPermissaoPagina();
		//checagem do login
		$login = new loginModel();
		$login->statusLogin();
	}

/********************************************/
	/****PÁGINAS****/
	/**
	*Página index
	*/
	public function index()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Lista de superintendentes da EBD',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('ebd/superintendentesModel');
		$superintendentes = new superintendentesModel();
		$superintendentes = $superintendentes->listar();
		$data['superintendentes'] = $superintendentes;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/superintendentes/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo superintendente'
		);

		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/superintendentes/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar superintendente'
		);

		$this->loadModel('ebd/superintendentesModel');
		$superintendente = new superintendentesModel();
		$url = new url();
		$id = intval($url->getSegment(3));

		$superintendente->setId($id);
		$superintendente = $superintendente->getSuperintendente();


		


		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();
		$data['superintendente'] = $superintendente;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/superintendentes/editar',$data);
		$this->loadView('includes/baseBottom',$data);
	}




	/**
	*Exclusão apena para envia-lo à lixeira
	*/
	public function excluir()
	{
		$this->saveAction();
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('ebd/superintendentesModel');
		$membro = new superintendentesModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}







	/**
	*Atualiza o status 
	*/
	public function atualizarStatus()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('ebd/superintendentesModel');
		$superintendentes = new superintendentesModel();
		$superintendentes->setId($id);
		$superintendentes->setStatus($status);
		if($superintendentes->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}


	
	public function inserir()
	{
		$id_membro = isset($_POST['membro']) ? intval($_POST['membro']) : '';

		
		$data_inicio = isset($_POST['data_inicio']) ? filter_var(trim($_POST['data_inicio'])) : '';
		$data_fim = isset($_POST['data_fim']) ? filter_var(trim($_POST['data_fim'])) : '';



		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Membro', $id_membro, 'membro')->is_required();
		$validate->set('Data de início', $data_inicio, 'data_inicio')->is_required()->is_date('d/m/Y');
		$validate->set('Data do fim', $data_fim, 'data_fim')->is_required()->is_date('d/m/Y');
		
		if ($validate->validate())
		{
	        $this->loadModel('ebd/superintendentesModel');
			$superintendentes = new superintendentesModel();

			$superintendentes->setMembro($id_membro);
			$superintendentes->setDataInicio($data_inicio);
			$superintendentes->setDataFim($data_fim);

			echo $superintendentes->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}



	public function atualizar()
	{
		$id_superintendente = isset($_POST['id_superintendente']) ? intval($_POST['id_superintendente']) : '';
		$id_membro = isset($_POST['membro']) ? intval($_POST['membro']) : '';
		$data_inicio = isset($_POST['data_inicio']) ? filter_var(trim($_POST['data_inicio'])) : '';
		$data_fim = isset($_POST['data_fim']) ? filter_var(trim($_POST['data_fim'])) : '';



		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Membro', $id_membro, 'membro')->is_required();
		$validate->set('Data de início', $data_inicio, 'data_inicio')->is_required()->is_date('d/m/Y');
		$validate->set('Data do fim', $data_fim, 'data_fim')->is_required()->is_date('d/m/Y');
		
		if ($validate->validate())
		{
	        $this->loadModel('ebd/superintendentesModel');
			$superintendentes = new superintendentesModel();

			$superintendentes->setId($id_superintendente);
			$superintendentes->setMembro($id_membro);
			$superintendentes->setDataInicio($data_inicio);
			$superintendentes->setDataFim($data_fim);

			echo $superintendentes->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

}


/**
*
*class: superintendentes
*
*location : controllers/ebd/superintendentes.controller.php
*/