<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class agenda extends Controller{
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
		$data = array(
			'titlePage' => 'Agenda de fornecedores'
		);

		
		
		$this->load->view('includes/header',$data);
		$this->load->view('fornecedores/agenda/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$data = array(
			'titlePage' => 'Cadastrar agenda'
		);
		

		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedores = new fornecedoresDao();
		$data['fornecedores'] = $fornecedores->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('fornecedores/agenda/cadastro',$data);
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
			$this->load->library('dataFormat');
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


		$this->load->library('dataFormat');

		if(!empty($agendamentos))
		{
			foreach ($agendamentos as $agenda)
			{
				$aux['data'] = $this->dataFormat->formatar($agenda->getData(),'data');
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
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Fornecedor', $fornecedor, 'fornecedores')->is_required();
		$this->dataValidator->set('Data', $data, 'data')->is_required();
		$this->dataValidator->set('Título', $titulo, 'titulo')->is_required();


		if ($this->dataValidator->validate())
		{
			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setId($fornecedor);
			
			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat');
			$data = $this->dataFormat->formatar($data,'data','banco');

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
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}


}