<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class secretaria extends Controller{
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
			'titulo' => 'Lista de secretaria da EBD',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('ebd/secretariaModel');
		$secretaria = new secretariaModel();
		$secretaria = $secretaria->listar();
		$data['secretaria'] = $secretaria;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/secretaria/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo secretaria'
		);

		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/secretaria/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar secretaria'
		);

		$this->loadModel('ebd/secretariaModel');
		$secretaria = new secretariaModel();
		$url = new url();
		$id = intval($url->getSegment(3));

		$secretaria->setId($id);
		$secretaria = $secretaria->getsecretaria();


		


		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();
		$data['secretaria'] = $secretaria;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/secretaria/editar',$data);
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

		$this->loadModel('ebd/secretariaModel');
		$membro = new secretariaModel();
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

		$this->loadModel('ebd/secretariaModel');
		$secretaria = new secretariaModel();
		$secretaria->setId($id);
		$secretaria->setStatus($status);
		if($secretaria->atualizarStatus())
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
	        $this->loadModel('ebd/secretariaModel');
			$secretaria = new secretariaModel();

			$secretaria->setMembro($id_membro);
			$secretaria->setDataInicio($data_inicio);
			$secretaria->setDataFim($data_fim);

			echo $secretaria->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}



	public function atualizar()
	{
		$id_secretaria = isset($_POST['id_secretaria']) ? intval($_POST['id_secretaria']) : '';
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
	        $this->loadModel('ebd/secretariaModel');
			$secretaria = new secretariaModel();

			$secretaria->setId($id_secretaria);
			$secretaria->setMembro($id_membro);
			$secretaria->setDataInicio($data_inicio);
			$secretaria->setDataFim($data_fim);

			echo $secretaria->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

}

/**
*
*class: secretaria
*
*location : controllers/ebd/secretaria.controller.php
*/