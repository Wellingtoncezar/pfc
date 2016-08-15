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
	 * Página inicial
	 */
	public function index()
	{	
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Funcionários'
		);

		$this->load->dao('funcionarios/funcionariosDao');
		$this->load->dao('funcionarios/IListagemFuncionarios');
		
		

		$funcionarios = new funcionariosDao();
		$data['funcionarios'] = $funcionarios->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/home',$data);
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
		$this->load->dao('funcionarios/cargosDao');
		$cargos = new cargosDao;


		$data = array(
			'titlePage' => 'Cadastrar funcionário',
			'cargos' => $cargos->listar()
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
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

		$this->load->dao('funcionarios/cargosDao');
		$cargos = new cargosDao;

		$data = array(
			'titlePage' => 'Editar funcionário',
			'cargos' => $cargos->listar()
		);
		//ID
		$idFuncionario = intval($this->load->url->getSegment(3));
		
		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/funcionariosModel');
		$funcionariosModel = new funcionariosModel();
		$funcionariosModel->setId($idFuncionario);

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/funcionariosDao');
		$funcionariosDao = new funcionariosDao();
		$data['funcionario'] = $funcionariosDao->consultar($funcionariosModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat',null,true);
		$data['dataFormat'] = $this->load->dataFormat;


		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/editar',$data);
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

		if(!$this->load->checkPermissao->check(false,URL.'funcionarios/gerenciar/cadastrar'))
		{
			$this->http->response("Ação não permitida");
			return false;
		}

		$foto 			= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome 			= filter_var($this->http->getRequest('nome'));
		$sobrenome 		= filter_var($this->http->getRequest('sobrenome'));
		$dataNascimento = filter_var($this->http->getRequest('dataNascimento'));
		$sexo 			= filter_var($this->http->getRequest('sexo'));
		$rg 			= filter_var($this->http->getRequest('rg'));
		$cpf 			= filter_var($this->http->getRequest('cpf'));
		$estadoCivil 	= filter_var($this->http->getRequest('estadoCivil'));
		$escolaridade 	= filter_var($this->http->getRequest('escolaridade'));

		//endereço
		$cep 			= filter_var($this->http->getRequest('cep'));
		$logradouro 	= filter_var($this->http->getRequest('logradouro'));
		$numero 		= filter_var($this->http->getRequest('numero'));
		$complemento 	= filter_var($this->http->getRequest('complemento'));
		$bairro 		= filter_var($this->http->getRequest('bairro'));
		$cidade 		= filter_var($this->http->getRequest('cidade'));
		$estado 		= filter_var($this->http->getRequest('estado'));

		//contato
		$telefones 		= filter_var_array( (array) $this->http->getRequest('telefones'));
		$emails 		= filter_var_array( (array) $this->http->getRequest('emails'));
		
		
		//DADOS ADMISSIONAIS
		$codigoAdmissao = filter_var($this->http->getRequest('codigoAdmissao'));
		$cargo 			= filter_var($this->http->getRequest('cargo'));
		$dataAdmissao 	= filter_var($this->http->getRequest('dataAdmissao'));
		$dataDemissao 	= filter_var($this->http->getRequest('dataDemissao'));



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->load->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
		$this->load->dataValidator->set('CPF', $cpf, 'cpf')->is_required()->is_cpf();
		$this->load->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->load->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->load->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->load->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->load->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->load->dataValidator->set('Estado', $estado, 'estado')->is_required();
		$this->load->dataValidator->set('Cargo', $cargo, 'cargo')->is_required();
		

		if ($this->load->dataValidator->validate())
		{
			//FUNCIONARIO
			$this->load->model('funcionarios/funcionariosModel');
			$funcionariosModel = new funcionariosModel();

			//TELEFONES
			
			$this->load->model('telefoneModel');
			//TELEFONES
			foreach ($telefones as $key => $telefone)
			{
				$telefoneModel = new telefoneModel();
				$telefoneModel->setCategoria( $telefone['categoria'] );
				$telefoneModel->setNumero( $telefone['telefone'] );
				$telefoneModel->setOperadora( $telefone['operadora'] );
				$telefoneModel->setTipo( $telefone['tipo_telefone'] );
				$funcionariosModel->addTelefone($telefoneModel);
			}


			//EMAILS
			foreach ($emails as $email)
			{
				$emailModel = new emailModel();
				$emailModel->setEmail( $email['email'] );
				$emailModel->setTipo( $email['tipo_email'] );
				$funcionariosModel->addEmail($emailModel);
			}



			//ENDEREÇO
			$this->load->model('enderecoModel');
			$enderecoModel = new enderecoModel();
			$enderecoModel->setCep($cep);
			$enderecoModel->setNumero($numero);
			$enderecoModel->setComplemento($complemento);
			$enderecoModel->setLogradouro($logradouro);
			$enderecoModel->setBairro($bairro);
			$enderecoModel->setCidade($cidade);
			$enderecoModel->setEstado($estado);
			

			//FORMATAÇÃO DOS DADOS
			$this->load->library('dataFormat',null, true);
			$dataNascimento = $this->load->dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $this->load->dataFormat->formatar($dataAdmissao,'data','banco');
			$dataDemissao = $this->load->dataFormat->formatar($dataDemissao,'data','banco');

			$cropValues = Array(
				'w' => $this->http->getRequest('w'),
				'h' => $this->http->getRequest('h'),
				'x1' => $this->http->getRequest('x1'),
				'y1' => $this->http->getRequest('y1')
			);
			$tamanho = Array(
				'p' =>array(
						'w' => 404,
						'h' =>  158
					)
			);

			
			if(!empty($foto)){
				$nome_foto = md5(date('dmYHis'));
				try {
					$this->load->library('uploadFoto');
					$upload = new uploadFoto('funcionarios', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					
					$this->http->response($e->getMessage());
					return false;
				}
			}
			else
				$nome_foto = '';
			
			$this->load->model('funcionarios/cargosModel');

			$cargosModel = new cargosModel();
			$cargosModel->setId($cargo);

			$funcionariosModel->setFoto($nome_foto);
			$funcionariosModel->setNome($nome);
			$funcionariosModel->setSobrenome($sobrenome);
			$funcionariosModel->setDataNascimento($dataNascimento);
			$funcionariosModel->setSexo($sexo);
			$funcionariosModel->setRg($rg);
			$funcionariosModel->setCpf($cpf);
			$funcionariosModel->setEstadoCivil($estadoCivil);
			$funcionariosModel->setEscolaridade($escolaridade);
			$funcionariosModel->setEndereco($enderecoModel);
			
			
			$funcionariosModel->setCargo($cargosModel);
			$funcionariosModel->setDataAdmissao($dataAdmissao);
			$funcionariosModel->setDataDemissao($dataDemissao);
			$funcionariosModel->setStatus(status::ATIVO);
			$funcionariosModel->setDataCadastro(date('Y-m-d h:i:s'));


			//FUNCIONARIO DAO
			$this->load->dao('funcionarios/funcionariosDao');
			$funcionariosDao = new funcionariosDao();

			try {
				$res = $funcionariosDao->inserir($funcionariosModel);
				if($res){
					$this->http->response(true);
				}
				else
					$this->http->response($res);
			} catch (dbException $e) {
				$this->http->response($e->getMessageError());
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }

	}



	/**
	 * Ação do atualizar
	 */
	public function atualizar()
	{
		if(!$this->load->checkPermissao->check(false, URL.'funcionarios/gerenciar/editar'))
		{
			$this->http->response("Ação não permitida");
			return false;
		}

		$idFuncionario 		= filter_var((int)$this->http->getRequest('id_funcionario'));
		$foto 				= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome_foto 			= filter_var($this->http->getRequest('nome_foto'));
		$nome 				= filter_var($this->http->getRequest('nome'));
		$sobrenome 			= filter_var($this->http->getRequest('sobrenome'));
		$dataNascimento 	= filter_var($this->http->getRequest('dataNascimento'));
		$sexo 				= filter_var($this->http->getRequest('sexo'));
		$rg 				= filter_var($this->http->getRequest('rg'));
		$cpf 				= filter_var($this->http->getRequest('cpf'));
		$estadoCivil 		= filter_var($this->http->getRequest('estadoCivil'));
		$escolaridade 		= filter_var($this->http->getRequest('escolaridade'));

		//endereço
		$id_endereco 		= filter_var((int)$this->http->getRequest('id_endereco'));
		$cep 				= filter_var($this->http->getRequest('cep'));
		$logradouro 		= filter_var($this->http->getRequest('logradouro'));
		$numero 			= filter_var($this->http->getRequest('numero'));
		$complemento 		= filter_var($this->http->getRequest('complemento'));
		$bairro 			= filter_var($this->http->getRequest('bairro'));
		$cidade 			= filter_var($this->http->getRequest('cidade'));
		$estado 			= filter_var($this->http->getRequest('estado'));

		//contato
		$telefones 		= filter_var_array( (array) $this->http->getRequest('telefones'));
		$emails 		= filter_var_array( (array) $this->http->getRequest('emails'));


		//DADOS ADMISSIONAIS
		$codigoAdmissao 	= filter_var($this->http->getRequest('codigoAdmissao'));
		$cargo 				= filter_var($this->http->getRequest('cargo'));
		$dataAdmissao 		= filter_var($this->http->getRequest('dataAdmissao'));
		$dataDemissao 		= filter_var($this->http->getRequest('dataDemissao'));



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->load->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
		$this->load->dataValidator->set('CEP', $cep, 'cep')->is_required();
		$this->load->dataValidator->set('CPF', $cpf, 'cpf')->is_required()->is_cpf();
		$this->load->dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$this->load->dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$this->load->dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$this->load->dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$this->load->dataValidator->set('Estado', $estado, 'estado')->is_required();
		$this->load->dataValidator->set('Cargo', $cargo, 'cargo')->is_required();
		

		if ($this->load->dataValidator->validate())
		{
			$this->load->model('funcionarios/funcionariosModel');
			$this->load->model('emailModel');
			$this->load->model('telefoneModel');
			$this->load->model('funcionarios/cargosModel');


			//FUNCIONARIO
			$funcionariosModel = new funcionariosModel();

			//TELEFONES
			foreach ($telefones as $key => $telefone)
			{
				$telefone['idtelefone'] = isset($telefone['idtelefone']) ? $telefone['idtelefone'] : '';
				$telefoneModel = new telefoneModel();
				$telefoneModel->setId($telefone['idtelefone']);
				$telefoneModel->setCategoria( $telefone['categoria'] );
				$telefoneModel->setNumero( $telefone['telefone'] );
				$telefoneModel->setOperadora( $telefone['operadora'] );
				$telefoneModel->setTipo( $telefone['tipo_telefone'] );
				$funcionariosModel->addTelefone($telefoneModel);
			}


			//EMAILS
			foreach ($emails as $email)
			{
				$email['idemail'] = isset($email['idemail']) ? $email['idemail'] : '';
				$emailModel = new emailModel();
				$emailModel->setId( $email['idemail'] );
				$emailModel->setEmail( $email['email'] );
				$emailModel->setTipo( $email['tipo_email'] );
				$funcionariosModel->addEmail($emailModel);
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
			$this->load->library('dataFormat', null,true);
			$dataNascimento = $this->load->dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $this->load->dataFormat->formatar($dataAdmissao,'data','banco');
			$dataDemissao = $this->load->dataFormat->formatar($dataDemissao,'data','banco');

			if(!empty($foto))
			{
				$cropValues = Array(
					'w' => $this->http->getRequest('w'),
					'h' => $this->http->getRequest('h'),
					'x1' => $this->http->getRequest('x1'),
					'y1' => $this->http->getRequest('y1')
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
					$upload = new uploadFoto('funcionarios', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					$this->http->response($e->getMessage());
					return false;
				}
			}
			

			$funcionariosModel->setId($idFuncionario);
			$funcionariosModel->setFoto($nome_foto);
			$funcionariosModel->setNome($nome);
			$funcionariosModel->setSobrenome($sobrenome);
			$funcionariosModel->setDataNascimento($dataNascimento);
			$funcionariosModel->setSexo($sexo);
			$funcionariosModel->setRg($rg);
			$funcionariosModel->setCpf($cpf);
			$funcionariosModel->setEstadoCivil($estadoCivil);
			$funcionariosModel->setEscolaridade($escolaridade);
			$funcionariosModel->setEndereco($enderecoModel);
			$funcionariosModel->setCodigo($codigoAdmissao);

			$cargosModel = new cargosModel();
			$cargosModel->setId($cargo);
			$funcionariosModel->setCargo($cargosModel);
			$funcionariosModel->setDataAdmissao($dataAdmissao);
			$funcionariosModel->setDataDemissao($dataDemissao);


			//FUNCIONARIO DAO
			$this->load->dao('funcionarios/funcionariosDao');
			$funcionariosDao = new funcionariosDao();
			try {
				$this->http->response($funcionariosDao->atualizar($funcionariosModel));
			} catch (dbException $e) {
				$this->http->response($e->getMessageError());
				exit;
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			$this->http->response(json_encode($todos_erros));
	    }

	}


	/**
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idFuncionario = (int) $this->http->getRequest('id');
		$status = filter_var($this->http->getRequest('status'));

		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/funcionariosModel');
		$funcionariosModel = new funcionariosModel();
		$funcionariosModel->setId( $idFuncionario );
		if(status::getAttribute($status) == status::EXCLUIDO)
			$funcionariosModel->excluir();
		else
		if(status::getAttribute($status) == status::INATIVO)
			$funcionariosModel->inativar();
		else
			$funcionariosModel->ativar();

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/funcionariosDao');
		$funcionariosDao = new funcionariosDao();
		if(!$funcionariosDao->isFuncionarioAdministrador($funcionariosModel))
			$this->http->response($funcionariosDao->atualizarStatus($funcionariosModel));
		else
			$this->http->response("Alteração de status ou exclusão de funcionário administrador não permitida");
	}


	/**
	 * Ãção de exclusão
	 */
	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		if(!$this->load->checkPermissao->check(false,URL.'funcionarios/gerenciar/excluir'))
		{
			$this->http->response("Ação não permitida");
			return false;
		}
		$this->atualizarStatus();
	}

}