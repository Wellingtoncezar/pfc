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
		$ano = isset($_POST['ano']) ? intval($_POST['ano']) : 0;
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
					'date' => $this->dataFormat->formatar($agenda->getData(),'data'),
					'link' => '',
					'color' => 'green'
				);
				array_push($agendaList, $aux);
				unset($aux);
			}

			echo json_encode($agendaList);
		}else
			echo json_encode(array());

//		echo '[{"date":"27\/2\/2015","title":"Getting Contacts Barcelona - test1","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"red"}]';
	}

	// /**
	//  * Página de edição
	//  */
	// public function editar()
	// {
	// 	$data = array(
	// 		'titlePage' => 'Editar fornecedores'
	// 	);
	// 	//ID
	// 	$idFornecedor = intval($this->url->getSegment(3));
		
	// 	//FORNECEDORES MODEL
	// 	$this->load->model('fornecedores/fornecedoresModel');
	// 	$fornecedoresModel = new fornecedoresModel();
	// 	$fornecedoresModel->setId($idFornecedor);

	// 	//FORNECEDORES DAO
	// 	$this->load->dao('fornecedores/fornecedoresDao');
	// 	$fornecedoresDao = new fornecedoresDao();
	// 	$data['fornecedor'] = $fornecedoresDao->consultar($fornecedoresModel);
		
	// 	//DATAFORMAT
	// 	$this->load->library('dataFormat');
	// 	$data['dataFormat'] = $this->dataFormat;

	// 	$this->load->view('includes/header',$data);
	// 	$this->load->view('fornecedores/editar',$data);
	// 	$this->load->view('includes/footer',$data);
	// }





	/*----------------------------
	- AÇÕES
	=============================*/
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



	// /**
	//  * Ação do editar
	//  */
	// /**
	//  * Ação do cadastrar
	//  */
	// public function atualizar()
	// {
	// 	$idFornecedor = isset($_POST['id_fornecedor']) ? filter_var($_POST['id_fornecedor']) : '';
	// 	$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
	// 	$razaoSocial = isset($_POST['razao_social']) ? filter_var($_POST['razao_social']) : '';
	// 	$nomeFantasia = isset($_POST['nome_fantasia']) ? filter_var($_POST['nome_fantasia']) : '';
	// 	$cnpj = isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
	// 	$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
	// 	$pessoa = isset($_POST['pessoa']) ? filter_var($_POST['pessoa']) : '';
	// 	$site = isset($_POST['site']) ? filter_var($_POST['site']) : '';
	// 	$observacoes = isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		

	// 	//endereço
	// 	$id_endereco = isset($_POST['id_endereco']) ? filter_var(trim($_POST['id_endereco'])) : '';
	// 	$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
	// 	$logradouro = isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
	// 	$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
 //        $complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) :'';
	// 	$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
	// 	$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
	// 	$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
	// 	//contato
	// 	$nomeContato = isset($_POST['nomeContato']) ? filter_var($_POST['nomeContato']) : '';
	// 	$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
	// 	$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();

	// 	$data_visita = isset($_POST['data_visita']) ? filter_var(trim($_POST['data_visita'])) : '';
	// 	$retorno = isset($_POST['retorno']) ? filter_var(trim($_POST['retorno'])) : '';


	// 	//validação dos dados
	// 	$this->load->library('dataValidator');
		
	// 	$this->dataValidator->set('Razao Social', $razaoSocial, 'razao_social')->is_required()->min_length(2);
	// 	$this->dataValidator->set('Nome Fantasia', $nomeFantasia, 'nome_fantasia')->is_required()->min_length(2);
	// 	$this->dataValidator->set('CNPJ', $cnpj, 'cnpj')->is_required()->is_required();
	// 	$this->dataValidator->set('CPF', $cpf, 'cpf')->is_required();
	// 	$this->dataValidator->set('Pessoa', $pessoa, 'pessoa')->is_required();
	// 	$this->dataValidator->set('CEP', $cep, 'cep')->is_required();
	// 	$this->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
	// 	$this->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
	// 	$this->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
	// 	$this->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
	// 	$this->dataValidator->set('Estado', $estado, 'estado')->is_required();

		

	// 	if ($this->dataValidator->validate())
	// 	{
	// 		//TELEFONES
	// 		$telefonesList = Array();
	// 		$this->load->model('telefoneModel');
	// 		foreach ($telefones as $key => $telefone)
	// 		{
	// 			$telefone['idtelefone'] = isset($telefone['idtelefone']) ? $telefone['idtelefone'] : '';
	// 			$telefoneModel = new telefoneModel();
	// 			$telefoneModel->setId($telefone['idtelefone']);
	// 			$telefoneModel->setCategoria( $telefone['categoria'] );
	// 			$telefoneModel->setNumero( $telefone['telefone'] );
	// 			$telefoneModel->setOperadora( $telefone['operadora'] );
	// 			$telefoneModel->setTipo( $telefone['tipo_telefone'] );
	// 			array_push($telefonesList, $telefoneModel);
	// 			unset($telefoneModel);
	// 		}



	// 		//EMAILS
	// 		$emailList = Array();
	// 		$this->load->model('emailModel');
	// 		foreach ($emails as $email)
	// 		{
	// 			$email['idemail'] = isset($email['idemail']) ? $email['idemail'] : '';
	// 			$emailModel = new emailModel();
	// 			$emailModel->setId( $email['idemail'] );
	// 			$emailModel->setEmail( $email['email'] );
	// 			$emailModel->setTipo( $email['tipo_email'] );
	// 			array_push($emailList, $emailModel);
	// 			unset($emailModel);
	// 		}

	// 		//ENDEREÇO
	// 		$this->load->model('enderecoModel');
	// 		$enderecoModel = new enderecoModel();
	// 		$enderecoModel->setId($id_endereco);
	// 		$enderecoModel->setCep($cep);
	// 		$enderecoModel->setNumero($numero);
	// 		$enderecoModel->setComplemento($complemento);
	// 		$enderecoModel->setLogradouro($logradouro);
	// 		$enderecoModel->setBairro($bairro);
	// 		$enderecoModel->setCidade($cidade);
	// 		$enderecoModel->setEstado($estado);
			


	// 		//FORMATAÇÃO DOS DADOS
	// 		$this->load->library('dataFormat');
	// 		$data_visita = $this->dataFormat->formatar($data_visita,'data','banco');


	// 		//FORNECEDOR
	// 		$this->load->model('fornecedores/fornecedoresModel');
	// 		$fornecedoresModel = new fornecedoresModel();
	// 		$fornecedoresModel->setFoto($foto);
	// 		$fornecedoresModel->setRazaoSocial($razaoSocial);
	// 		$fornecedoresModel->setNomeFantasia($nomeFantasia);
	// 		$fornecedoresModel->setCNPJ($cnpj);
	// 		$fornecedoresModel->setCpf($cpf);
	// 		$fornecedoresModel->setPessoa($pessoa);
	// 		$fornecedoresModel->setSite($site);
	// 		$fornecedoresModel->setObservacoes($observacoes);
	// 		$fornecedoresModel->setEndereco($enderecoModel);
	// 		$fornecedoresModel->setTelefones($telefonesList);
	// 		$fornecedoresModel->setEmail($emailList);
	// 		$fornecedoresModel->setStatus(status::ATIVO);
	// 		$fornecedoresModel->setDataCadastro(date('Y-m-d h:i:s'));




	// 		//FORNECEDOR
	// 		$this->load->model('fornecedores/fornecedoresModel');
	// 		$fornecedoresModel = new fornecedoresModel();
	// 		$fornecedoresModel->setId($idFornecedor);
	// 		$fornecedoresModel->setFoto($foto);
	// 		$fornecedoresModel->setRazaoSocial($razaoSocial);
	// 		$fornecedoresModel->setNomeFantasia($nomeFantasia);
	// 		$fornecedoresModel->setCnpj($cnpj);
	// 		$fornecedoresModel->setCpf($cpf);
	// 		$fornecedoresModel->setPessoa($pessoa);
	// 		$fornecedoresModel->setSite($site);
	// 		$fornecedoresModel->setObservacoes($observacoes);
	// 		$fornecedoresModel->setNomeContato($nomeContato);
	// 		$fornecedoresModel->setEndereco($enderecoModel);
	// 		$fornecedoresModel->setTelefones($telefonesList);
	// 		$fornecedoresModel->setEmail($emailList);
	// 		$fornecedoresModel->setDataVisita($data_visita);
	// 		$fornecedoresModel->setRetorno($retorno);



	// 		//FORNECEDOR DAO
	// 		$this->load->dao('fornecedores/fornecedoresDao');
	// 		$fornecedoresDao = new fornecedoresDao();
	// 		echo $fornecedoresDao->atualizar($fornecedoresModel);
	// 	}else
	//     {
	// 		$todos_erros = $this->dataValidator->get_errors();
	// 		echo json_encode($todos_erros);
	//     }

	// }

 //     /*
	//  * Ãção de atualizar status
	//  */
	// public function atualizarStatus()
	// {
	// 	$idFornecedor = intval($_POST['id']);
	// 	$status = filter_var($_POST['status']);

	// 	//FUNCIONARIO MODEL
	// 	$this->load->model('fornecedores/fornecedoresModel');
	// 	$fornecedoresModel = new fornecedoresModel();
	// 	$fornecedoresModel->setId( $idFornecedor );
	// 	$fornecedoresModel->setStatus( $status );

	// 	//FUNCIONARIO DAO
	// 	$this->load->dao('fornecedores/fornecedoresDao');
	// 	$fornecedoresDao = new fornecedoresDao();
	// 	echo $fornecedoresDao->atualizarStatus($fornecedoresModel);

	// }

	// public function excluir()
	// {
	// 	$this->atualizarStatus();
	// }

}