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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		
		$data = array(
			'titlePage' => 'Editar fornecedores',
			'template' => new templateFactory()
		);
		//ID
		if($this->load->url->getSegment(3) == false)
			$this->http->redirect(URL.'error404');
		$idFornecedor = intval($this->load->url->getSegment(3));
		
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
		$data['dataFormat'] = $this->load->dataFormat;

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
		if(!$this->load->checkPermissao->check(false,URL.'fornecedores/gerenciar/cadastrar'))
		{
			$this->http->response('Ação não permitida');
		}
		
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
		
		$this->load->dataValidator->set('Razao Social', $razaoSocial, 'razao_social')->is_required()->min_length(2);
		$this->load->dataValidator->set('Nome Fantasia', $nomeFantasia, 'nome_fantasia')->is_required()->min_length(2);
		$this->load->dataValidator->set('CNPJ', $cnpj, 'cnpj')->is_required();
		$this->load->dataValidator->set('CPF', $cpf, 'cpf')->is_required();
		$this->load->dataValidator->set('Pessoa', $pessoa, 'pessoa')->is_required();
		$this->load->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->load->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->load->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->load->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->load->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->load->dataValidator->set('Estado', $estado, 'estado')->is_required();

		

		if ($this->load->dataValidator->validate())
		{
			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();


			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat', null, true);
			$data_visita = $this->load->dataFormat->formatar($data_visita,'data','banco');

			$cropValues = Array(
				'w' => $_POST['w'],
				'h' => $_POST['h'],
				'x1' => $_POST['x1'],
				'y1' => $_POST['y1']
			);
			$tamanho = Array(
				'p' =>array(
						'w' => 404,
						'h' =>  158
					)
			);
			if(!empty($foto))
				$nome_foto = md5(date('dmYHis'));
			$nome_foto = '';
			try {
				$this->load->library('uploadFoto');
				$upload = new uploadFoto('fornecedores', $foto, $nome_foto, $tamanho, $cropValues);
				$nome_foto = $upload->getNomeArquivo();
			} catch (Exception $e) {
				echo $e->getMessage();
				return false;
			}
			
			$fornecedoresModel->setFoto($nome_foto);
			$fornecedoresModel->setRazaoSocial($razaoSocial);
			$fornecedoresModel->setNomeFantasia($nomeFantasia);
			$fornecedoresModel->setCnpj($cnpj);
			$fornecedoresModel->setCpf($cpf);
			$fornecedoresModel->setPessoa($pessoa);
			$fornecedoresModel->setSite($site);
			$fornecedoresModel->setObservacoes($observacoes);
			$fornecedoresModel->setNomeContato($nomeContato);
			
			$fornecedoresModel->setDataVisita($data_visita);
			$fornecedoresModel->setRetorno($retorno);
			$fornecedoresModel->setStatus(status::ATIVO);
			$fornecedoresModel->setDataCadastro(date('Y-m-d h:i:s'));

			//TELEFONES
			$this->load->model('telefoneModel');
			foreach ($telefones as $telefone)
			{
				$telefoneModel = new telefoneModel();
				$telefoneModel->setCategoria( $telefone['categoria'] );
				$telefoneModel->setNumero( $telefone['telefone'] );
				$telefoneModel->setOperadora( $telefone['operadora'] );
				$telefoneModel->setTipo( $telefone['tipo_telefone'] );
				$fornecedoresModel->addTelefone($telefoneModel);
				
			}


			//EMAILS
			$this->load->model('emailModel');
			foreach ($emails as $email)
			{
				$emailModel = new emailModel();
				$emailModel->setEmail( $email['email'] );
				$fornecedoresModel->addEmail($emailModel);
			}

			//endereço
			$this->load->model('enderecoModel');
			$enderecoModel = new enderecoModel();
			$enderecoModel->setCep($cep);
			$enderecoModel->setLogradouro($logradouro);
			$enderecoModel->setNumero($numero);
			$enderecoModel->setComplemento($complemento);
			$enderecoModel->setCidade($cidade);
			$enderecoModel->setBairro($bairro);
			$enderecoModel->setEstado($estado);
			$fornecedoresModel->setEndereco($enderecoModel);
			//FORNECEDOR DAO
			$this->load->dao('fornecedores/fornecedoresDao');
			$fornecedoresDao = new fornecedoresDao();
			echo $fornecedoresDao->inserir($fornecedoresModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
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
		$idFornecedor 			= isset($_POST['id_fornecedor']) ? filter_var($_POST['id_fornecedor']) : '';
		$foto 					= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome_foto 				= isset($_POST['nome_foto']) ? $_POST['nome_foto'] : '';
		$razaoSocial 			= isset($_POST['razao_social']) ? filter_var($_POST['razao_social']) : '';
		$nomeFantasia 			= isset($_POST['nome_fantasia']) ? filter_var($_POST['nome_fantasia']) : '';
		$cnpj 					= isset($_POST['cnpj']) ? filter_var(trim($_POST['cnpj'])) : '';
		$cpf 					= isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		$pessoa 				= isset($_POST['pessoa']) ? filter_var($_POST['pessoa']) : '';
		$site 					= isset($_POST['site']) ? filter_var($_POST['site']) : '';
		$observacoes 			= isset($_POST['observacoes']) ? filter_var($_POST['observacoes']) : '';
		

		//endereço
		$id_endereco 			= isset($_POST['id_endereco']) ? filter_var(trim($_POST['id_endereco'])) : '';
		$cep 					= isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$logradouro 			= isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
		$numero 				= isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
        $complemento 			= isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) :'';
		$cidade 				= isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$bairro 				= isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$estado 				= isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		//contato
		$nomeContato 			= isset($_POST['nomeContato']) ? filter_var($_POST['nomeContato']) : '';
		$telefones 				= isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
		$emails 				= isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();

		
		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Razao Social', $razaoSocial, 'razao_social')->is_required()->min_length(2);
		$this->load->dataValidator->set('Nome Fantasia', $nomeFantasia, 'nome_fantasia')->is_required()->min_length(2);
		$this->load->dataValidator->set('CNPJ', $cnpj, 'cnpj')->is_required()->is_required()->is_cnpj();
		$this->load->dataValidator->set('CPF', $cpf, 'cpf')->is_required()->is_cpf();
		$this->load->dataValidator->set('Pessoa', $pessoa, 'pessoa')->is_required();
		$this->load->dataValidator->set_message('is_required',"Informe pelo menos um e-mail");
		$this->load->dataValidator->set('E-mail', $emails, 'emails')->is_required();
		
		$this->load->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->load->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->load->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->load->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->load->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->load->dataValidator->set('Estado', $estado, 'estado')->is_required();

		

		if ($this->load->dataValidator->validate())
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

			if(!empty($foto))
			{
				$cropValues = Array(
					'w' => $_POST['w'],
					'h' => $_POST['h'],
					'x1' => $_POST['x1'],
					'y1' => $_POST['y1']
				);
				$tamanho = Array(
					'p' =>array(
							'w' => 404,
							'h' =>  158
						)
				);

				if($nome_foto == '')
					$nome_foto = md5(date('dmYHis'));

				try {
					$this->load->library('uploadFoto');
					$upload = new uploadFoto('fornecedores', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					echo $e->getMessage();
					return false;
				}
			}

			//FORNECEDOR
			$this->load->model('fornecedores/fornecedoresModel');
			$fornecedoresModel = new fornecedoresModel();
			$fornecedoresModel->setId($idFornecedor);
			$fornecedoresModel->setFoto($nome_foto);
			$fornecedoresModel->setRazaoSocial($razaoSocial);
			$fornecedoresModel->setNomeFantasia($nomeFantasia);
			$fornecedoresModel->setCNPJ($cnpj);
			$fornecedoresModel->setCpf($cpf);
			$fornecedoresModel->setPessoa($pessoa);
			$fornecedoresModel->setSite($site);
			$fornecedoresModel->setObservacoes($observacoes);
			$fornecedoresModel->setNomeContato($nomeContato);
			$fornecedoresModel->setEndereco($enderecoModel);
			$fornecedoresModel->setTelefones($telefonesList);
			$fornecedoresModel->setEmails($emailList);
			$fornecedoresModel->setDataCadastro(date('Y-m-d h:i:s'));




			//FORNECEDOR DAO
			$this->load->dao('fornecedores/fornecedoresDao');
			$fornecedoresDao = new fornecedoresDao();
			echo $fornecedoresDao->atualizar($fornecedoresModel);
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
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
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		if(!$this->load->checkPermissao->check(false,URL.'fornecedores/gerenciar/excluir'))
		{
			echo "Ação não permitida";
			return false;
		}
		$this->load->checkPermissao->check();
		$this->atualizarStatus();
	}

}