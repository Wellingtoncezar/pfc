<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class alunos extends Controller{
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
			'titulo' => 'Alunos da Escola Bíblica Dominical',
			'method' => __METHOD__
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		//carregamento do model e listagem

		$this->loadModel('ebd/alunosModel');
		$alunos = new alunosModel();
		//$alunos->setClasse($id);
		$alunos = $alunos->listar();
		$data['alunos'] = $alunos;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/alunos/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	public function classe()
	{
		
		$this->saveAction();
		$data = array(
			'titulo' => 'Alunos da Escola Bíblica Dominical',
			'method' => __METHOD__
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		//carregamento do model e listagem

		$this->loadModel('ebd/alunosModel');
		$alunos = new alunosModel();
		$alunos->setClasse($id);
		$alunos = $alunos->listar();
		$data['alunos'] = $alunos;


		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/alunos/alunos',$data);
		$this->loadView('includes/baseBottom',$data);
	}





	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo aluno'
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		$this->loadModel('membros/membrosModel');


		$this->loadModel('ebd/alunosModel');
		$alunos = new alunosModel();
		$alunos->setClasse($id);
		$alunos = $alunos->listar();
		$_aluno = array();

		foreach ($alunos as $aluno){
			array_push($_aluno, array_column($aluno['id_aluno']);
		}

		$_aluno = implode("','", $_aluno);

		$membros = new membrosModel();
		$membros = $membros->listar('=',"Ativo' AND A.id_membro IN('$_aluno')");
		$data['membros'] = $membros;


		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/alunos/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	public function visualizar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo aluno'
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		$this->loadModel('ebd/alunosModel');

		$alunos = new alunosModel();
		$alunos->setId($id);
		$alunos = $alunos->getAluno();
		$data['membro'] = $alunos;

		$this->loadModel('ebd/classesModel');
		$classe = new classesModel();
		$classe->setId($id);
		$classe = $classe->getClasse();
		$data['classe'] = $classe;


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/alunos/visualizar',$data);
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
	        $this->loadModel('ebd/alunosModel');
			$alunos = new alunosModel();
			$alunos->setClasse($id_classe);
			$alunos->setMembro($membro);
			$alunos->setStatus('Ativo');
			echo $alunos->inserir();
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
	*Atualiza o status do aluno
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

		$this->loadModel('ebd/alunosModel');
		$alunos = new alunosModel();
		$alunos->setId($id);
		$alunos->setStatus($status);
		if($alunos->atualizarStatusAluno())
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
		$this->loadModel('ebd/alunosModel');
		$membro = new alunosModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatusAluno())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}
	


	
}

/**
*
*class: alunos
*
*location : controllers/ebd/classes/alunos.controller.php
*/