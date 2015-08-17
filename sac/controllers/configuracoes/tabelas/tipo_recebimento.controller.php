<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipo_recebimento extends Controller{
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
			'titulo' => 'Tabela - Tipo de recebimento',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimentos = new tipoRecebimentoModel();
		$tipo_recebimentos = $tipoRecebimentos->listar();
		$data['tipoRecebimentos'] = $tipo_recebimentos;

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/tipo_recebimento/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/**
	*Página de cadastro
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => ''
		);

		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/tipo_recebimento/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	/**
	*Página de edição
	*/
	public function editar()
	{
		$this->saveAction();
		$url = new url();
		$id = intval($url->getSegment(4));
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimentos = new tipoRecebimentoModel();
		$tipoRecebimentos = $tipoRecebimentos->getTipoRecebimento($id);
		$status = '';

		if($tipoRecebimentos['status_tipo_recebimento'] == 'Ativo')
			$status = 'checked';

		$data = array(
			'titulo' => 'Editar estado civil',
			'letra_tipo_recebimento' => $tipoRecebimentos['letra_tipo_recebimento'], 
			'id_tipo_recebimento' => $id,
			'nome_tipo_recebimento' => htmlentities($tipoRecebimentos['nome_tipo_recebimento'],ENT_QUOTES),
			'status_tipo_recebimento' =>$status
		);

		$this->loadView('includes/baseTop',$data);
		if($tipoRecebimentos != false)
			$this->loadView('configuracoes/tabelas/tipo_recebimento/editar',$data);
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
		$letra_tipo_recebimento = isset($_POST['letra']) ? filter_var(trim($_POST['letra'])) : '';
		$nome_tipo_recebimento = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($letra_tipo_recebimento))
		{
			$this->countError++;
			$this->error['erro'][] = array("letra"=>"selecione uma letra");
		}

		if(!validate::string($nome_tipo_recebimento))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
			$tipoRecebimentos = new tipoRecebimentoModel();
			$tipoRecebimentos->setNome($nome_tipo_recebimento);
			$tipoRecebimentos->setStatus($status);
			$tipoRecebimentos->setLetra($letra_tipo_recebimento);
			if($tipoRecebimentos->inserir())
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
		$letra_tipo_recebimento =isset($_POST['letra']) ? filter_var(trim($_POST['letra'])) : '';
		$nome_tipo_recebimento =isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		if(!validate::string($letra_tipo_recebimento))
		{
			$this->countError++;
			$this->error['erro'][] = array("letra"=>"selecione uma letra");
		}

		if(!validate::string($nome_tipo_recebimento))
		{
			$this->countError++;
			$this->error['erro'][] = array("nome"=>"Insira o nome corretamente");
		}


		if($this->countError > 0)
			echo json_encode($this->error);
		else
		{
			$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
			$tipoRecebimentos = new tipoRecebimentoModel();
			$tipoRecebimentos->setId($id);
			$tipoRecebimentos->setNome($nome_tipo_recebimento);
			$tipoRecebimentos->setLetra($letra_tipo_recebimento);
			$tipoRecebimentos->setStatus($status);
			if($tipoRecebimentos->atualizar())
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

		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimentos = new tipoRecebimentoModel();
		$tipoRecebimentos->setId($id);
		$tipoRecebimentos->setStatus($status);
		if($tipoRecebimentos->atualizarStatus())
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
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimentos = new tipoRecebimentoModel();
		$tipoRecebimentos->setId($id);
		if($tipoRecebimentos->deletar())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao excluir'));
	}
}

/**
*
*class: tipo_recebimento
*
*location : controllers/configuracoes/tabelas/tipo_recebimento.controller.php
*/
