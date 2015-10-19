<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/*---------------------------
	- PÁGINAS
	=============================*/


	/**
	*Página index
	*/
	public function index()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Funcionários'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/home',$data);
		$this->load->view('includes/footer',$data);
	}


	public function cadastrar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Cadastrar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Editar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}






	/*---------------------------
	- AÇÕES
	=============================*/

	public function inserir()
	{
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$sobrenome = isset($_POST['sobrenome']) ? filter_var($_POST['sobrenome']) : '';
		$dataNascimento = isset($_POST['dataNascimento']) ? filter_var(trim($_POST['dataNascimento'])) : '';

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$validate->set('Data de nascimento', $dataNascimento, 'data_nascimento')->is_required()->is_date('d/m/Y');

		
		if ($validate->validate())
		{

			// $this->load->dao('funcionarios/funcionariosDao');
			// echo $this->funcionariosDao->inserir('algas asdf dsfads dfaso');
		}else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }

	}

}