<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipo_email extends Controller{
	private $error = array();
	private $countError = 0;
	public function __construct(){
		parent::__construct();
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
			'titulo' => 'Tabela - Tipo de e-mail',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipo_email = $tipoEmail->listar();
		$data['tipoEmail'] = $tipo_email;

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/tipo_email/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/**
	* Página de cadastro
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => ''
		);

		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/tipo_email/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	* Página de edição
	*/
	public function editar()
	{
		$this->saveAction();
		$url = new url();
		$id = intval($url->getSegment(4));
		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipoEmail = $tipoEmail->getTipoEmail($id);
		$status = '';

		if($tipoEmail['status_tipo_email'] == 'Ativo')
			$status = 'checked';

		$data = array(
			'titulo' => 'Editar email',
			'id_tipo_email' => $id,
			'nome_tipo_email' => htmlentities($tipoEmail['nome_tipo_email'],ENT_QUOTES),
			'status_tipo_email' =>$status
		);

		$this->loadView('includes/baseTop',$data);
		if($tipoEmail != false)
			$this->loadView('configuracoes/tabelas/tipo_email/editar',$data);
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
		$nome_tipo_email = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($nome_tipo_email))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/tabelas/tipoEmailModel');
			$tipoEmail = new tipoEmailModel();
			$tipoEmail->setNome($nome_tipo_email);
			$tipoEmail->setStatus($status);
			if($tipoEmail->inserir())
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
		$nome_tipo_email =isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($nome_tipo_email))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else
		{
			$this->loadModel('configuracoes/tabelas/tipoEmailModel');
			$tipoEmail = new tipoEmailModel();
			$tipoEmail->setId($id);
			$tipoEmail->setNome($nome_tipo_email);
			$tipoEmail->setStatus($status);
			if($tipoEmail->atualizar())
				echo true;
			else
				echo json_encode(array('generalerror'=>'Erro ao atualizar'));	
		}
	}


	/**
	* Atualização do status do registro
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

		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipoEmail->setId($id);
		$tipoEmail->setStatus($status);
		if($tipoEmail->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
		
			
	}


	/**
	*Exclui um registro
	*/
	public function excluir()
	{
		$this->saveAction();
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipoEmail->setId($id);
		if($tipoEmail->deletar())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao excluir'));
	}
}


/**
*
*class: tipo_email
*
*location : controllers/configuracoes/tabelas/tipo_email.controller.php
*/