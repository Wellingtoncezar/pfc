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
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('funcionarios/cargosModel');
		
		$funcionarios = Array();

		$this->db->clear();
		$this->db->setTabela('funcionarios AS A, cargos AS B');
		$this->db->setCondicao(" A.status_funcionario in('".status::ATIVO."','".status::INATIVO."') ");
		$campos = array('A.id_funcionario','A.codigo_funcionario','A.foto_funcionario','A.nome_funcionario','A.sobrenome_funcionario','B.nome_cargo','B.setor_cargo','A.cpf_funcionario','A.status_funcionario', 'A.timestamp');
		$this->db->select($campos);
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
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

				//cargo
				$cargo = new cargosModel();
				$cargo->setNome($value['nome_cargo']);
				$cargo->setSetor($value['setor_cargo']);
				$funcionariosModel->setCargo($cargo);

				array_push($funcionarios, $funcionariosModel);
				unset($funcionariosModel);
			}
			return $funcionarios;
		else:
			return $funcionarios;
		endif;
	}


	/**
	 * Retorna a consulta de um funcionário pelo id
	 * @return object [funcionariosModel]
	 */
	public function consultar(funcionariosModel $funcionario)
	{
		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
		$this->db->select();


		//FUNCIONARIO
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			//TELEFONES
			$this->db->clear();
			$this->db->setTabela('telefones AS A, telefones_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = '".$funcionario->getId()."' AND A.id_telefone = B.id_telefone");
			$this->db->select();
			

			if($this->db->rowCount() > 0):
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
					$funcionario->setTelefones($telefoneModel);
				}
			endif;


			//EMAILS
			$this->db->clear();
			$this->db->setTabela('emails as A, emails_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = ? AND B.id_email = A.id_email");
			$this->db->setParameter(1, $funcionario->getId());
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
					$funcionario->setEmail($emailModel);
				}
			endif;


			//ENDERECO
			$this->db->clear();
			$this->db->setTabela('enderecos as A, enderecos_funcionarios AS B');
			$this->db->setCondicao("B.id_funcionario = '".$funcionario->getId()."' AND A.id_endereco = B.id_endereco ");
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
	 * @return boolean, json
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
		$this->db->insert($data);
		
		if($this->db->rowCount() > 0)
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

	}

	/**
	 * Atualiza funcionários
	 * @return boolean, json
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

 		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount() > 0)
			$this->nUpdates++;
		
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
 	 * @return void
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

		if($this->db->rowCount() > 0)
			$this->nUpdates++;
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
		$data = array('status_funcionario'=>$funcionario->getStatus());
		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


	/**
 	 * faz o upload do arquivo
 	 * @return boolean, String
 	 */
	public function uploadFoto($nomeArquivo, $arquivo)
	{

		//verifica se o diretório existe
		if(is_dir(BASEPATH.'skin/uploads/funcionarios/'))
		{
			$destino = BASEPATH.'skin/uploads/funcionarios/';
			$destino_p = BASEPATH.'skin/uploads/funcionarios/p/';

			if(!is_dir($destino))
				mkdir($destino);

			if(!is_dir($destino_p))
				mkdir($destino_p);

			$img = new upload($arquivo,$destino, $nomeArquivo);
			
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


}