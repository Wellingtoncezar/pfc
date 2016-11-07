<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class gerenciar extends Controller{
	public function __construct(){
		parent::__construct();
		//carregamento das dependências
		$this->load->dao('funcionarios/IListagemFuncionarios');
		$this->load->dao('funcionarios/consultaFuncionarioPorId');
		$this->load->dao('funcionarios/funcionariosDao');
		$this->load->dao('funcionarios/IUsuarios');
		$this->load->dao('funcionarios/consultaPorFuncionario');
		$this->load->dao('funcionarios/cargosDao');
		$this->load->dao('funcionarios/IUsuarios');
		$this->load->dao('funcionarios/consultaUsuarioPorFuncionario');
		$this->load->dao('funcionarios/usuariosDao');
		$this->load->dao('configuracoes/niveisAcessoDao');
		
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('funcionarios/cargosModel');
		$this->load->model('funcionarios/usuariosModel');
		$this->load->model('enderecoModel');
		$this->load->library('uploadFoto');
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
		//checagem de permissão de acesso
		$this->load->checkPermissao->check();
		$data = array(
			'titlePage' => 'Funcionários'
		);

		//listagem dos funcionários
		$funcionarios = new funcionariosDao();
		$listaDeFuncionarios = $funcionarios->listar();

		//foreach para popular os dados de usuários de cada funcionário 
		foreach ($listaDeFuncionarios as $funcionario)
		{
			//USUARIOS DAO -- consultando o usuario pelo funcionário
			$usuariosDao = new usuariosDao;
			$usuariosModel = $usuariosDao->consultar(new consultaUsuarioPorFuncionario($funcionario), new usuariosModel(), array(status::ATIVO, status::INATIVO));
			//setando o usuario em funcionario caso tenha um usuario
			if($usuariosModel != null)
			{
				$modulosDao = new modulosDao();
				$modulosModel = $modulosDao->listar();

				//obtendo os niveis de acesso
				$niveisAcessoDao = new niveisAcessoDao();
				$niveisAcessoModel = $niveisAcessoDao->getNivelAcesso($usuariosModel->getNivelAcesso(), $modulosModel);
				if($niveisAcessoModel != null)
					$usuariosModel->setNivelAcesso($niveisAcessoModel);
				
				$funcionario->setUsuario($usuariosModel);
			}
		}	

		$data['funcionarios'] = $listaDeFuncionarios;

		//carregamento da view
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
		//checagem de permissão de acesso
		$this->load->checkPermissao->check();
		
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

		
		$cargos = new cargosDao;

		$data = array(
			'titlePage' => 'Editar funcionário',
			'cargos' => $cargos->listar()
		);
		//ID
		if($this->load->url->getSegment(3) == false)
			$this->http->redirect(URL.'error404');

		$idFuncionario = intval($this->load->url->getSegment(3));
		
		//FUNCIONARIO MODEL
		$funcionariosModel = new funcionariosModel();
		$funcionariosModel->setId($idFuncionario);

		//FUNCIONARIO DAO -- consultando o funcionario pelo id
		$funcionariosDao = new funcionariosDao();
		$funcionariosModel = $funcionariosDao->consultar(new consultaFuncionarioPorId(), $funcionariosModel, array(status::ATIVO, status::INATIVO));
		
		
		// //USUARIOS DAO -- consultando o usuario pelo funcionário
		// $usuariosDao = new usuariosDao;
		// $usuariosModel = $usuariosDao->consultar(new consultaUsuarioPorFuncionario($funcionariosModel), new usuariosModel(), array(status::ATIVO, status::INATIVO));
		// //setando o usuario em funcionario
		// if($usuariosModel != null)
		// 	$funcionariosModel->setUsuario($usuariosModel);


		$data['funcionario'] = $funcionariosModel;
		$data['dataFormat'] = new dataFormat();


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
		//verificando as permissões de acesso
		if(!$this->load->checkPermissao->check(false,URL.'funcionarios/gerenciar/cadastrar'))
		{
			$this->http->response("Ação não permitida");
			return false;
		}
		//obtendo os dados vindo pela requisição
		$foto 			= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome 			= $this->http->getRequest('nome');
		$sobrenome 		= $this->http->getRequest('sobrenome');
		$dataNascimento = $this->http->getRequest('dataNascimento');
		$sexo 			= $this->http->getRequest('sexo');
		$rg 			= $this->http->getRequest('rg');
		$cpf 			= $this->http->getRequest('cpf');
		$estadoCivil 	= $this->http->getRequest('estadoCivil');
		$escolaridade 	= $this->http->getRequest('escolaridade');

		//endereço
		$cep 			= $this->http->getRequest('cep');
		$logradouro 	= $this->http->getRequest('logradouro');
		$numero 		= $this->http->getRequest('numero');
		$complemento 	= $this->http->getRequest('complemento');
		$bairro 		= $this->http->getRequest('bairro');
		$cidade 		= $this->http->getRequest('cidade');
		$estado 		= $this->http->getRequest('estado');

		//contato
		$telefone 		= $this->http->getRequest('telefone');
		$email 			= $this->http->getRequest('email');
		
		
		//DADOS ADMISSIONAIS
		$codigoAdmissao = $this->http->getRequest('codigoAdmissao');
		$cargo 			= $this->http->getRequest('cargo');
		$dataAdmissao 	= $this->http->getRequest('dataAdmissao');
		$dataDemissao 	= $this->http->getRequest('dataDemissao');



		//validação dos dados
		$dataValidator = new dataValidator();
		$dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
		$dataValidator->set('CPF', $cpf, 'cpf')->is_required()->is_cpf();
		$dataValidator->set('CEP', $cep, 'cep')->is_required();
		$dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$dataValidator->set('Estado', $estado, 'estado')->is_required();
		$dataValidator->set('E-mail', $email, 'email')->is_required()->is_email();
		$dataValidator->set('Cargo', $cargo, 'cargo')->is_required();

		if ($dataValidator->validate())
		{
			//FUNCIONARIO
			$funcionariosModel = new funcionariosModel();

			
			//ENDEREÇO
			$enderecoModel = new enderecoModel();
			$enderecoModel->setCep($cep);
			$enderecoModel->setNumero($numero);
			$enderecoModel->setComplemento($complemento);
			$enderecoModel->setLogradouro($logradouro);
			$enderecoModel->setBairro($bairro);
			$enderecoModel->setCidade($cidade);
			$enderecoModel->setEstado($estado);
			

			//FORMATAÇÃO DOS DADOS
			$dataFormat = new dataFormat();
			$dataNascimento = $dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $dataFormat->formatar($dataAdmissao,'data','banco');
			$dataDemissao = $dataFormat->formatar($dataDemissao,'data','banco');



			
			if(!empty($foto)){
				//obtendo os valores para o corte da imagem
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
				$nome_foto = md5(date('dmYHis'));
				try {
					//realizando o upload da imagem
					$upload = new uploadFoto('funcionarios', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					
					$this->http->response($e->getMessage());
					return false;
				}
			}
			else
				$nome_foto = '';
			
			
			//cargo
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
			$funcionariosModel->setEmail($email);
			$funcionariosModel->setTelefone($telefone);
			$funcionariosModel->setCargo($cargosModel);
			$funcionariosModel->setDataAdmissao($dataAdmissao);
			$funcionariosModel->setDataDemissao($dataDemissao);
			$funcionariosModel->setStatus(status::ATIVO);
			$funcionariosModel->setDataCadastro(date('Y-m-d h:i:s'));


			//FUNCIONARIO DAO
			$funcionariosDao = new funcionariosDao();

			try {
				$res = $funcionariosDao->inserir($funcionariosModel);
				if($res){
					$this->http->response(true);
				}
				else
					$this->http->response($res);
			} catch (dbException $e) 
			{
				//se algo der errado emite a mensagem do erro gerado
				$this->http->response($e->getMessageError());
			}
		}else
	    {
			$this->http->response(json_encode($dataValidator->get_errors()));
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
		$telefone 			= filter_var( $this->http->getRequest('telefone'));
		$email 				= filter_var($this->http->getRequest('email'));


		//DADOS ADMISSIONAIS
		$codigoAdmissao 	= filter_var($this->http->getRequest('codigoAdmissao'));
		$cargo 				= filter_var($this->http->getRequest('cargo'));
		$dataAdmissao 		= filter_var($this->http->getRequest('dataAdmissao'));
		$dataDemissao 		= filter_var($this->http->getRequest('dataDemissao'));



		//validação dos dados
		$dataValidator = new dataValidator();
		$dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
		$dataValidator->set('CEP', $cep, 'cep')->is_required();
		$dataValidator->set('CPF', $cpf, 'cpf')->is_required()->is_cpf();
		$dataValidator->set('Logradouro', $logradouro, 'logradouro')->is_required();
		$dataValidator->set('Número', $numero, 'numero')->is_required()->is_num();
		$dataValidator->set('Bairro', $bairro, 'bairro')->is_required();
		$dataValidator->set('Cidade', $cidade, 'cidade')->is_required();
		$dataValidator->set('Estado', $estado, 'estado')->is_required();
		$dataValidator->set('E-mail', $email, 'email')->is_required()->is_email();
		$dataValidator->set('Cargo', $cargo, 'cargo')->is_required();
		

		if ($dataValidator->validate())
		{
			//FUNCIONARIO
			$funcionariosModel = new funcionariosModel();

			//ENDEREÇO
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
			$dataFormat = new dataFormat();
			$dataNascimento = $dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $dataFormat->formatar($dataAdmissao,'data','banco');
			$dataDemissao = $dataFormat->formatar($dataDemissao,'data','banco');

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
			$funcionariosModel->setEmail($email);
			$funcionariosModel->setTelefone($telefone);

			
			$cargosModel = new cargosModel();
			$cargosModel->setId($cargo);
			$funcionariosModel->setCargo($cargosModel);
			$funcionariosModel->setDataAdmissao($dataAdmissao);
			$funcionariosModel->setDataDemissao($dataDemissao);


			//FUNCIONARIO DAO
			$funcionariosDao = new funcionariosDao();
			try {
				$this->http->response($funcionariosDao->atualizar($funcionariosModel));
			} catch (dbException $e) {
				$this->http->response($e->getMessageError());
				exit;
			}
		}else
	    {
			$todos_erros = $dataValidator->get_errors();
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
		$funcionariosModel = new funcionariosModel();
		$funcionariosModel->setId( $idFuncionario );
		if(status::getAttribute($status) == status::EXCLUIDO)
			$funcionariosModel->excluir();
		else
		if(status::getAttribute($status) == status::INATIVO)
			$funcionariosModel->inativar();
		else
			$funcionariosModel->ativar();

		//USUARIOS DAO -- consultando o usuario pelo funcionário
		$usuariosDao = new usuariosDao;
		$usuariosModel = $usuariosDao->consultar(new consultaUsuarioPorFuncionario($funcionariosModel), new usuariosModel(), array(status::ATIVO, status::INATIVO));
		//setando o usuario em funcionario caso tenha um usuario
		if($usuariosModel != null)
		{
			$modulosDao = new modulosDao();
			$modulosModel = $modulosDao->listar();

			//obtendo os niveis de acesso
			$niveisAcessoDao = new niveisAcessoDao();
			$niveisAcessoModel = $niveisAcessoDao->getNivelAcesso($usuariosModel->getNivelAcesso(), $modulosModel);
			if($niveisAcessoModel != null)
				$usuariosModel->setNivelAcesso($niveisAcessoModel);
			
			$funcionariosModel->setUsuario($usuariosModel);
		}


		//FUNCIONARIO DAO -- verificando se é permitido realizar ação ao funcionario
		$funcionariosDao = new funcionariosDao();
		if($funcionariosModel->getUsuario() == null || $funcionariosModel->getUsuario()->getNivelAcesso()->getTipoPermissao() == tipopermissao::USUARIO)
			$this->http->response($funcionariosDao->atualizarStatus($funcionariosModel));
		else
			$this->http->response("Alteração de status ou exclusão de funcionário administrador não é permitida");
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