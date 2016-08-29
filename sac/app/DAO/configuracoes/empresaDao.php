<?php
/**
 * Classe DAO de empresa
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class empresaDao extends Dao{
	private $nomeArquivoFoto;
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Retorna a consulta de um empresa pelo id
	 * @return object [empresaModel]
	 */
	public function consultar(empresaModel $empresa)
	{
		$this->db->clear();
		$this->db->setTabela('dadosempresa');
		$this->db->setCondicao("id_empresa = '".$empresa->getId()."'");
		$this->db->select();

		//fornecedor
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$empresa->setLogo($result['foto_empresa']);
			$empresa->setRazaoSocial($result['razao_social_empresa']);
			$empresa->setNomeFantasia($result['nome_fantasia_empresa']);
			$empresa->setCnpj($result['cnpj_empresa']);
			$empresa->setProprietario($result['pessoa_empresa']);
			$empresa->setSite($result['site_empresa']);
			$empresa->setObservacoes($result['observacoes_empresa']);
			$empresa->setNomeContato($result['nome_contato_empresa']);
			$empresa->setEndereco($endereco);
			$empresa->setTelefones($telefonesList);
			$empresa->setEmails($emailsList);
			$empresa->setDataVisita($result['data_visita_empresa']);
			$empresa->setRetorno($result['retorno_empresa']);
			$empresa->setStatus(status::getAttribute($result['status_empresa']));
			return $empresa;
		else:
			
			return $fornecedoresModel;
		endif;
	}



	/**
	 * Insere novos fornecedores
	 * @return boolean, json
	 */
 	public function inserir(fornecedoresModel $fornecedores)
 	{
		$data = array(
 			'foto_fornecedor' => $fornecedores->getFoto(),
 			'razao_social_fornecedor' => $fornecedores->getRazaoSocial(),
 			'nome_fantasia_fornecedor' => $fornecedores->getNomeFantasia(),
 			'cnpj_fornecedor' => $fornecedores->getCnpj(),
 			'cpf_fornecedor' => $fornecedores->getCpf(),
 			'pessoa_fornecedor' => $fornecedores->getPessoa(),
 			'site_fornecedor' => $fornecedores->getSite(),
 			'observacoes_fornecedor' => $fornecedores->getObservacoes(),
 			'nome_contato_fornecedor' => $fornecedores->getNomeContato(),
 			'status_fornecedor' => $fornecedores->getStatus(),
 			'data_cadastro_fornecedor' => $fornecedores->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('fornecedores');
		try {
			if($this->db->insert($data))
			{
				$fornecedores->setId($this->db->getUltimoId()); //RETORNA O ID INSERIDO
				$this->atualizaEndereco($fornecedores);
				//TELEFONES
				if(!empty($fornecedores->getTelefones()))
				 	$this->atualizaTelefones($fornecedores);

				//EMAILS
				if(!empty($fornecedores->getEmail()))
				 	$this->atualizaEmails($fornecedores);
				//echo 'inserido';
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
	 * Atualiza fornecedores
	 * @return boolean, json
	 */
 	public function atualizar(fornecedoresModel $fornecedor)
 	{
		$data = array(
 			'foto_fornecedor' => $fornecedor->getFoto(),
 			'razao_social_fornecedor' => $fornecedor->getRazaoSocial(),
 			'nome_fantasia_fornecedor' => $fornecedor->getNomeFantasia(),
 			'cnpj_fornecedor' => $fornecedor->getCnpj(),
 			'cpf_fornecedor' => $fornecedor->getCpf(),
 			'pessoa_fornecedor' => $fornecedor->getPessoa(),
 			'site_fornecedor' => $fornecedor->getSite(),
 			'observacoes_fornecedor' => $fornecedor->getObservacoes(),
 			'nome_contato_fornecedor' => $fornecedor->getNomeContato()
 		);

		try {
	 		$this->db->clear();
			$this->db->setTabela('fornecedores');
			$this->db->setCondicao("id_fornecedor = ?");
			$this->db->setParameter(1, $fornecedor->getId());

			if($this->db->update($data))
				$this->nUpdates++;
			
			//ENDEREÇO
			$this->atualizaEndereco($fornecedor);
			//TELEFONES
			$this->atualizaTelefones($fornecedor);
			//EMAILS
			$this->atualizaEmails($fornecedor);

	 		if($this->nUpdates > 0)
				return true;
	 		else
	 		{
	 			return $this->db->getError();
	 		}
	 	} catch (dbException $e) {
			return $e->getMessageError();
		}

	}






 	/**
 	 * Atualiza ou insere o endereço
 	 * @return void
 	 * */
 	public function atualizaEndereco(fornecedoresModel $fornecedor)
 	{
 		try{
		 	$this->db->clear();
			$this->db->setTabela('enderecos');
			$data = array(
				'cep_endereco' => $fornecedor->getEndereco()->getCep(),
				'rua_endereco' => $fornecedor->getEndereco()->getLogradouro(),
				'numero_endereco' => $fornecedor->getEndereco()->getNumero(),
				'complemento_endereco' => $fornecedor->getEndereco()->getComplemento(),
				'bairro_endereco' => $fornecedor->getEndereco()->getBairro(),
				'cidade_endereco' => $fornecedor->getEndereco()->getCidade(),
				'estado_endereco' => $fornecedor->getEndereco()->getEstado(),
				'data_cadastro_endereco' => date('Y-m-d h:i:s')
			);
			

			if($fornecedor->getEndereco()->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
			{
				$this->db->setCondicao('id_endereco = "'.$fornecedor->getEndereco()->getId().'"');
				$this->db->update($data);
			}else
			{
				$this->db->insert($data);
				$idEndereco = $this->db->getUltimoId();
				$idFornecedor = $fornecedor->getId();
				$this->db->query("INSERT INTO enderecos_fornecedores VALUES ('$idFornecedor','$idEndereco')");
			}

			if($this->db->rowCount() > 0)
				$this->nUpdates++;
			else
				return false;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
 	}



 	/**
 	 * 
 	 * Atualiza ou insere os telefones
 	 * @return void
 	 */
 	private function atualizaTelefones(fornecedoresModel $fornecedor)
	{

		//excluir
		$telefonesExcluir = array();
		foreach ($fornecedor->getTelefones() as $telefones)
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
		$sql = "DELETE FROM telefones WHERE id_telefone in( SELECT B.id_telefone FROM telefones_fornecedores AS B WHERE B.id_fornecedor = '".$fornecedor->getId()."' AND id_telefone = B.id_telefone) $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('telefones');
		foreach ($fornecedor->getTelefones() as $telefones)
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
					$idFornecedor = $fornecedor->getId();
					$this->db->query("INSERT INTO telefones_fornecedores VALUES ('$idFornecedor','$idTelefone')");
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
	private function atualizaEmails(fornecedoresModel $fornecedor)
	{
		//excluir
		$emailExcluir = array();
		foreach ($fornecedor->getEmail() as $email)
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
		$sql = "DELETE FROM emails WHERE id_email in( SELECT B.id_email FROM emails_fornecedores AS B WHERE B.id_fornecedor = '".$fornecedor->getId()."' AND id_email = B.id_email) $cond";
		$this->db->query($sql);


		$this->db->clear();
		$this->db->setTabela('emails');
		foreach ($fornecedor->getEmail() as $emails)
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
					$idFornecedor = $fornecedor->getId();
					$this->db->query("INSERT INTO emails_fornecedores VALUES ('$idFornecedor','$idEmail')");
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
	public function atualizarStatus(fornecedoresModel $fornecedor)
	{
		$data = array('status_fornecedor'=>$fornecedor->getStatus());
		$this->db->clear();
		$this->db->setTabela('fornecedores');
		$this->db->setCondicao("id_fornecedor = '".$fornecedor->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}

}