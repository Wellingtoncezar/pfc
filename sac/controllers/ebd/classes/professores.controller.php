<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class professores extends Controller{
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
			'titulo' => 'Professores da Escola Bíblica Dominical',
			'method' => __METHOD__
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		//carregamento do model e listagem

		$this->loadModel('ebd/professoresModel');
		$professores = new professoresModel();
		//$professores->setClasse($id);
		$professores = $professores->listar();
		$data['professores'] = $professores;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/professores/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	public function classe()
	{
		
		$this->saveAction();
		$data = array(
			'titulo' => 'professores da Escola Bíblica Dominical',
			'method' => __METHOD__
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		//carregamento do model e listagem

		$this->loadModel('ebd/professoresModel');
		$professores = new professoresModel();
		$professores->setClasse($id);
		$professores = $professores->listar();
		$data['professores'] = $professores;


		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/professores/professores',$data);
		$this->loadView('includes/baseBottom',$data);
	}





	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo professor'
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		$this->loadModel('membros/membrosModel');

		$membros = new membrosModel();
		$membros = $membros->listar('=','Ativo');
		$data['membros'] = $membros;

		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/professores/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	public function visualizar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo professor'
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		$this->loadModel('ebd/professoresModel');

		$professores = new professoresModel();
		$professores->setId($id);
		$professores = $professores->getProfessor();
		$data['membro'] = $professores;

		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/professores/visualizar',$data);
		$this->loadView('includes/baseBottom',$data);
	}





	public function aulas()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Aulas'
		);


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/aulas',$data);
		$this->loadView('includes/baseBottom',$data);

	}


	public function inserir()
	{
		$id_classe = isset($_POST['id_classe']) ? filter_var($_POST['id_classe']) : '';
		$membro = isset($_POST['membro']) ? filter_var($_POST['membro']) : '';
		
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Membro', $membro, 'membro')->is_required();
		
		if ($validate->validate())
		{
	        $this->loadModel('ebd/professoresModel');
			$professores = new professoresModel();
			$professores->setClasse($id_classe);
			$professores->setMembro($membro);
			$professores->setStatus('Ativo');
			echo $professores->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}


	public function atualizar()
	{
		$id_classe = isset($_POST['id_classe']) ? intval($_POST['id_classe']) : '';
		$nome_classe = isset($_POST['nome_classe']) ? filter_var($_POST['nome_classe']) : '';
		$igreja = isset($_POST['igreja']) ? intval($_POST['igreja']) : '';
		$departamento = isset($_POST['departamento']) ? intval($_POST['departamento']) : '';
		$faixa_etaria_min = isset($_POST['faixa_etaria_min']) ? intval($_POST['faixa_etaria_min']) : '';
		$faixa_etaria_max = isset($_POST['faixa_etaria_max']) ? intval($_POST['faixa_etaria_max']) : '';
		$descricao_geral = isset($_POST['descricao_geral']) ? filter_var($_POST['descricao_geral']) : '';

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome da classe', $nome_classe, 'nome_classe')->is_required()->min_length(2);
		$validate->set('Igreja', $igreja, 'igreja')->is_required();
		$validate->set('Departamento', $departamento, 'departamento')->is_required();
		$validate->set('Faixa etária minima', $faixa_etaria_min, 'faixa_etaria_min')->is_required();
		$validate->set('Faixa etária máxima', $faixa_etaria_max, 'faixa_etaria_max')->is_required();
		
		
		if ($validate->validate())
		{
	        $this->loadModel('ebd/classesModel');
			$classes = new classesModel();

			$classes->setId($id_classe);
			$classes->setNomeClasse($nome_classe);
			$classes->setDepartamento($departamento);
			$classes->setFaixaEtariaMin($faixa_etaria_min);
			$classes->setFaixaEtariaMax($faixa_etaria_max);
			$classes->setDescricaoGeral($descricao_geral);
			$classes->setIgreja($igreja);
			$classes->setStatus('Ativo');
			echo $classes->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

	/**
	*Atualiza o status do professor
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

		$this->loadModel('ebd/professoresModel');
		$professores = new professoresModel();
		$professores->setId($id);
		$professores->setStatus($status);
		if($professores->atualizarStatusProfessor())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
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
		$this->loadModel('ebd/professoresModel');
		$membro = new professoresModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatusProfessor())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}
	


	
}

/**
*
*class: professores
*
*location : controllers/ebd/classes/professores.controller.php
*/