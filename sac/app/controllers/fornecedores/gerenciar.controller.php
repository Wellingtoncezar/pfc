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

		$data = array(
			'titlePage' => 'Fornecedores',
			'template' => new templateFactory()
		);

		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedores = new fornecedoresDao();
		$data['fornecedores'] = $fornecedores->listar();
		
		$this->load->view('includes/header',$data);
		$this->load->view('fornecedores/home',$data);
		$this->load->view('includes/footer',$data);

	}


	/**
	 * Página de cadastro
	 */
	public function cadastrar()
	{
		$data = array(
			'titlePage' => 'Cadastrar fornecedores',
			'template' => new templateFactory()
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('fornecedores/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}


	/**
	 * Página de edição
	 */
	public function editar()
	{
		$data = array(
			'titlePage' => 'Editar fornecedores',
			'template' => new templateFactory()
		);
		//ID
		$idFornecedor = intval($this->url->getSegment(3));
		
		//FORNECEDORES MODEL
		$this->load->model('fornecedores/fornecedoresModel');
		$fornecedoresModel = new fornecedoresModel();
		$fornecedoresModel->setId($idFornecedor);

		//FORNECEDORES DAO
		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedoresDao = new fornecedoresDao();
		$data['fornecedor'] = $fornecedoresDao->consultar($fornecedoresModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat', null, true);
		$data['dataFormat'] = $this->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('fornecedores/editar',$data);
		$this->load->view('includes/footer',$data);
	}





	/*----------------------------
	- AÇÕES
	=============================*/
	/**
	 * Ação do cadastrar
	 */
	public function inserir()
	{
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$razaoSocial = isset($_POST['razao_social']) ? filter_var($_POST['razao_social']) : '';
		$nomeFantasia = isset($_POST['nome_fantasia']) ? filter_var($_POST['nome_fantasia']) : '';
		$cnpj = isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
		$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		$pessoa = isset($_POST['pessoa']) ? filter_var($_POST['pessoa']) : '';
		$site = isset($_POST['site']) ? filter_var($_POST['site']) : '';
		$observacoes = isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		

		//endereço
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$logradouro = isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
        $complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) :'';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		//contato
		$nomeContato = isset($_POST['nomeContato']) ? filter_var($_POST['nomeContato']) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
		$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();

		$data_visita = isset($_POST['data_visita']) ? filter_var(trim($_POST['data_visita'])) : '';
		$retorno = isset($_POST['retorno']) ? filter_var(trim($_POST['retorno'])) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->dataValidator->set('Razao Social', $razaoSocial, 'razao_social')->is_required()->min_length(2);
		$this->dataValidator->set('Nome Fantasia', $nomeFantasia, 'nome_fantasia')->is_required()->min_length(2);
		$this->dataValidator->set('CNPJ', $cnpj, 'cnpj')->is_required();
		$this->dataValidator->set('CPF', $cpf, 'cpf')->is_required();
		$this->dataValidator->set('Pessoa', $pessoa, 'pessoa')->is_required();
		$this->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->dataValidator->set('Estado', $estado, 'estado')->is_required();

		

		if ($this->dataValidator->validate())
		{
			//TELEFONES
			$telefonesList = Array();
			$this->load->model('telefoneModel');
			foreach ($telefones as $telefone)
			{
				$telefoneModel = new telefoneModel();
				$telefoneModel->setCategoria( $telefone['categoria'] );
				$telefoneModel->setNumero( $telefone['telefone'] );
				$telefoneModel->setOperadora( $telefone['operadora'] );
				$telefoneModel->setTipo( $telefone['tipo_telefone'] );
				array_push($telefonesList, $telefoneModel);
				unset($telefoneModel);
			}


			//EMAILS
			$emailList = Array();
			$this->load->model('emailModel');
			foreach ($emails as $email)
			{
				$emailModel = new emailModel();
				$emailModel->setEmail( $email['email'] );
				array_push($emailList, $emailModel);
				unset($emailModel);
			}



			//ENDEREÇO
			$this->load->model('enderecoModel');
			$enderecoModel = new enderecoModel();
			$enderecoModel->setCep($cep);
			$enderecoModel->setLogradouro($logradouro);
			$enderecoModel->setNumero($numero);
			$enderecoModel->setComplemento($complemento);
			$enderecoModel->setCidade($cidade);
			$enderecoModel->setBairro($bairro);
			$enderecoModel->setEstado($estado);
			

			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$data_visita = $this->dataFormat->formatar($data_visita,'data','banco');


			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setFoto($foto);
			$fornecedoresModel->setRazaoSocial($razaoSocial);
			$fornecedoresModel->setNomeFantasia($nomeFantasia);
			$fornecedoresModel->setCnpj($cnpj);
			$fornecedoresModel->setCpf($cpf);
			$fornecedoresModel->setPessoa($pessoa);
			$fornecedoresModel->setSite($site);
			$fornecedoresModel->setObservacoes($observacoes);
			$fornecedoresModel->setNomeContato($nomeContato);
			$fornecedoresModel->setEndereco($enderecoModel);
			$fornecedoresModel->setTelefones($telefonesList);
			$fornecedoresModel->setEmail($emailList);
			$fornecedoresModel->setDataVisita($data_visita);
			$fornecedoresModel->setRetorno($retorno);
			$fornecedoresModel->setStatus(status::ATIVO);
			$fornecedoresModel->setDataCadastro(date('Y-m-d h:i:s'));
			// //print_r($fornecedoresModel);
			// exit;
			//FORNECEDOR DAO
			$this->load->dao('fornecedores/fornecedoresDao');
			$fornecedoresDao = new fornecedoresDao();
			echo $fornecedoresDao->inserir($fornecedoresModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}



	/**
	 * Ação do editar
	 */
	/**
	 * Ação do cadastrar
	 */
	public function atualizar()
	{
		$idFornecedor = isset($_POST['id_fornecedor']) ? filter_var($_POST['id_fornecedor']) : '';
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$razaoSocial = isset($_POST['razao_social']) ? filter_var($_POST['razao_social']) : '';
		$nomeFantasia = isset($_POST['nome_fantasia']) ? filter_var($_POST['nome_fantasia']) : '';
		$cnpj = isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
		$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		$pessoa = isset($_POST['pessoa']) ? filter_var($_POST['pessoa']) : '';
		$site = isset($_POST['site']) ? filter_var($_POST['site']) : '';
		$observacoes = isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		

		//endereço
		$id_endereco = isset($_POST['id_endereco']) ? filter_var(trim($_POST['id_endereco'])) : '';
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$logradouro = isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
        $complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) :'';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		//contato
		$nomeContato = isset($_POST['nomeContato']) ? filter_var($_POST['nomeContato']) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
		$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();

		$data_visita = isset($_POST['data_visita']) ? filter_var(trim($_POST['data_visita'])) : '';
		$retorno = isset($_POST['retorno']) ? filter_var(trim($_POST['retorno'])) : '';


		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->dataValidator->set('Razao Social', $razaoSocial, 'razao_social')->is_required()->min_length(2);
		$this->dataValidator->set('Nome Fantasia', $nomeFantasia, 'nome_fantasia')->is_required()->min_length(2);
		$this->dataValidator->set('CNPJ', $cnpj, 'cnpj')->is_required()->is_required();
		$this->dataValidator->set('CPF', $cpf, 'cpf')->is_required();
		$this->dataValidator->set('Pessoa', $pessoa, 'pessoa')->is_required();
		$this->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->dataValidator->set('Estado', $estado, 'estado')->is_required();

		

		if ($this->dataValidator->validate())
		{
			//TELEFONES
			$telefonesList = Array();
			$this->load->model('telefoneModel');
			foreach ($telefones as $key => $telefone)
			{
				$telefone['idtelefone'] = isset($telefone['idtelefone']) ? $telefone['idtelefone'] : '';
				$telefoneModel = new telefoneModel();
				$telefoneModel->setId($telefone['idtelefone']);
				$telefoneModel->setCategoria( $telefone['categoria'] );
				$telefoneModel->setNumero( $telefone['telefone'] );
				$telefoneModel->setOperadora( $telefone['operadora'] );
				$telefoneModel->setTipo( $telefone['tipo_telefone'] );
				array_push($telefonesList, $telefoneModel);
				unset($telefoneModel);
			}



			//EMAILS
			$emailList = Array();
			$this->load->model('emailModel');
			foreach ($emails as $email)
			{
				$email['idemail'] = isset($email['idemail']) ? $email['idemail'] : '';
				$emailModel = new emailModel();
				$emailModel->setId( $email['idemail'] );
				$emailModel->setEmail( $email['email'] );
				$emailModel->setTipo( $email['tipo_email'] );
				array_push($emailList, $emailModel);
				unset($emailModel);
			}

			//ENDEREÇO
			$this->load->model('enderecoModel');
			$enderecoModel = new enderecoModel();
			$enderecoModel->setId($id_endereco);
			$enderecoModel->setCep($cep);
			$enderecoModel->setNumero($numero);
			$enderecoModel->setComplemento($complemento);
			$enderecoModel->setLogradouro($logradouro);
			$enderecoModel->setBairro($bairro);
			$enderecoModel->setCidade($cidade);
			$enderecoModel->setEstado($estado);
			


			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$data_visita = $this->dataFormat->formatar($data_visita,'data','banco');


			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setFoto($foto);
			$fornecedoresModel->setRazaoSocial($razaoSocial);
			$fornecedoresModel->setNomeFantasia($nomeFantasia);
			$fornecedoresModel->setCNPJ($cnpj);
			$fornecedoresModel->setCpf($cpf);
			$fornecedoresModel->setPessoa($pessoa);
			$fornecedoresModel->setSite($site);
			$fornecedoresModel->setObservacoes($observacoes);
			$fornecedoresModel->setEndereco($enderecoModel);
			$fornecedoresModel->setTelefones($telefonesList);
			$fornecedoresModel->setEmail($emailList);
			$fornecedoresModel->setStatus(status::ATIVO);
			$fornecedoresModel->setDataCadastro(date('Y-m-d h:i:s'));




			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setId($idFornecedor);
			$fornecedoresModel->setFoto($foto);
			$fornecedoresModel->setRazaoSocial($razaoSocial);
			$fornecedoresModel->setNomeFantasia($nomeFantasia);
			$fornecedoresModel->setCnpj($cnpj);
			$fornecedoresModel->setCpf($cpf);
			$fornecedoresModel->setPessoa($pessoa);
			$fornecedoresModel->setSite($site);
			$fornecedoresModel->setObservacoes($observacoes);
			$fornecedoresModel->setNomeContato($nomeContato);
			$fornecedoresModel->setEndereco($enderecoModel);
			$fornecedoresModel->setTelefones($telefonesList);
			$fornecedoresModel->setEmail($emailList);
			$fornecedoresModel->setDataVisita($data_visita);
			$fornecedoresModel->setRetorno($retorno);



			//FORNECEDOR DAO
			$this->load->dao('fornecedores/fornecedoresDao');
			$fornecedoresDao = new fornecedoresDao();
			echo $fornecedoresDao->atualizar($fornecedoresModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}

     /*
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idFornecedor = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//FUNCIONARIO MODEL
		$this->load->model('fornecedores/fornecedoresModel');
		$fornecedoresModel = new fornecedoresModel();
		$fornecedoresModel->setId( $idFornecedor );
		$fornecedoresModel->setStatus( $status );

		//FUNCIONARIO DAO
		$this->load->dao('fornecedores/fornecedoresDao');
		$fornecedoresDao = new fornecedoresDao();
		echo $fornecedoresDao->atualizarStatus($fornecedoresModel);

	}

	public function excluir()
	{
		$this->atualizarStatus();
	}

}