<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipo_oficio_igreja extends Controller{
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
			'titulo' => 'Tabela - Tipo de ofício da igreja',
			'method' => __METHOD__
		);

		//carregamento do model e listagem
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja = $tipoOficioIgreja->listar();
		$data['tipoOficioIgreja'] = $tipoOficioIgreja;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('configuracoes/tabelas/tipo_oficio_igreja/home',$data);
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
		$this->loadView('configuracoes/tabelas/tipo_oficio_igreja/cadastrar',$data);
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
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficio = new tipoOficioIgrejaModel();
		$tipoOficioIgreja = $tipoOficio->getTipoOficioIgreja($id);
		$status = '';

		if($tipoOficioIgreja['status_tipo_oficio_igreja'] == 'Ativo')
			$status = 'checked';

		$data = array(
			'titulo' => 'Editar Oficio da igreja',
			'id_tipo_oficio_igreja' => $id,
			'nome_tipo_oficio_igreja' => htmlentities($tipoOficioIgreja['nome_tipo_oficio_igreja'],ENT_QUOTES),
			'statusOficioIgreja' => $tipoOficio->getStatusOficio(),
			'status_tipo_oficio_igreja' =>$status
		);

		$this->loadView('includes/baseTop',$data);
		if($tipoOficioIgreja != false)
			$this->loadView('configuracoes/tabelas/tipo_oficio_igreja/editar',$data);
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
		$nome_tipo_oficio_igreja = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$statusOficio =isset($_POST['statusOficio']) ? $_POST['statusOficio'] : array();
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		$validate = new DataValidator();
		$validate->set('Nome', $nome_tipo_oficio_igreja, 'nome')->is_required();



		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
			$tipoOficioIgreja = new tipoOficioIgrejaModel();
			$tipoOficioIgreja->setNome($nome_tipo_oficio_igreja);
			$tipoOficioIgreja->setStatus($status);
			$tipoOficioIgreja->setStatusOficio($statusOficio);
			if($tipoOficioIgreja->inserir())
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
		$nome_tipo_oficio_igreja = isset($_POST['nome']) ? filter_var(trim($_POST['nome'])) : '';
		$statusOficio =isset($_POST['statusOficio']) ? $_POST['statusOficio'] : array();
		$status =isset($_POST['status']) ? 'Ativo' : 'Inativo';

		$listStatusExcluir = isset($_POST['listStatusExcluir']) ? $_POST['listStatusExcluir'] : array();


		$validate = new DataValidator();
		$validate->set('Nome', $nome_tipo_oficio_igreja, 'nome')->is_required();



		if($this->countError > 0)
			echo json_encode($this->error);
		else{
			$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
			$tipoOficioIgreja = new tipoOficioIgrejaModel();
			$tipoOficioIgreja->setId($id);
			$tipoOficioIgreja->setNome($nome_tipo_oficio_igreja);
			$tipoOficioIgreja->setStatus($status);
			$tipoOficioIgreja->setStatusOficio($statusOficio);
			$tipoOficioIgreja->setListExcluirStatusOficio($listStatusExcluir);

			if($tipoOficioIgreja->atualizar())
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

		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja->setId($id);
		$tipoOficioIgreja->setStatus($status);
		if($tipoOficioIgreja->atualizarStatus())
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
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja->setId($id);
		if($tipoOficioIgreja->deletar())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao excluir'));
	}
}

/**
*
*class: tipo_oficio_igreja
*
*location : controllers/configuracoes/tabelas/tipo_oficio_igreja.controller.php
*/