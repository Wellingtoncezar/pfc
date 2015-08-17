<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class estado_civil extends Controller{
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
			'titulo' => 'Tabela - Estado civil',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadocivil = new estadoCivilModel();
		$estado_civil = $estadocivil->listar();
		$data['estadosCivil'] = $estado_civil;

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/estado_civil/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/**
	*Página de cadastro de estado civil
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => ''
		);

		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/estado_civil/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	*Página de edição de estado civil
	*/
	public function editar()
	{
		$this->saveAction();
		$url = new url();
		$id = intval($url->getSegment(4));
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadoCivil = new estadoCivilModel();
		$estadoCivil = $estadoCivil->getEstadoCivil($id);
		$status = '';

		if($estadoCivil['status_estado_civil'] == 'Ativo')
			$status = 'checked';

		$data = array(
			'titulo' => 'Editar estado civil',
			'id_estado_civil' => $id,
			'nome_estado_civil' => htmlentities($estadoCivil['nome_estado_civil'],ENT_QUOTES),
			'status_estado_civil' =>$status
		);

		$this->loadView('includes/baseTop',$data);
		if($estadoCivil != false)
			$this->loadView('configuracoes/tabelas/estado_civil/editar',$data);
		else
			$this->loadView('template/registro_nao_encontrado',$data);
		$this->loadView('includes/baseBottom',$data);
	}








	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/


	/**
	* Cadastro de um novo registro
	*/
	public function inserir()
	{
		$nome_estado_civil =isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($nome_estado_civil))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/tabelas/estadoCivilModel');
			$estadoCivil = new estadoCivilModel();
			$estadoCivil->setNome($nome_estado_civil);
			$estadoCivil->setStatus($status);
			if($estadoCivil->inserir())
				echo true;
			else
				echo json_encode(array('generalerror'=>'Erro ao inserir'));	
		}
	}



	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$nome_estado_civil =isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($nome_estado_civil))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else
		{
			$this->loadModel('configuracoes/tabelas/estadoCivilModel');
			$estadoCivil = new estadoCivilModel();
			$estadoCivil->setId($id);
			$estadoCivil->setNome($nome_estado_civil);
			$estadoCivil->setStatus($status);
			if($estadoCivil->atualizar())
				echo true;
			else
				echo json_encode(array('generalerror'=>'Erro ao atualizar'));	
		}
	}


	/**
	*Atualização do status do registro
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

		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadoCivil = new estadoCivilModel();
		$estadoCivil->setId($id);
		$estadoCivil->setStatus($status);
		if($estadoCivil->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}



	/**
	* Exclui um registro
	*/
	public function excluir()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadoCivil = new estadoCivilModel();
		$estadoCivil->setId($id);
		if($estadoCivil->deletar())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao excluir'));
	}
}

/**
*
*class: estado_civil
*
*location : controllers/configuracoes/tabelas/estado_civil.controller.php
*/