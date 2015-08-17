<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class departamentos extends Controller{
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
			'titulo' => 'Lista de departamentos da EBD',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('ebd/departamentosModel');
		$departamentos = new departamentosModel();
		$departamentos = $departamentos->listar();
		$data['departamentos'] = $departamentos;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/departamentos/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo departamento'
		);

		$this->loadModel('ebd/coordenadoresModel');
		$coordenadores = new coordenadoresModel();

		$data['coordenadores'] = $coordenadores->listar('=','Ativo');


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/departamentos/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar departamento'
		);

		$this->loadModel('ebd/departamentosModel');
		$departamento = new departamentosModel();
		$url = new url();
		$id = intval($url->getSegment(3));

		$departamento->setId($id);
		$departamento = $departamento->getDepartamento();

		$data['departamento'] = $departamento;
		


		$this->loadModel('ebd/coordenadoresModel');
		$coordenadores = new coordenadoresModel();
		$data['coordenadores'] = $coordenadores->listar();


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/departamentos/editar',$data);
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

		$this->loadModel('ebd/departamentosModel');
		$membro = new departamentosModel();
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

		$this->loadModel('ebd/departamentosModel');
		$departamentos = new departamentosModel();
		$departamentos->setId($id);
		$departamentos->setStatus($status);
		if($departamentos->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}


	
	public function inserir()
	{
		$coordenador = isset($_POST['coordenador']) ? intval($_POST['coordenador']) : '';
		$nome_departamento = isset($_POST['nome_departamento']) ? filter_var(trim($_POST['nome_departamento'])) : '';

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome do departamento', $nome_departamento, 'nome_departamento')->is_required();

		if ($validate->validate())
		{
	        $this->loadModel('ebd/departamentosModel');
			$departamentos = new departamentosModel();

			$departamentos->setCoordenador($coordenador);
			$departamentos->setNomeDepartamento($nome_departamento);

			echo $departamentos->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}



	public function atualizar()
	{
		$id_departamento = isset($_POST['id_departamento']) ? intval($_POST['id_departamento']) : '';
		$coordenador = isset($_POST['coordenador']) ? intval($_POST['coordenador']) : '';
		$nome_departamento = isset($_POST['nome_departamento']) ? filter_var(trim($_POST['nome_departamento'])) : '';

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome do departamento', $nome_departamento, 'nome_departamento')->is_required();

		if ($validate->validate())
		{
	        $this->loadModel('ebd/departamentosModel');
			$departamentos = new departamentosModel();

			$departamentos->setId($id_departamento);
			$departamentos->setCoordenador($coordenador);
			$departamentos->setNomeDepartamento($nome_departamento);

			echo $departamentos->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

}

/**
*
*class: departamentos
*
*location : controllers/ebd/departamentos.controller.php
*/