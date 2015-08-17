<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class home extends Controller{
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
			'titulo' => 'Classes da Escola Bíblica Dominical',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('ebd/classesModel');
		$classes = new classesModel();
		$classes = $classes->listar();
		$data['classes'] = $classes;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}
	
	
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar nova classe'
		);

		$this->loadModel('ebd/departamentosModel');
		$departamentos = new departamentosModel();
		$data['departamentos'] = $departamentos->listar('=','Ativo');

		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$data['igreja'] = $igreja->listar('=','Ativo');

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar classe'
		);

		$url = new url();
		$id = intval($url->getSegment(4));
		$this->loadModel('ebd/classesModel');
		$classes = new classesModel();
		$classes->setId($id);
		$classes = $classes->getClasse();
		$data['classe'] = $classes;

		$this->loadModel('ebd/departamentosModel');
		$departamentos = new departamentosModel();
		$data['departamentos'] = $departamentos->listar('=','Ativo');

		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$data['igreja'] = $igreja->listar('=','Ativo');

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/editar',$data);
		$this->loadView('includes/baseBottom',$data);
	}


	public function chamadas()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar classe'
		);

		$url = new url();
		$id = intval($url->getSegment(4));//id da classe
		//carregamento do model e listagem
		$data['id_classe'] = $id;

		$this->loadModel('ebd/alunosModel');
		$alunos = new alunosModel();
		$alunos->setClasse($id);
		$alunos = $alunos->listar();
		$data['alunos'] = $alunos;

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('ebd/classes/chamadas',$data);
		$this->loadView('includes/baseBottom',$data);
	}












	/**
	* Insere presença dos alunos
	*/
	public function inserirChamada()
	{
		$classe = isset($_POST['classe']) ? filter_var($_POST['classe']) : '';
		$data_aula = isset($_POST['data_aula']) ? filter_var($_POST['data_aula']) : '';
		$hora_aula = isset($_POST['hora_aula']) ? filter_var($_POST['hora_aula']) : '';
		$alunosPresentes = isset($_POST['presente']) ? filter_var_array($_POST['presente']) : '';

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Data', $data_aula, 'data_aula')->is_required()->is_date('d/m/Y');
		$validate->set('Hora', $hora_aula, 'hora_aula')->is_required();
		
		
		if ($validate->validate())
		{
	        $this->loadModel('ebd/aulaModel');
			$classes = new aulaModel();
			$classes->setClasse($classe);
			$classes->setDataAula($data_aula);
			$classes->setHoraAula($hora_aula);

			$classes->setAlunosPresentes($alunosPresentes);
			echo $classes->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}



	public function getChamadas()
	{
		$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
		$parametros = isset($_POST['parameters']) ? $_POST['parameters'] : array();
		//$classe = $parametros['classe'];
		
		$this->loadModel('ebd/aulaModel');
		$classes = new aulaModel();
		echo $classes->getAulas();
	}

	public function data_chamada()
	{
		$url = new url();
		echo $url->getSegment(4);
	}




	/***CLASSE EBD***/

	/**
	* Insere uma classe da EBD
	*/

	public function inserir()
	{
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
			$classes->setNomeClasse($nome_classe);
			$classes->setDepartamento($departamento);
			$classes->setFaixaEtariaMin($faixa_etaria_min);
			$classes->setFaixaEtariaMax($faixa_etaria_max);
			$classes->setDescricaoGeral($descricao_geral);
			$classes->setIgreja($igreja);
			$classes->setStatus('Ativo');
			echo $classes->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

	/*
	* Atualiza a classe
	*/
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
			$resp = $classes->atualizar();

			if($resp != false)
				echo $resp;
			else
				echo json_encode(array('erro' => 'Registro não atualizado'));	
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

	/**
	*Atualiza o status da classe
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

		$this->loadModel('ebd/classesModel');
		$membro = new classesModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}



	/**
	*Exclusão apena para envia-lo à lixeira - classe
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

		$this->loadModel('ebd/classesModel');
		$membro = new classesModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}
		
}

/**
*
*class: home
*
*location : controllers/ebd/classes/home.controller.php
*/