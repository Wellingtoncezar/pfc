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
			'titlePage' => 'Usuários',
			'template' => new template()

		);

		$this->load->dao('funcionarios/usuariosDao');
		$usuarios = new usuariosDao();
		$data['usuarios'] = $usuarios->listar();

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuarios/home',$data);
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
		$data = array(
			'titlePage' => 'Cadastrar Usuários',
			'template' => new template()
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuario/cadastro',$data);
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
		$data = array(
			'titlePage' => 'Editar Usuários',
			'template' => new template()
		);
		//ID
		$idFuncionario = intval($this->url->getSegment(3));
		
		//USUARIO MODEL
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId($idUsuario);

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		$data['funcionario'] = $usuariosDao->consultar($usuariosModel);
		
		//DATAFORMAT
		$this->load->library('dataFormat');
		$data['dataFormat'] = $this->dataFormat;

		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/usuarios/editar',$data);
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
		$cargo = isset($_POST['cargo']) ? filter_var(trim($_POST['cargo'])) : '';
		$dataAdmissao = isset($_POST['dataAdmissao']) ? filter_var(trim($_POST['dataAdmissao'])) : '';
		$salario = isset($_POST['salario']) ? filter_var(trim($_POST['salario'])) : '';



		//validação dos dados
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
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
				$emailModel->setTipo( $email['tipo_email'] );
				array_push($emailList, $emailModel);
				unset($emailModel);
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
			$this->load->library('dataFormat');
			$dataNascimento = $this->dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $this->dataFormat->formatar($dataAdmissao,'data','banco');
			$salario = $this->dataFormat->formatar($salario,'decimal','banco');

			

			//FUNCIONARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setFoto($foto);
			$usuariosModel->setNome($nome);
			$usuariosModel->setSobrenome($sobrenome);
			$usuariosModel->setDataNascimento($dataNascimento);
			$usuariosModel->setSexo($sexo);
			$usuariosModel->setRg($rg);
			$usuariosModel->setCpf($cpf);
			$usuariosModel->setEstadoCivil($estadoCivil);
			$usuariosModel->setEscolaridade($escolaridade);
			$usuariosModel->setEndereco($enderecoModel);
			$usuariosModel->setTelefones($telefonesList);
			$usuariosModel->setEmail($emailList);
			$usuariosModel->setCodigo($codigoAdmissao);
			$usuariosModel->setCargo($cargo);
			$usuariosModel->setDataAdmissao($dataAdmissao);
			$usuariosModel->setSalario($salario);
			$usuariosModel->setStatus(status::ATIVO);
			$usuariosModel->setDataCadastro(date('Y-m-d h:i:s'));


			//FUNCIONARIO DAO
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			echo $usuariosDao->inserir($usuariosModel);
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
		$idFuncionario = isset($_POST['id_funcionario']) ? filter_var($_POST['id_funcionario']) : '';
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
		
		$id_endereco = isset($_POST['id_endereco']) ? filter_var(trim($_POST['id_endereco'])) : '';
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
		$cargo = isset($_POST['cargo']) ? filter_var(trim($_POST['cargo'])) : '';
		$dataAdmissao = isset($_POST['dataAdmissao']) ? filter_var(trim($_POST['dataAdmissao'])) : '';
		$salario = isset($_POST['salario']) ? filter_var(trim($_POST['salario'])) : '';



		//validação dos dados
		$this->load->library('dataValidator');
		
		$this->dataValidator->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$this->dataValidator->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$this->dataValidator->set('Data de nascimento', $dataNascimento, 'dataNascimento')->is_required()->is_date('d/m/Y');
		$this->dataValidator->set('Sexo', $sexo, 'sexo')->is_required();
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
			$this->load->library('dataFormat');
			$dataNascimento = $this->dataFormat->formatar($dataNascimento,'data','banco');
			$dataAdmissao = $this->dataFormat->formatar($dataAdmissao,'data','banco');
			$salario = $this->dataFormat->formatar($salario,'decimal','banco');

			

			//FUNCIONARIO
			$this->load->model('funcionarios/usuariosModel');
			$usuariosModel = new usuariosModel();
			$usuariosModel->setId($idFuncionario);
			$usuariosModel->setFoto($foto);
			$usuariosModel->setNome($nome);
			$usuariosModel->setSobrenome($sobrenome);
			$usuariosModel->setDataNascimento($dataNascimento);
			$usuariosModel->setSexo($sexo);
			$usuariosModel->setRg($rg);
			$usuariosModel->setCpf($cpf);
			$usuariosModel->setEstadoCivil($estadoCivil);
			$usuariosModel->setEscolaridade($escolaridade);
			$usuariosModel->setEndereco($enderecoModel);
			$usuariosModel->setTelefones($telefonesList);
			$usuariosModel->setEmail($emailList);
			$usuariosModel->setCodigo($codigoAdmissao);
			$usuariosModel->setCargo($cargo);
			$usuariosModel->setDataAdmissao($dataAdmissao);
			$usuariosModel->setSalario($salario);
			$usuariosModel->setStatus(status::ATIVO);
			$usuariosModel->setDataCadastro(date('Y-m-d h:i:s'));


			//FUNCIONARIO DAO
			$this->load->dao('funcionarios/usuariosDao');
			$usuariosDao = new usuariosDao();
			echo $usuariosDao->atualizar($usuariosModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
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
		$this->load->model('funcionarios/usuariosModel');
		$usuariosModel = new usuariosModel();
		$usuariosModel->setId( $idFuncionario );
		$usuariosModel->setStatus( status::getAttribute($status));

		//FUNCIONARIO DAO
		$this->load->dao('funcionarios/usuariosDao');
		$usuariosDao = new usuariosDao();
		echo $usuariosDao->atualizarStatus($usuariosModel);

	}

	public function excluir()
	{
		$saveRouter = new saveRouter;
		$saveRouter->saveModule();
		$saveRouter->saveAction();
		$this->atualizarStatus();
	}

}