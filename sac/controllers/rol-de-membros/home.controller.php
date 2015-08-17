<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class home extends Controller{
	private $error = array();
	private $countError = 0;

	public function __construct(){
		parent::__construct();
		$checkPermissao = new checkPermissao();
		$checkPermissao->checkPermissaoPagina();
		//checagem do login
		$login = new loginModel();
		$login->statusLogin();
	}

	/********************************************/
	/****PÁGINAS****/

	/**
	*Página index
	*/
	public function index()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Usuários do sistema',
			'method' => __METHOD__
		);
		//carregamento do model e listagem
		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$membros = $membros->listar();
		$data['membros'] = $membros;
		

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/home',$data);
		$this->loadView('includes/baseBottom',$data);
	}

	/**
	* Página de cadastro
	*/
	public function cadastrar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Cadastrar novo membro'
		);

		//estado civil
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadocivil = new estadocivilModel();
		$estadocivil = $estadocivil->listar('Ativo');
		$data['estadocivil'] = $estadocivil;
		//tipo de telefone
		$this->loadModel('configuracoes/tabelas/tipoTelefoneModel');
		$tipoTelefone = new tipoTelefoneModel();
		$tipoTelefone = $tipoTelefone->listar('Ativo');
		$data['tipoTelefone'] = $tipoTelefone;

		//tipo de email
		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipoEmail = $tipoEmail->listar('Ativo');
		$data['tipoEmail'] = $tipoEmail;

		//igreja
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja = $igreja->listar('=','Ativo');
		$data['igreja'] = $igreja;


		//tipo de recebimento
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimento = new tipoRecebimentoModel();
		$tipoRecebimento = $tipoRecebimento->listar("status_tipo_recebimento = 'Ativo'");
		$data['tipoRecebimento'] = $tipoRecebimento;



		//tipo de membro
		$this->loadModel('configuracoes/tabelas/tipoMembroModel');
		$tipoMembro = new tipoMembroModel();
		$tipoMembro = $tipoMembro->listar("status_tipo_membro = 'Ativo'");
		$data['tipoMembro'] = $tipoMembro;


		//tipo de ofício da igreja
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja = $tipoOficioIgreja->listar("status_tipo_oficio_igreja = 'Ativo'");
		$data['tipoOficioIgreja'] = $tipoOficioIgreja;


		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();


		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/cadastrar',$data);
		$this->loadView('includes/baseBottom',$data);
	}




	/**
	* Página de edição
	*/
	public function editar()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Editar membro'
		);
		//estado civil
		$this->loadModel('configuracoes/tabelas/estadoCivilModel');
		$estadocivil = new estadocivilModel();
		$estadocivil = $estadocivil->listar('Ativo');
		$data['estadocivil'] = $estadocivil;

		//tipo de telefone
		$this->loadModel('configuracoes/tabelas/tipoTelefoneModel');
		$tipoTelefone = new tipoTelefoneModel();
		$tipoTelefone = $tipoTelefone->listar('Ativo');
		$data['tipoTelefone'] = $tipoTelefone;

		//tipo de email
		$this->loadModel('configuracoes/tabelas/tipoEmailModel');
		$tipoEmail = new tipoEmailModel();
		$tipoEmail = $tipoEmail->listar('Ativo');
		$data['tipoEmail'] = $tipoEmail;

		//igreja
		$this->loadModel('igreja/igrejaModel');
		$igreja = new igrejaModel();
		$igreja = $igreja->listar('=','Ativo');
		$data['igreja'] = $igreja;


		//tipo de recebimento
		$this->loadModel('configuracoes/tabelas/tipoRecebimentoModel');
		$tipoRecebimento = new tipoRecebimentoModel();
		$tipoRecebimento = $tipoRecebimento->listar("status_tipo_recebimento = 'Ativo'");
		$data['tipoRecebimento'] = $tipoRecebimento;



		//tipo de membro
		$this->loadModel('configuracoes/tabelas/tipoMembroModel');
		$tipoMembro = new tipoMembroModel();
		$tipoMembro = $tipoMembro->listar("status_tipo_membro = 'Ativo'");
		$data['tipoMembro'] = $tipoMembro;


		//tipo de ofício da igreja
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$tipoOficioIgreja = $tipoOficioIgreja->listar("status_tipo_oficio_igreja = 'Ativo'");
		$data['tipoOficioIgreja'] = $tipoOficioIgreja;


		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membros'] = $membros->listar();


		$url = new url();
		$id = intval($url->getSegment(3));
		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membro'] = $membros->getMembro($id);
		$data['genealogia'] = $membros->getGenealogia($id);
		$data['endereco'] = $membros->getEndereco($id);
		$data['statusOficioIgreja'] = $membros->getStatusOficioIgreja($data['membro']['id_tipo_oficio_igreja']);
		$data['telefones'] = $membros->getTelefonesList($id);
		$data['emailsList'] = $membros->getEmailsList($id);
		$data['redesSociaisList'] = $membros->getRedesSociaisList($id);

		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/editar',$data);
		$this->loadView('includes/baseBottom',$data);
	}



	/**
	* Página das genealogias
	*/
	public function genealogia()
	{
		$this->saveAction();
		$data = array(
			'titulo' => 'Árvore geneológica'
		);

		$url = new url();
		$id = intval($url->getSegment(3));
		$this->loadModel('membros/membrosModel');
		$membros = new membrosModel();
		$data['membro'] = $membros->getMembro($id);



		//carregamento da tela
		$this->loadView('includes/baseTop',$data);
		$this->loadView('rol-de-membros/genealogia',$data);
		$this->loadView('includes/baseBottom',$data);
	}






	/********************************************/
	/****FUNÇÕES DE ALTERAÇÕES DE REGISTROS****/

	/**
	* Cadastro de um novo registro
	*/
	public function inserir()
	{
		//dados pessoais
		$file = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$sobrenome = isset($_POST['sobrenome']) ? filter_var($_POST['sobrenome']) : '';
		$data_nascimento = isset($_POST['data_nascimento']) ? filter_var(trim($_POST['data_nascimento'])) : '';
		$sexo = isset($_POST['sexo']) ? filter_var($_POST['sexo']) : '';
		$filiacao = isset($_POST['filiacao']) ? filter_var($_POST['filiacao']) : '';
		$naturalidade = isset($_POST['naturalidade']) ? filter_var($_POST['naturalidade']) : '';
		$nacionalidade = isset($_POST['nacionalidade']) ? filter_var($_POST['nacionalidade']) : '';
		$tipoDoc = isset($_POST['tipoDoc']) ? filter_var($_POST['tipoDoc']) : '';
		$rg = isset($_POST['rg']) ? filter_var($_POST['rg']) : '';
		$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		
		//dados familiares
		$estado_civil = isset($_POST['estado_civil']) ? intval($_POST['estado_civil']) : '';
		$nome_conjuge = isset($_POST['nome_conjuge']) ? filter_var($_POST['nome_conjuge']) : '';
		$id_conjuge = isset($_POST['id_conjuge']) ? filter_var($_POST['id_conjuge']) : '';
		$data_casamento = isset($_POST['data_casamento']) ? filter_var($_POST['data_casamento']) : '';
		$pai = isset($_POST['pai']) ? filter_var($_POST['pai']) : '';
		$mae = isset($_POST['mae']) ? filter_var($_POST['mae']) : '';

		//dados de contato
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$rua = isset($_POST['rua']) ? filter_var(trim($_POST['rua'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : array();
		$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : array();
		$redes = isset($_POST['redes']) ? filter_var_array($_POST['redes']) : array();

		//vida profissional
		$profissao = isset($_POST['profissao']) ? filter_var(trim($_POST['profissao'])) : '';
		$aptidoesArtisticas = isset($_POST['aptidoesArtisticas']) ? filter_var(trim($_POST['aptidoesArtisticas'])) : '';
		$docencia = isset($_POST['docencia']) ? filter_var(trim($_POST['docencia'])) : '';
		$outras_informacoes = isset($_POST['outras_informacoes']) ? filter_var(trim($_POST['outras_informacoes'])) : '';



		//Dados Eclesiásticos
		$igreja = isset($_POST['igreja']) ? filter_var(trim($_POST['igreja'])) : '';
		$numero_rol = isset($_POST['numero_rol']) ? filter_var(trim($_POST['numero_rol'])) : '';
		$data_recebimento = isset($_POST['data_recebimento']) ? filter_var(trim($_POST['data_recebimento'])) : '';
		$data_batismo = isset($_POST['data_batismo']) ? filter_var(trim($_POST['data_batismo'])) : '';
		$data_profissao_fe = isset($_POST['data_profissao_fe']) ? filter_var(trim($_POST['data_profissao_fe'])) : '';
		$celebrante = isset($_POST['celebrante']) ? filter_var(trim($_POST['celebrante'])) : '';
		$local_batismo = isset($_POST['local_batismo']) ? filter_var(trim($_POST['local_batismo'])) : '';
		$tipo_recebimento = isset($_POST['tipo_recebimento']) ? filter_var(trim($_POST['tipo_recebimento'])) : '';
		$tipo_membro = isset($_POST['tipo_membro']) ? filter_var(trim($_POST['tipo_membro'])) : '';


		//Vida Eclesiásticas
		$oficial_igreja = isset($_POST['oficial_igreja']) ? filter_var(trim($_POST['oficial_igreja'])) : '';
		$tipoOficioIgreja = isset($_POST['tipoOficioIgreja']) ? filter_var(trim($_POST['tipoOficioIgreja'])) : '';
		$statusTipoOficioIgreja = isset($_POST['statusTipoOficioIgreja']) ? filter_var(trim($_POST['statusTipoOficioIgreja'])) : '';
		$dizimista = isset($_POST['dizimista']) ? filter_var(trim($_POST['dizimista'])) : '';
		$num_dizimista = isset($_POST['num_dizimista']) ? filter_var(trim($_POST['num_dizimista'])) : '';






		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$validate->set('Data de nascimento', $data_nascimento, 'data_nascimento')->is_required()->is_date('d/m/Y');
		$validate->set('Sexo', $sexo, 'sexo')->is_required();
		
		if ($validate->validate())
		{
	        $this->loadModel('membros/membrosModel');
			$membros = new membrosModel();

			$membros->setFoto($file);
			$membros->setNome($nome);
			$membros->setSobrenome($sobrenome);
			$membros->setDataNascimento($data_nascimento);
			$membros->setSexo($sexo);
			$membros->setFiliacao($filiacao);
			$membros->setNaturalidade($naturalidade);
			$membros->setNacionalidade($nacionalidade);
			$membros->setTipoDoc($tipoDoc);
			$membros->setRg($rg);
			$membros->setCpf($cpf);

			$membros->setEstadoCivil($estado_civil);
			$membros->setNomeConjuge($nome_conjuge);
			$membros->setIdConjuge($id_conjuge);
			$membros->setDataCasamento($data_casamento);
			$membros->setPai($pai);
			$membros->setMae($mae);

			$membros->setCep($cep);
			$membros->setRua($rua);
			$membros->setNumero($numero);
			$membros->setComplemento($complemento);
			$membros->setBairro($bairro);
			$membros->setCidade($cidade);
			$membros->setEstado($estado);
			$membros->setTelefones($telefones);
			$membros->setEmails($emails);
			$membros->setRedes($redes);

			$membros->setProfissao($profissao);
			$membros->setAptidoesArtisticas($aptidoesArtisticas);
			$membros->setDocencia($docencia);
			$membros->setOutras_informacoes($outras_informacoes);

			$membros->setIgreja($igreja);
			$membros->setNumeroRol($numero_rol);
			$membros->setDataRecebimento($data_recebimento);
			$membros->setDataBatismo($data_batismo);
			$membros->setDataProfissaoFe($data_profissao_fe);
			$membros->setCelebrante($celebrante);
			$membros->setLocalBatismo($local_batismo);
			$membros->setTipoRecebimento($tipo_recebimento);
			$membros->setTipoMembro($tipo_membro);

			$membros->setOficial_igreja($oficial_igreja);
			$membros->setTipoOficioIgreja($tipoOficioIgreja);
			$membros->setStatusTipoOficioIgreja($statusTipoOficioIgreja);
			$membros->setDizimista($dizimista);
			$membros->setNum_dizimista($num_dizimista);
			$membros->setStatus('Ativo');

			echo $membros->inserir();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}


	/**
	* Atualização de um registro
	*/
	public function atualizar()
	{
		//dados pessoais
		
		$id_membro = isset($_POST['id_membro']) ? intval($_POST['id_membro']) : '';

		$nomefoto = isset($_POST['nomefoto']) ? filter_var($_POST['nomefoto']) : '';
		$file = isset($_FILES['foto']) ? $_FILES['foto'] : '';
		$nome = isset($_POST['nome']) ? filter_var($_POST['nome']) : '';
		$sobrenome = isset($_POST['sobrenome']) ? filter_var($_POST['sobrenome']) : '';
		$data_nascimento = isset($_POST['data_nascimento']) ? filter_var(trim($_POST['data_nascimento'])) : '';
		$sexo = isset($_POST['sexo']) ? filter_var($_POST['sexo']) : '';
		$filiacao = isset($_POST['filiacao']) ? filter_var($_POST['filiacao']) : '';
		$naturalidade = isset($_POST['naturalidade']) ? filter_var($_POST['naturalidade']) : '';
		$nacionalidade = isset($_POST['nacionalidade']) ? filter_var($_POST['nacionalidade']) : '';
		$tipoDoc = isset($_POST['tipoDoc']) ? filter_var($_POST['tipoDoc']) : '';
		$rg = isset($_POST['rg']) ? filter_var($_POST['rg']) : '';
		$cpf = isset($_POST['cpf']) ? filter_var($_POST['cpf']) : '';
		
		//dados familiares
		$estado_civil = isset($_POST['estado_civil']) ? intval($_POST['estado_civil']) : '';
		$nome_conjuge = isset($_POST['nome_conjuge']) ? filter_var($_POST['nome_conjuge']) : '';
		$id_conjuge = isset($_POST['id_conjuge']) ? filter_var($_POST['id_conjuge']) : '';
		$data_casamento = isset($_POST['data_casamento']) ? filter_var($_POST['data_casamento']) : '';
		$pai = isset($_POST['pai']) ? filter_var($_POST['pai']) : '';
		$mae = isset($_POST['mae']) ? filter_var($_POST['mae']) : '';

		//dados de contato
		$cep = isset($_POST['cep']) ? filter_var(trim($_POST['cep'])) : '';
		$rua = isset($_POST['rua']) ? filter_var(trim($_POST['rua'])) : '';
		$numero = isset($_POST['numero']) ? filter_var(trim($_POST['numero'])) : '';
		$complemento = isset($_POST['complemento']) ? filter_var(trim($_POST['complemento'])) : '';
		$bairro = isset($_POST['bairro']) ? filter_var(trim($_POST['bairro'])) : '';
		$cidade = isset($_POST['cidade']) ? filter_var(trim($_POST['cidade'])) : '';
		$estado = isset($_POST['estado']) ? filter_var(trim($_POST['estado'])) : '';
		$telefones = isset($_POST['telefones']) ? filter_var_array($_POST['telefones']) : array();
		$emails = isset($_POST['emails']) ? filter_var_array($_POST['emails']) : array();
		$redes = isset($_POST['redes']) ? filter_var_array($_POST['redes']) : array();

		//vida profissional
		$profissao = isset($_POST['profissao']) ? filter_var(trim($_POST['profissao'])) : '';
		$aptidoesArtisticas = isset($_POST['aptidoesArtisticas']) ? filter_var(trim($_POST['aptidoesArtisticas'])) : '';
		$docencia = isset($_POST['docencia']) ? filter_var(trim($_POST['docencia'])) : '';
		$outras_informacoes = isset($_POST['outras_informacoes']) ? filter_var(trim($_POST['outras_informacoes'])) : '';



		//Dados Eclesiásticos
		$igreja = isset($_POST['igreja']) ? filter_var(trim($_POST['igreja'])) : '';
		$numero_rol = isset($_POST['numero_rol']) ? filter_var(trim($_POST['numero_rol'])) : '';
		$data_recebimento = isset($_POST['data_recebimento']) ? filter_var(trim($_POST['data_recebimento'])) : '';
		$data_batismo = isset($_POST['data_batismo']) ? filter_var(trim($_POST['data_batismo'])) : '';
		$data_profissao_fe = isset($_POST['data_profissao_fe']) ? filter_var(trim($_POST['data_profissao_fe'])) : '';
		$celebrante = isset($_POST['celebrante']) ? filter_var(trim($_POST['celebrante'])) : '';
		$local_batismo = isset($_POST['local_batismo']) ? filter_var(trim($_POST['local_batismo'])) : '';
		$tipo_recebimento = isset($_POST['tipo_recebimento']) ? filter_var(trim($_POST['tipo_recebimento'])) : '';
		$tipo_membro = isset($_POST['tipo_membro']) ? filter_var(trim($_POST['tipo_membro'])) : '';


		//Vida Eclesiásticas
		$oficial_igreja = isset($_POST['oficial_igreja']) ? filter_var(trim($_POST['oficial_igreja'])) : '';
		$tipoOficioIgreja = isset($_POST['tipoOficioIgreja']) ? filter_var(trim($_POST['tipoOficioIgreja'])) : '';
		$statusTipoOficioIgreja = isset($_POST['statusTipoOficioIgreja']) ? filter_var(trim($_POST['statusTipoOficioIgreja'])) : '';
		$dizimista = isset($_POST['dizimista']) ? filter_var(trim($_POST['dizimista'])) : '';
		$num_dizimista = isset($_POST['num_dizimista']) ? filter_var(trim($_POST['num_dizimista'])) : '';

		//telefones a excluir
		$telefonesExcluir = isset($_POST['telefonesExcluir']) ? filter_var_array($_POST['telefonesExcluir']) : array();
		//emails a excluir
		$emailsExcluir = isset($_POST['emailsExcluir']) ? filter_var_array($_POST['emailsExcluir']) : array();

		//redes sociais a excluir
		$redesociaisExcluir = isset($_POST['redesociaisExcluir']) ? filter_var_array($_POST['redesociaisExcluir']) : array();

		//validação dos dados
		$validate = new DataValidator();
		$validate->set('Nome', $nome, 'nome')->is_required()->min_length(2);
		$validate->set('Sobrenome', $sobrenome, 'sobrenome')->is_required()->min_length(2);
		$validate->set('Data de nascimento', $data_nascimento, 'data_nascimento')->is_required()->is_date('d/m/Y');
		$validate->set('Sexo', $sexo, 'sexo')->is_required();
		
		if ($validate->validate())
		{
	        $this->loadModel('membros/membrosModel');
			$membros = new membrosModel();

			$membros->setFoto($file);
			$membros->setNomeFoto($nomefoto);

			$membros->setNome($nome);
			$membros->setSobrenome($sobrenome);
			$membros->setDataNascimento($data_nascimento);
			$membros->setSexo($sexo);
			$membros->setFiliacao($filiacao);
			$membros->setNaturalidade($naturalidade);
			$membros->setNacionalidade($nacionalidade);
			$membros->setTipoDoc($tipoDoc);
			$membros->setRg($rg);
			$membros->setCpf($cpf);

			$membros->setEstadoCivil($estado_civil);
			$membros->setNomeConjuge($nome_conjuge);
			$membros->setIdConjuge($id_conjuge);
			$membros->setDataCasamento($data_casamento);
			$membros->setPai($pai);
			$membros->setMae($mae);

			$membros->setCep($cep);
			$membros->setRua($rua);
			$membros->setNumero($numero);
			$membros->setComplemento($complemento);
			$membros->setBairro($bairro);
			$membros->setCidade($cidade);
			$membros->setEstado($estado);
			$membros->setTelefones($telefones);
			$membros->setEmails($emails);
			$membros->setRedes($redes);

			$membros->setProfissao($profissao);
			$membros->setAptidoesArtisticas($aptidoesArtisticas);
			$membros->setDocencia($docencia);
			$membros->setOutras_informacoes($outras_informacoes);

			$membros->setIgreja($igreja);
			$membros->setNumeroRol($numero_rol);
			$membros->setDataRecebimento($data_recebimento);
			$membros->setDataBatismo($data_batismo);
			$membros->setDataProfissaoFe($data_profissao_fe);
			$membros->setCelebrante($celebrante);
			$membros->setLocalBatismo($local_batismo);
			$membros->setTipoRecebimento($tipo_recebimento);
			$membros->setTipoMembro($tipo_membro);

			$membros->setOficial_igreja($oficial_igreja);
			$membros->setTipoOficioIgreja($tipoOficioIgreja);
			$membros->setStatusTipoOficioIgreja($statusTipoOficioIgreja);
			$membros->setDizimista($dizimista);
			$membros->setNum_dizimista($num_dizimista);
			$membros->setStatus('Ativo');

			$membros->setTelefonesExcluir($telefonesExcluir);
			$membros->setEmailsExcluir($emailsExcluir);
			$membros->setRedesociaisExcluir($redesociaisExcluir);

			$membros->setId($id_membro);

			echo $membros->atualizar();
	    }else
	    {
			$todos_erros = $validate->get_errors();
			echo json_encode($todos_erros);
	    }
	
	}




	/**
	* Atualização do status do registro
	*/
	public function atualizarStatus()
	{
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('membros/membrosModel');
		$membro = new membrosModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
			
	}


	/**
	*Exclusão apena para envia-lo à lixeira
	*/
	public function excluir()
	{
		$this->saveAction();
		$id = isset($_POST['id']) ? filter_var(intval($_POST['id'])) : '';
		$status =isset($_POST['status']) ? $_POST['status'] : '';

		if($status == '')
		{
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status. Campo status não encontrado'));	
			return false;
		}

		$this->loadModel('membros/membrosModel');
		$membro = new membrosModel();
		$membro->setId($id);
		$membro->setStatus($status);
		if($membro->atualizarStatus())
			echo true;
		else
			echo json_encode(array('generalerror'=>'Erro ao atualizar o status'));	
	}
	


	/**
	* Lista em um select os tipos de ofício
	*/
	public function listarTipoOficio()
	{
		$id = isset($_POST['id']) ? intval($_POST['id']) : '';
		$this->loadModel('configuracoes/tabelas/tipoOficioIgrejaModel');
		$tipoOficioIgreja = new tipoOficioIgrejaModel();
		$statusOficio = $tipoOficioIgreja->listStatusOficio($id);
		$status = '';
		$status .= '<option value="" selected="selected" disabled>Status</option>';
		if($statusOficio != false)
		{
			foreach ($statusOficio as $value)
			{

				$status .= '<option value="'.$value['id_status_tipo_oficio_igreja'].'">'.$value['nome_status_tipo_oficio_igreja'].'</option>';
			}
		}
		echo $status;
	}
}


/**
*
*class: home
*
*location : controllers/rol-de-membros/home.controller.php
*/