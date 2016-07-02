<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
	}


	/*---------------------------
	- PÁGINAS
	=============================*/


	/**
	 * Página index
	 */
	public function index()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Agenda de fornecedores',
			'template' => new templateFactory()
		);

		
		
		$this->load->view('includes/header',$data);
		$this->load->view('agenda/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Cadastrar agenda'
		);
		

		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedores = new fornecedoresDao();
		$data['fornecedores'] = $fornecedores->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('agenda/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	public function listar()
	{
		$ano = isset($_POST['ano']) ? intval($_POST['ano']) : '2015';
		if($ano !=  0)
		{
			$agendaList = array();

			//AGENDA DAO
			$this->load->dao('fornecedores/agendaDao');
			$agendaDao = new agendaDao();
			$agendas = $agendaDao->listar($ano);

			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			foreach ($agendas as $agenda) 
			{
				$aux = array(
					'date' => $this->formatarData($agenda->getData()),
					'title' => '',
					'link' => '',
					'color' => 'green'
				);
				array_push($agendaList, $aux);
				//unset($aux);
			}

			echo json_encode($agendaList);
		}else
			echo json_encode(array());

		//echo '[{"date":"2\/2\/2015","title":"Getting Contacts Barcelona - test1","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"red"}]';
	}

	



	/*----------------------------
	- AÇÕES
	=============================*/
	public function notificar()
	{
		//AGENDA DAO
		$this->load->dao('fornecedores/agendaDao');
		$agendaDao = new agendaDao();
		$agendamentos = $agendaDao->getDataNotificar();
		$notificacoes = array();


		$this->load->library('dataFormat', null, true);

		if(!empty($agendamentos))
		{
			foreach ($agendamentos as $agenda)
			{
				$aux['data'] = $this->load->dataFormat->formatar($agenda->getData(),'data');
				$aux['titulo'] = $agenda->getTitulo();
				$aux['nome_fornecedor'] = $agenda->getFornecedor()->getNomeFantasia();
				array_push($notificacoes, $aux);
			}
		}
		echo json_encode($notificacoes);
	}




	private function formatarData($data)
	{
		$data = explode('-',$data);
		$dia = ltrim($data[2], "0");
		$mes = ltrim($data[1], "0");
		$ano = ltrim($data[0], "0");

		return $dia.'/'.$mes.'/'.$ano;
	}
	
	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		$fornecedor = isset($_POST['fornecedores']) ? intval($_POST['fornecedores']) : '';
		$data = isset($_POST['data']) ? filter_var(trim($_POST['data'])) : '';
		$titulo = isset($_POST['titulo']) ? filter_var(trim($_POST['titulo'])) : '';
		$observacoes = isset($_POST['observacoes']) ? filter_var(trim($_POST['observacoes'])) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Fornecedor', $fornecedor, 'fornecedores')->is_required();
		$this->load->dataValidator->set('Data', $data, 'data')->is_required();
		$this->load->dataValidator->set('Título', $titulo, 'titulo')->is_required();


		if ($this->load->dataValidator->validate())
		{
			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setId($fornecedor);
			
			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$data = $this->load->dataFormat->formatar($data,'data','banco');

			//AGENDA
			$this->load->model('fornecedores/agendaModel');
			$agendaModel = new agendaModel();
			$agendaModel->setTitulo($titulo);
			$agendaModel->setData($data);
			$agendaModel->setObservacoes($observacoes);
			$agendaModel->setDataCadastro(date('Y-m-d h:i:s'));
			$agendaModel->setFornecedor($fornecedoresModel);


			//AGENDA DAO
			$this->load->dao('fornecedores/agendaDao');
			$agendaDao = new agendaDao();
			echo $agendaDao->inserir($agendaModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}


}