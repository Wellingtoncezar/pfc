<?php
/**
 * Classe DAO de funcionários
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosDao extends Dao{
	private $nomeArquivoFoto;
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos funcionarios
	 * @return Array
	 */
	public function listar()
	{
		$this->load->dao('funcionarios/listarTodos');
		return $this->listarFuncionarios(new listarTodos());
	}

	public function listarAtivos()
	{
		$this->load->dao('funcionarios/listarAtivos');
		return $this->listarFuncionarios(new listarAtivos());
	}

	private function listarFuncionarios(iListagemFuncionarios $listafuncionarios)
	{
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('funcionarios/cargosModel');

		$funcionarios = Array();
		$result = $listafuncionarios->listar($this->db);

		if($result != null):
			foreach ($result as $value)
			{
				$funcionariosModel = new funcionariosModel();
				$funcionariosModel->setId($value['id_funcionario']);
				$funcionariosModel->setFoto($value['foto_funcionario']);
				$funcionariosModel->setNome($value['nome_funcionario']);
				$funcionariosModel->setSobrenome($value['sobrenome_funcionario']);
				$funcionariosModel->setCpf($value['cpf_funcionario']);
				$funcionariosModel->setCodigo($value['codigo_funcionario']);
				$funcionariosModel->setStatus(status::getAttribute($value['status_funcionario']));
				$funcionariosModel->setDataAtualizacao($value['timestamp']);
				$funcionariosModel->setUserAdministrator($this->isFuncionarioAdministrador($funcionariosModel));
				//cargo
				$cargo = new cargosModel();
				$cargo->setNome($value['nome_cargo']);
				$cargo->setSetor($value['setor_cargo']);
				$funcionariosModel->setCargo($cargo);



				array_push($funcionarios, $funcionariosModel);
				unset($funcionariosModel);
			}
		endif;
		return $funcionarios;
		
	}

	/**
	 * verifica se um funcionário úm um usuário administrador do sistema
	 * @return boolean 
	 **/
	public function isFuncionarioAdministrador(funcionariosModel $funcionario)
	{
		//checagem de funcionário administrador
		$sql="select * from sys_usuarios as a 
				inner join nivel_acesso as b on a.id_nivel_acesso = b.id_nivel_acesso
		    	where a.id_funcionario = ? and b.permissoes = '*'";
		$this->db->clear();  
		$this->db->setParameter(1, $funcionario->getId());
		if($this->db->query($sql))
		{
			return true;
		}else
			return false;
	}


	/**
	 * Retorna a consulta de um funcionário pelo id
	 * @return object [funcionariosModel]
	 */
	public function consultar(funcionariosModel $func)
	{
		$funcionario = new funcionariosModel();
		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao("id_funcionario = ?");
		$this->db->setParameter(1, $func->getId());

		//FUNCIONARIO
		if($this->db->select()):
			$result = $this->db->result();

			//TELEFONES
			$this->db->clear();
			$this->db->setTabela('telefones AS A, telefones_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = ? AND A.id_telefone = B.id_telefone");
			$this->db->setParameter(1, $func->getId());

			if($this->db->select()):
				$resultTel = $this->db->resultAll();

				$this->load->model('telefoneModel');
				foreach ($resultTel as $telefone)
				{
					$telefoneModel = new telefoneModel();
					$telefoneModel->setId( $telefone['id_telefone'] );
					$telefoneModel->setCategoria( $telefone['categoria_telefone'] );
					$telefoneModel->setNumero( $telefone['numero_telefone'] );
					$telefoneModel->setOperadora( $telefone['operadora_telefone'] );
					$telefoneModel->setTipo($telefone['tipo_telefone'] );
					$funcionario->addTelefone($telefoneModel);
				}
			endif;


			//EMAILS
			$this->db->clear();
			$this->db->setTabela('emails as A, emails_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = ? AND B.id_email = A.id_email");
			$this->db->setParameter(1, $func->getId());
			$this->db->select();
			
			if($this->db->rowCount() > 0):
				$resultEmail = $this->db->resultAll();

				$this->load->model('emailModel');
				foreach ($resultEmail as $email)
				{

					$emailModel = new emailModel();
					$emailModel->setId( $email['id_email'] );
					$emailModel->setEmail( $email['endereco_email'] );
					$emailModel->setTipo( $email['tipo_email'] );
					$funcionario->addEmail($emailModel);
				}
			endif;


			//ENDERECO
			$this->db->clear();
			$this->db->setTabela('enderecos as A, enderecos_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = ? AND A.id_endereco = B.id_endereco ");
			$this->db->setParameter(1, $func->getId());
			$this->db->select();
			
			$this->load->model('enderecoModel');
			$endereco = new enderecoModel();
			if($this->db->rowCount() > 0):
				$resultEnd = $this->db->result();

				$endereco->setId($resultEnd['id_endereco']);
				$endereco->setCep($resultEnd['cep_endereco']);
				$endereco->setNumero($resultEnd['numero_endereco']);
				$endereco->setComplemento($resultEnd['complemento_endereco']);
				$endereco->setLogradouro($resultEnd['rua_endereco']);
				$endereco->setBairro($resultEnd['bairro_endereco']);
				$endereco->setCidade($resultEnd['cidade_endereco']);
				$endereco->setEstado($resultEnd['estado_endereco']);
			endif;

			$funcionario->setId($result['id_funcionario']);
			$funcionario->setFoto($result['foto_funcionario']);
			$funcionario->setNome($result['nome_funcionario']);
			$funcionario->setSobrenome($result['sobrenome_funcionario']);
			$funcionario->setDataNascimento($result['data_nascimento_funcionario']);
			$funcionario->setSexo($result['sexo_funcionario']);
			$funcionario->setRg($result['rg_funcionario']);
			$funcionario->setCpf($result['cpf_funcionario']);
			$funcionario->setEstadoCivil($result['estado_civil_funcionario']);
			$funcionario->setEscolaridade($result['escolaridade_funcionario']);
			$funcionario->setEndereco($endereco);
			
			

			$this->load->model('funcionarios/cargosModel');
			$cargosModel = new cargosModel();
			$cargosModel->setId($result['id_cargo']);
			$funcionario->setCargo($cargosModel);

			$funcionario->setDataAdmissao($result['data_admissao_funcionario']);
			$funcionario->setDataDemissao($result['data_demissao_funcionario']);
			$funcionario->setStatus(status::getAttribute($result['status_funcionario']));
			return $funcionario;
		else:
			return $funcionario;
		endif;
	}



	/**
	 * Insere novos funcionários
	 * @return boolean
	 */
 	public function inserir(funcionariosModel $funcionario)
 	{

		$this->load->library('geracodigo');
		$geracodigo = new geracodigo();	
		$codigoFuncionario = date('dmy').'.'.$geracodigo->setTamanho(4)->gerar();


 		$data = array(
 			'foto_funcionario' => $funcionario->getFoto(),
 			'nome_funcionario' => $funcionario->getNome(),
 			'sobrenome_funcionario' => $funcionario->getSobrenome(),
 			'data_nascimento_funcionario' => $funcionario->getDataNascimento(),
 			'sexo_funcionario' => $funcionario->getSexo(),
 			'rg_funcionario' => $funcionario->getRg(),
 			'cpf_funcionario' => $funcionario->getCpf(),
 			'estado_civil_funcionario' => $funcionario->getEstadoCivil(),
 			'escolaridade_funcionario' => $funcionario->getEscolaridade(),
 			'codigo_funcionario' => $codigoFuncionario,
 			'id_cargo' => $funcionario->getCargo()->getId(),
 			'data_admissao_funcionario' => $funcionario->getDataAdmissao(),
 			'data_demissao_funcionario' => $funcionario->getDataDemissao(),
 			'status_funcionario' => $funcionario->getStatus(),
 			'data_cadastro_funcionario' => $funcionario->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('funcionarios');
		try {
			if($this->db->insert($data))
			{
				$funcionario->setId($this->db->getUltimoId()); //RETORNA O ID INSERIDO

				$this->atualizaEndereco($funcionario);
				//TELEFONES
				if(!empty($funcionario->getTelefones()))
					$this->atualizaTelefones($funcionario);

				//EMAILS
				if(!empty($funcionario->getEmail()))
					$this->atualizaEmails($funcionario);

				return true;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		} catch (dbException $e) {
			return $e->getMessageError();
		}
		
		

	}

	/**
	 * Atualiza funcionários
	 * @return boolean
	 */
 	public function atualizar(funcionariosModel $funcionario)
 	{

		$data = array(
 			'foto_funcionario' => $funcionario->getFoto(),
 			'nome_funcionario' => $funcionario->getNome(),
 			'sobrenome_funcionario' => $funcionario->getSobrenome(),
 			'data_nascimento_funcionario' => $funcionario->getDataNascimento(),
 			'sexo_funcionario' => $funcionario->getSexo(),
 			'rg_funcionario' => $funcionario->getRg(),
 			'cpf_funcionario' => $funcionario->getCpf(),
 			'estado_civil_funcionario' => $funcionario->getEstadoCivil(),
 			'escolaridade_funcionario' => $funcionario->getEscolaridade(),
 			'id_cargo' => $funcionario->getCargo()->getId(),
 			'data_admissao_funcionario' => $funcionario->getDataAdmissao(),
 			'data_demissao_funcionario' => $funcionario->getDataDemissao()
 		);

		try {
	 		$this->db->clear();
			$this->db->setTabela('funcionarios');
			$this->db->setCondicao("id_funcionario = ?");
			$this->db->setParameter(1, $funcionario->getId());
			if($this->db->update($data))
			{
				$this->nUpdates++;
			}
		} catch (dbException $e) {
			return $e->getMessageError();
		}

		
		
		//ENDEREÇO
		$this->atualizaEndereco($funcionario);
		//TELEFONES
		$this->atualizaTelefones($funcionario);
		//EMAILS
		$this->atualizaEmails($funcionario);

 		if($this->nUpdates > 0)
			return true;
 		else
 		{
 			return json_encode(array('erro'=>'Erro ao editar registro'));
 		}
	}





 	/**
 	 * Atualiza ou insere o endereço
 	 * @return boolean
 	 * */
 	public function atualizaEndereco(funcionariosModel $funcionario)
 	{

	 	$this->db->clear();
		$this->db->setTabela('enderecos');
		$data = array(
			'cep_endereco' => $funcionario->getEndereco()->getCep(),
			'rua_endereco' => $funcionario->getEndereco()->getLogradouro(),
			'numero_endereco' => $funcionario->getEndereco()->getNumero(),
			'complemento_endereco' => $funcionario->getEndereco()->getComplemento(),
			'bairro_endereco' => $funcionario->getEndereco()->getBairro(),
			'cidade_endereco' => $funcionario->getEndereco()->getCidade(),
			'estado_endereco' => $funcionario->getEndereco()->getEstado(),
			'data_cadastro_endereco' => date('Y-m-d h:i:s')
		);
		

		if($funcionario->getEndereco()->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
		{
			$this->db->setCondicao('id_endereco = "'.$funcionario->getEndereco()->getId().'"');
			$this->db->update($data);
		}else{
			$this->db->insert($data);
			$idEndereco = $this->db->getUltimoId();
			$idFuncionario = $funcionario->getId();
			$this->db->query("INSERT INTO enderecos_funcionarios VALUES ('$idFuncionario','$idEndereco')");
		}

		if($this->db->rowCount() > 0){
			$this->nUpdates++;
			return true;
		}
		else
			return false;
 	}



 	/**
 	 * 
 	 * Atualiza ou insere os telefones
 	 * @return void
 	 */
 	private function atualizaTelefones(funcionariosModel $funcionario)
	{

		//excluir
		$telefonesExcluir = array();
		foreach ($funcionario->getTelefones() as $telefones)
		{
			if($telefones->getId() != '')
				array_push($telefonesExcluir,$telefones->getId());
		}
		$cond = '';
		if(!empty($telefonesExcluir))
		{
			$telefonesExcluir = implode(',', $telefonesExcluir);
			$this->db->clear();
			$cond = " AND id_telefone not in (".$telefonesExcluir.")";
		}
		$sql = "DELETE FROM telefones WHERE id_telefone in( SELECT B.id_telefone FROM telefones_funcionarios AS B WHERE B.id_funcionario = '".$funcionario->getId()."' AND id_telefone = B.id_telefone) $cond";
		$this->db->query($sql);

		$this->db->clear();
		$this->db->setTabela('telefones');
		foreach ($funcionario->getTelefones() as $telefones)
		{
			if(!empty($telefones))
			{
				$data = array(
					'categoria_telefone' => $telefones->getCategoria(),
					'numero_telefone' => $telefones->getNumero(),
					'tipo_telefone' => $telefones->getTipo(),
					'operadora_telefone' => $telefones->getOperadora()
				);
				if($telefones->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_telefone = "'.$telefones->getId().'"');
					$this->db->update($data);
				}else{
					$this->db->insert($data);
					$idTelefone = $this->db->getUltimoId();
					$idFuncionario = $funcionario->getId();
					$this->db->query("INSERT INTO telefones_funcionarios VALUES ('$idFuncionario','$idTelefone')");
				}

				if($this->db->rowCount() > 0)
					$this->nUpdates++;
			}
		}


	}



	/**
 	 * Atualiza ou insere os emails
 	 * @return void
 	 */
	private function atualizaEmails(funcionariosModel $funcionario)
	{
		//excluir
		$emailExcluir = array();
		foreach ($funcionario->getEmail() as $email)
		{
			if($email->getId() != '')
				array_push($emailExcluir,$email->getId());
		}
		$cond = '';
		if(!empty($emailExcluir))
		{
			$emailExcluir = implode(',', $emailExcluir);
			$this->db->clear();
			$cond = " AND id_email not in (".$emailExcluir.")";
		}

		$sql = "DELETE FROM emails WHERE id_email in( SELECT B.id_email FROM emails_funcionarios AS B WHERE B.id_funcionario = '".$funcionario->getId()."' AND id_email = B.id_email) $cond";
		$this->db->query($sql);


		$this->db->clear();
		$this->db->setTabela('emails');
		foreach ($funcionario->getEmail() as $emails)
		{
			if(!empty($emails))
			{
				$data = array(
					'tipo_email' => $emails->getTipo(),
					'endereco_email' => $emails->getEmail()
				);

				if($emails->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_email = "'.$emails->getId().'"');
					$this->db->update($data);
				}else{
					$this->db->insert($data);
					$idEmail = $this->db->getUltimoId();
					$idFuncionario = $funcionario->getId();
					$this->db->query("INSERT INTO emails_funcionarios VALUES ('$idFuncionario','$idEmail')");
				}

				if($this->db->rowCount() > 0)
					$this->nUpdates++;
			}
		}
	}


	/**
 	 * Atualiza o status
 	 * @return boolean
 	 */
	public function atualizarStatus(funcionariosModel $funcionario)
	{
		try {
			$this->db->clear();
			$this->db->setTabela('funcionarios');
			$this->db->setCondicao("id_funcionario = ?");
			$this->db->setParameter(1, $funcionario->getId());
			$data = array('status_funcionario'=>$funcionario->getStatus());
			if($this->db->update($data))
				return true;
			else
				return false;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
	}

}