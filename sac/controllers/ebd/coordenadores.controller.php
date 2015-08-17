<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class coordenadores extends Controller{
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
			'titulo' => 'Lista de coordenadores da EBD',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('ebd/coordenadoresModel');
		$coordenadores = new coordenadoresModel();
		$coordenadores = $coordenadores->listar();
		$data['coordenadores'] = $coordenadores;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/coordenadores/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo coordenador'
		);

		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/coordenadores/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar coordenador'
		);

		$this->loadModel('ebd/coordenadoresModel');
		$coordenador = new coordenadoresModel();
		$url = new url();
		$id = intval($url->getSegment(3));

		$coordenador->setId($id);
		$coordenador = $coordenador->getCoordenador();


		


		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();
		$data['coordenador'] = $coordenador;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/coordenadores/editar',$data);
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

		$this->loadModel('ebd/coordenadoresModel');
		$membro = new coordenadoresModel();
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

		$this->loadModel('ebd/coordenadoresModel');
		$coordenadores = new coordenadoresModel();
		$coordenadores->setId($id);
		$coordenadores->setStatus($status);
		if($coordenadores->atualizarStatus())
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
	        $this->loadModel('ebd/coordenadoresModel');
			$coordenadores = new coordenadoresModel();

			$coordenadores->setMembro($id_membro);
			$coordenadores->setDataInicio($data_inicio);
			$coordenadores->setDataFim($data_fim);

			echo $coordenadores->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}



	public function atualizar()
	{
		$id_coordenador = isset($_POST['id_coordenador']) ? intval($_POST['id_coordenador']) : '';
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
	        $this->loadModel('ebd/coordenadoresModel');
			$coordenadores = new coordenadoresModel();

			$coordenadores->setId($id_coordenador);
			$coordenadores->setMembro($id_membro);
			$coordenadores->setDataInicio($data_inicio);
			$coordenadores->setDataFim($data_fim);

			echo $coordenadores->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

}

/**
*
*class: coordenadores
*
*location : controllers/ebd/coordenadores.controller.php
*/