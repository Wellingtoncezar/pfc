<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
	public function __construct(){
		parent::__construct();

	}


	/*---------------------------
	- PÁGINAS
	=============================*/


	/**
	*Página index
	*/
	public function index()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Funcionários'
			
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/home',$data);
		$this->load->view('includes/footer',$data);

	}


	public function cadastrar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Cadastrar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}

	public function editar()
	{
		//$this->saveAction();

		$data = array(
			'titlePage' => 'Editar funcionário'
		);
		
		$this->load->view('includes/header',$data);
		$this->load->view('funcionarios/cadastro',$data);
		$this->load->view('includes/footer',$data);
	}






	/*----------------------------
	- AÇÕES
	=============================*/

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
			$this->load->model('funcionarios/funcionariosModel');
			$funcionariosModel = new funcionariosModel();
			$funcionariosModel->setFoto($foto);
			$funcionariosModel->setNome($nome);
			$funcionariosModel->setSobrenome($sobrenome);
			$funcionariosModel->setDataNascimento($dataNascimento);
			$funcionariosModel->setSexo($sexo);
			$funcionariosModel->setRg($rg);
			$funcionariosModel->setCpf($cpf);
			$funcionariosModel->setEstadoCivil($estadoCivil);
			$funcionariosModel->setEscolaridade($escolaridade);
			$funcionariosModel->setEndereco($enderecoModel);
			$funcionariosModel->setTelefones($telefonesList);
			$funcionariosModel->setEmail($emailList);
			$funcionariosModel->setCodigo($codigoAdmissao);
			$funcionariosModel->setCargo($cargo);
			$funcionariosModel->setDataAdmissao($dataAdmissao);
			$funcionariosModel->setSalario($salario);
			$funcionariosModel->setStatus(status::ATIVO);
			$funcionariosModel->setDataCadastro(date('Y-m-d h:i:s'));


			//FUNCIONARIO DAO
			$this->load->dao('funcionarios/funcionariosDao');
			$funcionariosDao = new funcionariosDao();
			echo $funcionariosDao->inserir($funcionariosModel);
		}else
	    {
			$todos_erros = $this->dataValidator->get_errors();
			echo json_encode($todos_erros);
	    }

	}

}