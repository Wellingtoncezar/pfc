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
			'titulo' => 'Igrejas',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja = $igreja->listar();
		$data['igrejas'] = $igreja;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('igreja/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	*Página cadastrar
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar nova igreja'
		);

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('igreja/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	*Página editar
	*/
	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar Igreja'
		);

		$url = new url();
		$id = intval($url->getSegment(3));
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja->setId($id);
		$data['igreja'] = $igreja->getIgreja();
		$data['telefones'] = $igreja->getTelefonesIgreja();



		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('igreja/editar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Cadastro de um novo registro
	*/
	public function inserir()
	{
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$rua = isset($_POST['rua']) ? filter_var(trim($_POST['rua'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : array();
		


		$data_fundacao = isset($_POST['data_fundacao']) ? filter_var(trim($_POST['data_fundacao'])) : '';
		$tipo_igreja = isset($_POST['tipo_igreja']) ? filter_var(trim($_POST['tipo_igreja'])) : '';
		$cnpj = isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
		$pastor = isset($_POST['pastor']) ? filter_var(trim($_POST['pastor'])) : '';

		
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Data de fundação', $data_fundacao, 'data_fundacao')->is_required()->is_date('d/m/Y');
		$validate->set('CNPJ', $cnpj, 'cnpj')->is_required();
		$validate->set('Pastor', $pastor, 'pastor')->is_required()->min_length(2);

		if ($validate->validate())
		{
	        $this->loadModel('igreja/igrejaModel');
			$igreja = new igrejaModel();

			$igreja->setNome($nome);
			$igreja->setCep($cep);
			$igreja->setRua($rua);
			$igreja->setNumero($numero);
			$igreja->setComplemento($complemento);
			$igreja->setBairro($bairro);
			$igreja->setCidade($cidade);
			$igreja->setEstado($estado);
			$igreja->setTelefones($telefones);


			$igreja->setData_fundacao($data_fundacao);
			$igreja->setTipo_igreja($tipo_igreja);
			$igreja->setCnpj($cnpj);
			$igreja->setPastor($pastor);

			echo $igreja->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}

	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		$id = isset($_POST['id']) ? filter_var($_POST['id']) : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$rua = isset($_POST['rua']) ? filter_var(trim($_POST['rua'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : array();

		$listTelExcluir = isset($_POST['listTelExcluir']) ? filter_var_array($_POST['listTelExcluir']) : array();
		


		$data_fundacao = isset($_POST['data_fundacao']) ? filter_var(trim($_POST['data_fundacao'])) : '';
		$tipo_igreja = isset($_POST['tipo_igreja']) ? filter_var(trim($_POST['tipo_igreja'])) : '';
		$cnpj = isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
		$pastor = isset($_POST['pastor']) ? filter_var(trim($_POST['pastor'])) : '';

		
		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Data de fundação', $data_fundacao, 'data_fundacao')->is_required()->is_date('d/m/Y');
		$validate->set('CNPJ', $cnpj, 'cnpj')->is_required();
		$validate->set('Pastor', $pastor, 'pastor')->is_required()->min_length(2);

		if ($validate->validate())
		{
	        $this->loadModel('igreja/igrejaModel');
			$igreja = new igrejaModel();

			$igreja->setNome($nome);
			$igreja->setCep($cep);
			$igreja->setRua($rua);
			$igreja->setNumero($numero);
			$igreja->setComplemento($complemento);
			$igreja->setBairro($bairro);
			$igreja->setCidade($cidade);
			$igreja->setEstado($estado);
			$igreja->setTelefones($telefones);
			$igreja->setListTelefonesExcluir($listTelExcluir);

			$igreja->setData_fundacao($data_fundacao);
			$igreja->setTipo_igreja($tipo_igreja);
			$igreja->setCnpj($cnpj);
			$igreja->setPastor($pastor);

			$igreja->setId($id);
			echo $igreja->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
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

		$this->loadModel('igreja/igrejaModel');
		$membro = new igrejaModel();
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
*location : controllers/igreja/home.controller.php
*/