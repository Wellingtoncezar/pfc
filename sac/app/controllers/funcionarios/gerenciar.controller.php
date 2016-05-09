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
			'titlePage' => 'Funcionários'
		);

		$this->load->dao('funcionarios/funcionariosDao');
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
			echo "Ação não permitida";
			return false;
		}

		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$sobrenome = isset($_POST['sobrenome']) ? filter_var($_POST['sobrenome']) : '';
		$dataNascimento = isset($_POST['dataNascimento']) ? filter_var(trim($_POST['dataNascimento'])) : '';
		$sexo = isset($_POST['sexo']) ? filter_var($_POST['sexo']) : '';
		$rg = isset($_POST['rg']) ? filter_var($_POST['rg']) : '';
		$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		$estadoCivil = isset($_POST['estadoCivil']) ? filter_var($_POST['estadoCivil']) : '';
		$escolaridade = isset($_POST['escolaridade']) ? filter_var($_POST['escolaridade']) : '';

		//endereço
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$logradouro = isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';

		//contato
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
		$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();
		
		//DADOS ADMISSIONAIS
		$codigoAdmissao = isset($_POST['codigoAdmissao']) ? filter_var(trim($_POST['codigoAdmissao'])) : '';
		$cargo = isset($_POST['cargo']) ? intval($_POST['cargo']) : '';
		$dataAdmissao = isset($_POST['dataAdmissao']) ? filter_var(trim($_POST['dataAdmissao'])) : '';
		$dataDemissao = isset($_POST['dataDemissao']) ? filter_var(trim($_POST['dataDemissao'])) : '';



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->load->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
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
				$funcionariosModel->setTelefones($telefoneModel);
			}


			//EMAILS
			foreach ($emails as $email)
			{
				$emailModel = new emailModel();
				$emailModel->setEmail( $email['email'] );
				$emailModel->setTipo( $email['tipo_email'] );
				$funcionariosModel->setEmail($emailModel);
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

			
			if(!empty($foto)){
				$nome_foto = md5(date('dmYHis'));
				try {
					$this->load->library('uploadFoto');
					$upload = new uploadFoto('funcionarios', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					
					echo $e->getMessage();
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
				if($res)
					echo true;
				else
					echo $res;
			} catch (Exception $e) {
				echo $e->getMessage();
				$upload->resetUpload();
				exit;
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}



	/**
	 * Ação do cadastrar
	 */
	public function atualizar()
	{
		if(!$this->load->checkPermissao->check(false, URL.'funcionarios/gerenciar/editar'))
		{
			echo "Ação não permitida";
			return false;
		}

		$idFuncionario 		= isset($_POST['id_funcionario']) ? filter_var($_POST['id_funcionario']) : '';
		$foto 				= isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome_foto 			= isset($_POST['nome_foto']) ? $_POST['nome_foto'] : '';
		$nome 				= isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$sobrenome 			= isset($_POST['sobrenome']) ? filter_var($_POST['sobrenome']) : '';
		$dataNascimento 	= isset($_POST['dataNascimento']) ? filter_var(trim($_POST['dataNascimento'])) : '';
		$sexo 				= isset($_POST['sexo']) ? filter_var($_POST['sexo']) : '';
		$rg 				= isset($_POST['rg']) ? filter_var($_POST['rg']) : '';
		$cpf 				= isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		$estadoCivil 		= isset($_POST['estadoCivil']) ? filter_var($_POST['estadoCivil']) : '';
		$escolaridade 		= isset($_POST['escolaridade']) ? filter_var($_POST['escolaridade']) : '';

		//endereço
		
		$id_endereco 		= isset($_POST['id_endereco']) ? filter_var(trim($_POST['id_endereco'])) : '';
		$cep 				= isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$logradouro 		= isset($_POST['logradouro']) ? filter_var(trim($_POST['logradouro'])) : '';
		$numero 			= isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento 		= isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro 			= isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade 			= isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado 			= isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';

		//contato
		$telefones 			= isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : Array();
		$emails 			= isset($_POST['emails']) ? filter_var_array($_POST['emails']) : Array();
		
		//DADOS ADMISSIONAIS
		$codigoAdmissao 	= isset($_POST['codigoAdmissao']) ? filter_var(trim($_POST['codigoAdmissao'])) : '';
		$cargo 				= isset($_POST['cargo']) ? intval($_POST['cargo']) : '';
		$dataAdmissao 		= isset($_POST['dataAdmissao']) ? filter_var(trim($_POST['dataAdmissao'])) : '';
		$dataDemissao 		= isset($_POST['dataDemissao']) ? filter_var(trim($_POST['dataDemissao'])) : '';



		//validação dos dados
		$this->load->library('dataValidator', null, true);
		
		$this->load->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->load->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->load->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
		$this->load->dataValidator->set('CEP', $cep, 'cep')->is_required();
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
				$funcionariosModel->setTelefones($telefoneModel);
			}


			//EMAILS
			foreach ($emails as $email)
			{
				$email['idemail'] = isset($email['idemail']) ? $email['idemail'] : '';
				$emailModel = new emailModel();
				$emailModel->setId( $email['idemail'] );
				$emailModel->setEmail( $email['email'] );
				$emailModel->setTipo( $email['tipo_email'] );
				$funcionariosModel->setEmail($emailModel);
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
					$upload = new uploadFoto('funcionarios', $foto, $nome_foto, $tamanho, $cropValues);
					$nome_foto = $upload->getNomeArquivo();
				} catch (Exception $e) {
					echo $e->getMessage();
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
				echo $funcionariosDao->atualizar($funcionariosModel);
			} catch (Exception $e) {
				echo $e->getMessage();
				exit;
			}
		}else
	    {
			$todos_erros = $this->load->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}


	/**
	 * Ãção de atualizar status
	 */
	public function atualizarStatus()
	{
		$idFuncionario = intval($_POST['id']);
		$status = filter_var($_POST['status']);

		//FUNCIONARIO MODEL
		$this->load->model('funcionarios/funcionariosModel');
		$funcionariosModel = new funcionariosModel();
		$funcionariosModel->setId( $idFuncionario );
		$funcionariosModel->setStatus( status::getAttribute($status));

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/funcionariosDao');
		$funcionariosDao = new funcionariosDao();
		echo $funcionariosDao->atualizarStatus($funcionariosModel);

	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();

		if(!$this->load->checkPermissao->check(false,URL.'funcionarios/gerenciar/excluir'))
		{
			echo "Ação não permitida";
			return false;
		}
		$this->atualizarStatus();
	}

}