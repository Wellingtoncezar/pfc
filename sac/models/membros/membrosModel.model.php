<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class membrosModel extends Controller{
	private $id;
	private $foto;
	private $nomeArquivoFoto;
	private $nome;
	private $sobrenome;
	private $dataNascimento;
	private $sexo;
	private $filiacao;
	private $naturalidade;
	private $nacionalidade;
	private $tipoDoc;
	private $rg;
	private $cpf;
	private $estadoCivil;
	private $nomeConjuge;
	private $idConjuge;
	private $dataCasamento;
	private $pai;
	private $mae;

	private $cep;
	private $rua;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $estado;
	private $telefones;
	private $emails;
	private $redes;

	private $profissao;
	private $aptidoesArtisticas;
	private $docencia;
	private $outras_informacoes;


	private $igreja;
	private $numero_rol;
	private $data_recebimento;
	private $data_batismo;
	private $data_profissao_fe;
	private $celebrante;
	private $local_batismo;
	private $tipo_recebimento;
	private $tipo_membro;

	private $oficial_igreja;
	private $tipoOficioIgreja;
	private $statusTipoOficioIgreja;
	private $dizimista;
	private $num_dizimista;

	private $status;

	private $telefonesExcluir = array();
	private $emailsExcluir = array();
	private $redesociaisExcluir = array();


	public function setTelefonesExcluir($telefonesExcluir = array())
	{
		$this->telefonesExcluir = $telefonesExcluir;
	}
	public function setEmailsExcluir($emailsExcluir = array())
	{
		$this->emailsExcluir = $emailsExcluir;
	}
	public function setRedesociaisExcluir($redesociaisExcluir = array())
	{
		$this->redesociaisExcluir = $redesociaisExcluir;
	}

	public function __construct(){
		parent::__construct();
	}

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setfoto($foto){
		$this->foto = $foto;
	}

	public function getfoto(){
		return $this->foto;
	}

	public function setNomeFoto($nomeArquivoFoto)
	{
		$this->nomeArquivoFoto = $nomeArquivoFoto;
	}

	public function setSobrenome($sobrenome){
		$this->sobrenome = $sobrenome;
	}

	public function getSobrenome(){
		return $this->sobrenome;
	}



	public function setDataNascimento($dataNascimento){
		$this->dataNascimento = $dataNascimento;
	}

	public function getDataNascimento(){
		return $this->dataNascimento;
	}

	public function setSexo($sexo){
		$this->sexo = $sexo;
	}

	public function getSexo(){
		return $this->sexo;
	}

	public function setFiliacao($filiacao){
		$this->filiacao = $filiacao;
	}

	public function getFiliacao(){
		return $this->filiacao;
	}

	public function setNaturalidade($naturalidade){
		$this->naturalidade = $naturalidade;
	}

	public function getNaturalidade(){
		return $this->naturalidade;
	}



	public function setNacionalidade($nacionalidade){
		$this->nacionalidade = $nacionalidade;
	}

	public function getNacionalidade(){
		return $this->nacionalidade;
	}


	public function setTipoDoc($tipoDoc){
		$this->tipoDoc = $tipoDoc;
	}

	public function getTipoDoc(){
		return $this->tipoDoc;
	}

	public function setRg($rg){
		$this->rg = $rg;
	}

	public function getRg(){
		return $this->rg;
	}



	public function setCpf($cpf){
		$this->cpf = $cpf;
	}

	public function getCpf(){
		return $this->cpf;
	}


	public function setEstadoCivil($estadoCivil){
		$this->estadoCivil = $estadoCivil;
	}

	public function getEstadoCivil(){
		return $this->estadoCivil;
	}

	public function setNomeConjuge($nomeConjuge){
		$this->nomeConjuge = $nomeConjuge;
	}

	public function getNomeConjuge(){
		return $this->nomeConjuge;
	}

	public function setIdConjuge($idConjuge){
		$this->idConjuge = $idConjuge;
	}

	public function getIdConjuge(){
		return $this->idConjuge;
	}

	public function setDataCasamento($dataCasamento){
		$this->dataCasamento = $dataCasamento;
	}

	public function getDataCasamento(){
		return $this->dataCasamento;
	}


	public function setPai($pai){
		$this->pai = $pai;
	}

	public function getPai(){
		return $this->pai;
	}

	public function setMae($mae){
		$this->mae = $mae;
	}

	public function getMae(){
		return $this->mae;
	}

	



	public function setCep($cep)
	{
		$this->cep = $cep;
	}
	public function getCep()
	{
		return $this->cep;
	}


	public function setRua($rua)
	{
		$this->rua = $rua;
	}
	public function getRua()
	{
		return $this->rua;
	}


	public function setNumero($numero)
	{
		$this->numero = $numero;
	}
	public function getNumero()
	{
		return $this->numero;
	}


	public function setComplemento($complemento)
	{
		$this->complemento = $complemento;
	}
	public function getComplemento()
	{
		return $this->complemento;
	}


	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}
	public function getBairro()
	{
		return $this->bairro;
	}


	public function setCidade($cidade)
	{
		$this->cidade = $cidade;
	}
	public function getCidade()
	{
		return $this->cidade;
	}


	public function setEstado($estado)
	{
		$this->estado = $estado;
	}
	public function getEstado()
	{
		return $this->estado;
	}



	public function setTelefones($telefones){
		$this->telefones = $telefones;
	}
	public function getTelefones()
	{
		return $this->telefones;
	}



	public function setEmails($emails){
		$this->emails = $emails;
	}
	public function getEmails()
	{
		return $this->emails;
	}

	public function setRedes($redes){
		$this->redes = $redes;
	}
	public function getRedes()
	{
		return $this->redes;
	}


	public function setProfissao($profissao)
	{
		$this->profissao = $profissao;
	}
	public function getProfissao()
	{
		return $profissao;
	}

	public function setAptidoesArtisticas($aptidoesArtisticas)
	{
		$this->aptidoesArtisticas = $aptidoesArtisticas;
	}
	public function getAptidoesArtisticas()
	{
		return $aptidoesArtisticas;
	}


	public function setDocencia($docencia)
	{
		$this->docencia = $docencia;
	}
	public function getDocencia()
	{
		return $docencia;
	}

	public function setOutras_informacoes($outras_informacoes)
	{
		$this->outras_informacoes = $outras_informacoes;
	}
	public function getOutras_informacoes()
	{
		return $outras_informacoes;
	}



	public function setIgreja($igreja)
	{
		$this->igreja = $igreja;
	}

	public function getIgreja($igreja)
	{
		$this->igreja = $igreja;
	}


	public function setnumeroRol($numero_rol)
	{
		$this->numero_rol = $numero_rol;
	}
	public function getNumeroRol($numero_rol)
	{
		$this->numero_rol = $numero_rol;
	}

	public function setDataRecebimento($data_recebimento)
	{
		$this->data_recebimento = $data_recebimento;
	}
	public function getDataRecebimento($data_recebimento)
	{
		$this->data_recebimento = $data_recebimento;
	}


	public function setDataBatismo($data_batismo)
	{
		$this->data_batismo = $data_batismo;
	}
	public function getDataBatismo($data_batismo)
	{
		$this->data_batismo = $data_batismo;
	}


	public function setDataProfissaoFe($data_profissao_fe)
	{
		$this->data_profissao_fe = $data_profissao_fe;
	}

	public function getDataProfissaoFe($data_profissao_fe)
	{
		$this->data_profissao_fe = $data_profissao_fe;
	}


	public function setCelebrante($celebrante)
	{
		$this->celebrante = $celebrante;
	}
	public function getCelebrante($celebrante)
	{
		$this->celebrante = $celebrante;
	}


	public function setLocalBatismo($local_batismo)
	{
		$this->local_batismo = $local_batismo;
	}
	public function getLocalBatismo($local_batismo)
	{
		$this->local_batismo = $local_batismo;
	}


	public function setTipoRecebimento($tipo_recebimento)
	{
		$this->tipo_recebimento = $tipo_recebimento;
	}
	public function getTipoRecebimento($tipo_recebimento)
	{
		$this->tipo_recebimento = $tipo_recebimento;
	}


	public function setTipoMembro($tipo_membro)
	{
		$this->tipo_membro = $tipo_membro;
	}
	public function getTipoMembro($tipo_membro)
	{
		$this->tipo_membro = $tipo_membro;
	}


	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


	public function setOficial_igreja($oficial_igreja)
	{
		$this->oficial_igreja = $oficial_igreja;
	}
	public function getOficial_igreja()
	{
		return $this->oficial_igreja;
	}


	public function setTipoOficioIgreja($tipoOficioIgreja)
	{
		$this->tipoOficioIgreja = $tipoOficioIgreja;
	}
	public function getTipoOficioIgreja()
	{
		return $this->tipoOficioIgreja;
	}


	public function setStatusTipoOficioIgreja($statusTipoOficioIgreja)
	{
		$this->statusTipoOficioIgreja = $statusTipoOficioIgreja;
	}
	public function getStatusTipoOficioIgreja()
	{
		return $this->statusTipoOficioIgreja;
	}


	public function setDizimista($dizimista)
	{
		$this->dizimista = $dizimista;
	}
	public function getDizimista()
	{
		return $this->dizimista;
	}

	public function setNum_dizimista($num_dizimista)
	{
		$this->num_dizimista = $num_dizimista;
	}
	public function getNum_dizimista()
	{
		return $this->num_dizimista;
	}


	public function issetMembro()
	{
		$this->clear();
		$this->setTabela('membros');
		$this->condicao("rg_cpf_membro='".$this->rgCpf."'");
		$this->select();
		if($this->rowCount() > 0)
			return $this->result();
		else
			return false;
	}


	public function inserir()
	{
		//nome da imagem
		$char = new caracteres($this->nome);
		$this->nomeArquivoFoto = $char->getValor().'('.date('HisdmY').')';

		if($this->foto != '')
		{
			$upload = $this->uploadFoto($this->nomeArquivoFoto);
			if($upload)
			{
				return $this->insertData();
			}else
			{
				return $upload;
			}
		}else
		{
			return $this->insertData();
		}
	}

	private function insertData()
	{
		//formata a data para o banco de dados
		$dataFormat = new dataFormat();
		$this->dataNascimento = $dataFormat->formatar($this->dataNascimento,'data','banco');
		$this->dataCasamento = $dataFormat->formatar($this->dataCasamento,'data','banco');

		$this->data_recebimento = $dataFormat->formatar($this->data_recebimento,'data','banco');
		$this->data_batismo = $dataFormat->formatar($this->data_batismo,'data','banco');
		$this->data_profissao_fe = $dataFormat->formatar($this->data_profissao_fe,'data','banco');

		$data = array(
			'nome_membro' => filter_var($this->nome),
			'sobrenome_membro' => filter_var($this->sobrenome),
			'data_nascimento_membro' => filter_var($this->dataNascimento),
			'sexo_membro' => filter_var($this->sexo),
			'filiacao_membro' => filter_var($this->filiacao),
			'naturalidade_membro' => filter_var($this->naturalidade),
			'nacionalidade_membro' => filter_var($this->nacionalidade),
			'rg_membro' => filter_var($this->rg),
			'cpf_membro' => filter_var($this->cpf),
			'id_estado_civil' => intval($this->estadoCivil),
			'nome_conjuge_membro' => filter_var($this->nomeConjuge),
			'id_conjuge_membro' => filter_var($this->idConjuge),
			'data_casamento_membro' => filter_var($this->dataCasamento),
			'profissao_membro' => filter_var($this->profissao),
			'profissao_membro' => filter_var($this->profissao),
			'aptidoes_artisticas_membro' => filter_var($this->aptidoesArtisticas),
			'docencia_membro' => filter_var($this->docencia),
			'outras_informacoes_membro' => filter_var($this->outras_informacoes),

			'outras_informacoes_membro' => filter_var($this->outras_informacoes),
			'id_igreja' => filter_var($this->igreja),
			'numero_rol_membro' => filter_var($this->numero_rol),
			'data_recebimento_membro' => filter_var($this->data_recebimento),
			'data_batismo' => filter_var($this->data_batismo),
			'data_profissao_fe_membro' => filter_var($this->data_profissao_fe),
			'celebrante_batismo' => filter_var($this->celebrante),
			'local_batismo' => filter_var($this->local_batismo),
			'id_tipo_recebimento' => filter_var($this->tipo_recebimento),
			'id_tipo_membro' => filter_var($this->tipo_membro),
			'oficial_igreja_membro' => filter_var($this->oficial_igreja),
			'id_tipo_oficio_igreja' => filter_var($this->tipoOficioIgreja),
			'id_status_tipo_oficio_igreja' => filter_var($this->statusTipoOficioIgreja),
			'dizimista_membro' => filter_var($this->dizimista),
			'numero_dizimista' => filter_var($this->num_dizimista),
			'status_membro' => filter_var($this->status),
			'foto_membro' => $this->nomeArquivoFoto,
			'data_cadastro_membro' => date('Y-m-d H:i:s')
		);
		
		$this->clear();
		//$this->query('BEGIN');
		$this->setTabela('membros');
		$this->insert($data);
		if($this->rowCount() > 0)
		{
			$this->id = $this->getUltimoId();
			//construção da genealogia
			if($this->pai != '' || $this->mae != '')
			{
				$this->setTabela('genealogia');
				$data = array(
					'id_membro' => $this->id,
					'id_pai' => $this->pai,
					'id_mae' => $this->mae,
					'data_cadastro' => date('Y-m-d H:i:s')
				);
				$this->insert($data);
			}


			//cadastro do endereço
			if($this->cep != '')
			{
				$this->setTabela('enderecos');
				$data = array(
					'id_membro' => $this->id,
					'cep_endereco' => filter_var($this->cep),
					'rua_endereco' => filter_var($this->rua),
					'numero_endereco' => filter_var($this->numero),
					'complemento_endereco' => filter_var($this->complemento),
					'bairro_endereco' => filter_var($this->bairro),
					'cidade_endereco' => filter_var($this->cidade),
					'estado_endereco' => filter_var($this->estado),
					'data_cadastro_endereco' => date('Y-m-d H:i:s')
				);
				$this->insert($data);
			}



			if($this->telefones != '' &&  !empty($this->telefones))
				$this->insertTelefones();

			if($this->emails != '' &&  !empty($this->emails))
				$this->insertEmail();

			if($this->redes != '' &&  !empty($this->redes))
				$this->insertRedes();


			$this->query('COMMIT');
			return true;
		}else{
			$this->query('ROLLBACK');
			return json_encode(array('erro'=>'Erro ao inserir registro'));
		}
	}



	public function atualizar()
	{
		if($this->foto != '')
		{
			if(file_exists(BASEPATH.'uploads/membros/'.$this->nomeArquivoFoto))
				unlink(BASEPATH.'uploads/membros/'.$this->nomeArquivoFoto);

			if(file_exists(BASEPATH.'uploads/membros/p/'.$this->nomeArquivoFoto))
				unlink(BASEPATH.'uploads/membros/p/'.$this->nomeArquivoFoto);

			$char = new caracteres($this->nome);
			$this->nomeArquivoFoto = $char->getValor().'('.date('HisdmY').')';

			$upload = $this->uploadFoto($this->nomeArquivoFoto);
			if($upload)
			{

				return $this->updateData();
			}else
			{
				return $upload;
			}
		}else
		{
			return $this->updateData();
		}
		
	}


	private function updateData()
	{
		//formata a data para o banco de dados
		$dataFormat = new dataFormat();
		$this->dataNascimento = $dataFormat->formatar($this->dataNascimento,'data','banco');
		$this->dataCasamento = $dataFormat->formatar($this->dataCasamento,'data','banco');

		$this->data_recebimento = $dataFormat->formatar($this->data_recebimento,'data','banco');
		$this->data_batismo = $dataFormat->formatar($this->data_batismo,'data','banco');
		$this->data_profissao_fe = $dataFormat->formatar($this->data_profissao_fe,'data','banco');

		$data = array(
			'nome_membro' => filter_var($this->nome),
			'sobrenome_membro' => filter_var($this->sobrenome),
			'data_nascimento_membro' => filter_var($this->dataNascimento),
			'sexo_membro' => filter_var($this->sexo),
			'filiacao_membro' => filter_var($this->filiacao),
			'naturalidade_membro' => filter_var($this->naturalidade),
			'nacionalidade_membro' => filter_var($this->nacionalidade),
			'rg_membro' => filter_var($this->rg),
			'cpf_membro' => filter_var($this->cpf),
			'id_estado_civil' => intval($this->estadoCivil),
			'nome_conjuge_membro' => filter_var($this->nomeConjuge),
			'id_conjuge_membro' => filter_var($this->idConjuge),
			'data_casamento_membro' => filter_var($this->dataCasamento),
			'profissao_membro' => filter_var($this->profissao),
			'profissao_membro' => filter_var($this->profissao),
			'aptidoes_artisticas_membro' => filter_var($this->aptidoesArtisticas),
			'docencia_membro' => filter_var($this->docencia),
			'outras_informacoes_membro' => filter_var($this->outras_informacoes),

			'outras_informacoes_membro' => filter_var($this->outras_informacoes),
			'id_igreja' => filter_var($this->igreja),
			'numero_rol_membro' => filter_var($this->numero_rol),
			'data_recebimento_membro' => filter_var($this->data_recebimento),
			'data_batismo' => filter_var($this->data_batismo),
			'data_profissao_fe_membro' => filter_var($this->data_profissao_fe),
			'celebrante_batismo' => filter_var($this->celebrante),
			'local_batismo' => filter_var($this->local_batismo),
			'id_tipo_recebimento' => filter_var($this->tipo_recebimento),
			'id_tipo_membro' => filter_var($this->tipo_membro),
			'oficial_igreja_membro' => filter_var($this->oficial_igreja),
			'id_tipo_oficio_igreja' => filter_var($this->tipoOficioIgreja),
			'id_status_tipo_oficio_igreja' => filter_var($this->statusTipoOficioIgreja),
			'dizimista_membro' => filter_var($this->dizimista),
			'numero_dizimista' => filter_var($this->num_dizimista),
			'status_membro' => filter_var($this->status),
			'foto_membro' => $this->nomeArquivoFoto,
			'data_cadastro_membro' => date('Y-m-d H:i:s')
		);
		
		$this->clear();
		//$this->query('BEGIN');
		$this->setTabela('membros');
		$this->setCondicao('id_membro = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
		{
			//$this->id = $this->getUltimoId();
			//construção da genealogia
			if($this->pai != '' || $this->mae != '')
			{
				$this->setTabela('genealogia');
				$data = array(
					'id_membro' => $this->id,
					'id_pai' => $this->pai,
					'id_mae' => $this->mae,
					'data_cadastro' => date('Y-m-d H:i:s')
				);
				$this->setCondicao('id_membro = "'.$this->id.'"');
				$this->select();
				if($this->rowCount() > 0)
				{
					$this->update($data);
				}else
					$this->insert($data);
			}


			//cadastro do endereço
			if($this->cep != '')
			{
				$this->setTabela('enderecos');
				$data = array(
					'id_membro' => $this->id,
					'cep_endereco' => filter_var($this->cep),
					'rua_endereco' => filter_var($this->rua),
					'numero_endereco' => filter_var($this->numero),
					'complemento_endereco' => filter_var($this->complemento),
					'bairro_endereco' => filter_var($this->bairro),
					'cidade_endereco' => filter_var($this->cidade),
					'estado_endereco' => filter_var($this->estado),
					'data_cadastro_endereco' => date('Y-m-d H:i:s')
				);
				$this->setCondicao('id_membro = "'.$this->id.'"');
				$this->select();
				if($this->rowCount() > 0)
				{
					$this->update($data);
				}else
					$this->insert($data);
			}


			//TELEFONES
			if($this->telefones != '' &&  !empty($this->telefones))
				$this->insertTelefones();

			if($this->telefonesExcluir != '' &&  !empty($this->telefonesExcluir))
				$this->excluiTelefones();


			//EMAILS
			if($this->emails != '' &&  !empty($this->emails))
				$this->insertEmail();

			if($this->emailsExcluir != '' &&  !empty($this->emailsExcluir))
				$this->excluiEmails();



			//REDES
			if($this->redes != '' &&  !empty($this->redes))
				$this->insertRedes();

			if($this->redesociaisExcluir != '' &&  !empty($this->redesociaisExcluir))
				$this->excluiRedesociais();



			$this->query('COMMIT');
			return true;
		}else{
			$this->query('ROLLBACK');
			return json_encode(array('erro'=>'Erro ao inserir registro'));
		}
	}



	private function excluiTelefones()
	{
		foreach ($this->telefonesExcluir as $value)
		{
			$this->clear();
			$this->setTabela('telefones');
			$this->setCondicao('id_telefone = "'.$value.'"');
			$this->delete();
		}
	}

	private function excluiEmails()
	{
		foreach ($this->emailsExcluir as $value)
		{
			$this->clear();
			$this->setTabela('emails');
			$this->setCondicao('id_email = "'.$value.'"');
			$this->delete();
		}
	}

	private function excluiRedesociais()
	{
		foreach ($this->redesociaisExcluir as $value)
		{
			$this->clear();
			$this->setTabela('redes_sociais');
			$this->setCondicao('id_rede_social = "'.$value.'"');
			$this->delete();
		}
	}



	private function insertTelefones()
	{
		$this->clear();
		$this->setTabela('telefones');
		$arr = array();
		
		foreach ($this->telefones as $key => $value){
			if(!empty($value))
			{
				$data = array(
					'id_membro' => $this->id,
					'telefone' => $value['telefone'],
					'categoria' => $value['categoria'],
					'operadora' => $value['operadora'],
					'id_tipo_telefone' => $value['tipo_telefone'],
					'data_cadastro' => date('Y-m-d H:i:s')
				);
				if(isset($value['idtelefone']) && $value['idtelefone'] != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->setCondicao('id_telefone = "'.$value['idtelefone'].'"');
					$this->update($data);
				}else
					$this->insert($data);
			}
		}
	}


	private function insertEmail()
	{
		$this->clear();
		$this->setTabela('emails');
		$arr = array();
		
		foreach ($this->emails as $key => $value){
			if(!empty($value))
			{
				$data = array(
					'id_membro' => $this->id,
					'id_tipo_email' => $value['tipo_email'],
					'email' => $value['email'],
					'data_cadastro_email' => date('Y-m-d H:i:s')
				);

				if(isset($value['idemail']) && $value['idemail'] != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->setCondicao('id_email = "'.$value['idemail'].'"');
					$this->update($data);
				}else
					$this->insert($data);
			}
		}
	}


	private function insertRedes()
	{
		$this->clear();
		$this->setTabela('redes_sociais');
		$arr = array();
		
		foreach ($this->redes as $key => $value){
			if(!empty($value))
			{
				$data = array(
					'id_membro' => $this->id,
					'nome_rede_social' => $value['redesocial'],
					'link_rede_social' => $value['linkredesocial'],
					'data_cadastro_rede_social' => date('Y-m-d H:i:s')
				);
				if(isset($value['idredesociais']) && $value['idredesociais'] != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->setCondicao('id_rede_social = "'.$value['idredesociais'].'"');
					$this->update($data);
				}else
					$this->insert($data);
			}
		}
	}



	public function uploadFoto($nomeArquivo)
	{
		if(is_dir(BASEPATH.'uploads/membros/'))
		{
			$arquivo = $this->foto;
			$destino = BASEPATH.'uploads/membros/';
			$destino_p = BASEPATH.'uploads/membros/p/';

			if(!is_dir($destino))
				mkdir($destino);

			if(!is_dir($destino_p))
				mkdir($destino_p);

			$img= new upload($arquivo,$destino, $nomeArquivo);
			if($img->getError() == false)
			{
				$dest = $destino.$img->getArquivo();
				$dest_p = $destino_p.$img->getArquivo();
				if(
					(isset($_POST['w']) && $_POST['w'] != '') ||
					(isset($_POST['h']) && $_POST['h'] != '') ||
					(isset($_POST['x1']) && $_POST['x1'] != '') ||
					(isset($_POST['y1']) && $_POST['y1'] != '')
					){
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];
						
						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->cropResize();
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->cropResize();
					}else
					{
						$w = $_POST['w'] ;
						$h =  $_POST['h'];
						$x1 = $_POST['x1'];
						$y1 = $_POST['y1'];

						$crop = new crop_image();
						$crop->setImage($dest,$dest_p,$w, $h,$x1, $y1,404, 158);
						$crop->setImage($dest,$dest,$w, $h,$x1, $y1,1349, 527);
						$crop->resize();
					}

				$this->nomeArquivoFoto = $img->getArquivo();
				return true;
			
			}else
				return $img->getError();
		}else
			return 'Erro ao efetuar o upload. O diretório não existe';


	}




	//getMembro
	public function getMembro($id){
		$this->clear();
		$this->query("SELECT * FROM membros WHERE id_membro = '$id'");
		if($this->rowCount() > 0){
			return $this->result();
		}else{
			return false;
		}
	}



	//listar
	public function listar($condicao = '<>', $valor = 'Excluído'){
		echo "SELECT * FROM membros AS A LEFT JOIN igreja AS B ON A.id_igreja = B.id_igreja WHERE status_membro $condicao '$valor' ORDER BY A.nome_membro";
		$this->clear();
		$this->query("SELECT * FROM membros AS A LEFT JOIN igreja AS B ON A.id_igreja = B.id_igreja WHERE status_membro $condicao '$valor' ORDER BY A.nome_membro");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}

	//getGenealogia
	public function getGenealogia($id){
		$this->clear();
		$this->query("SELECT * FROM genealogia WHERE id_membro = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->result();
		}else
		{
			return false;
		}
	}

	//getEndereço
	public function getEndereco($id){
		$this->clear();
		$this->query("SELECT * FROM enderecos WHERE id_membro = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->result();
		}else
		{
			return false;
		}
	}

	//getStatusOficioIgreja
	public function getStatusOficioIgreja($id){
		$this->clear();
		$this->query("SELECT * FROM status_tipo_oficio_igreja WHERE id_tipo_oficio_igreja = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->resultAll();
		}else
		{
			return false;
		}
	}

	
	//getTelefonesList
	public function getTelefonesList($id){
		$this->clear();
		$this->query("SELECT * FROM telefones WHERE id_membro = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->resultAll();
		}else
		{
			return false;
		}
	}

	//getEmailsList
	public function getEmailsList($id){
		$this->clear();
		$this->query("SELECT * FROM emails WHERE id_membro = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->resultAll();
		}else
		{
			return false;
		}
	}
	
	//getRedesSociaisList
	public function getRedesSociaisList($id){
		$this->clear();
		$this->query("SELECT * FROM redes_sociais WHERE id_membro = '".$id."'");
		if($this->rowCount() > 0)
		{
			return $this->resultAll();
		}else
		{
			return false;
		}
	}


	//atualizarStatus
	public function atualizarStatus()
	{
		$data = array(
			'status_membro' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('membros');
		$this->setCondicao('id_membro = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	
}

