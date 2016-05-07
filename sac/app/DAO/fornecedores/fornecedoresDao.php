<?php
/**
 * Classe DAO de fornecedores
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class fornecedoresDao extends Dao{
	private $nomeArquivoFoto;
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos fornecedores
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('fornecedores/fornecedoresModel');
		$fornecedores = Array();

		$this->db->clear();
		$this->db->setTabela('fornecedores');
		$this->db->setCondicao(" status_fornecedor in('".status::ATIVO."','".status::INATIVO."') ");
		$campos = array('id_fornecedor','foto_fornecedor','nome_fantasia_fornecedor','razao_social_fornecedor','cpf_fornecedor','cnpj_fornecedor','status_fornecedor');
		$this->db->select($campos);
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$fornecedoresModel = new fornecedoresModel();
				$fornecedoresModel->setId($value['id_fornecedor']);
				$fornecedoresModel->setFoto($value['foto_fornecedor']);
				$fornecedoresModel->setNomeFantasia($value['nome_fantasia_fornecedor']);
				$fornecedoresModel->setRazaoSocial($value['razao_social_fornecedor']);
				$fornecedoresModel->setCpf($value['cpf_fornecedor']);
				$fornecedoresModel->setCnpj($value['cnpj_fornecedor']);
				$fornecedoresModel->setStatus(status::getAttribute($value['status_fornecedor']));
				array_push($fornecedores, $fornecedoresModel);
				unset($fornecedoresModel);
			}
			return $fornecedores;
		else:
			return $fornecedores;
		endif;
	}


	/**
	 * Retorna a consulta de um fornecedores pelo id
	 * @return object [fornecedoresModel]
	 */
	public function consultar(fornecedoresModel $fornecedor)
	{
		$this->db->clear();
		$this->db->setTabela('fornecedores');
		$this->db->setCondicao("id_fornecedor = '".$fornecedor->getId()."'");
		$this->db->select();

		//fornecedor
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			//TELEFONES
			$this->db->clear();
			$this->db->setTabela('telefones AS A, telefones_fornecedores AS B');
			$this->db->setCondicao("B.id_fornecedor = '".$fornecedor->getId()."' AND A.id_telefone = B.id_telefone");
			$this->db->select();
			
			$telefonesList = Array();
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
					$telefoneModel->setTipo( $telefone['tipo_telefone'] );
					array_push($telefonesList, $telefoneModel);
					unset($telefoneModel);
				}
			endif;


			//EMAILS
			$this->db->clear();
			$this->db->setTabela('emails as A, emails_fornecedores AS B');
			$this->db->setCondicao("B.id_fornecedor = '".$fornecedor->getId()."' AND B.id_email = A.id_email");
			$this->db->select();
			
			$emailsList = Array();
			if($this->db->rowCount() > 0):
				$resultEmail = $this->db->resultAll();

				$this->load->model('emailModel');
				foreach ($resultEmail as $email)
				{

					$emailModel = new emailModel();
					$emailModel->setId( $email['id_email'] );
					$emailModel->setEmail( $email['endereco_email'] );
					$emailModel->setTipo( $email['tipo_email'] );
					array_push($emailsList, $emailModel);
					unset($emailModel);
				}
			endif;


			//ENDERECO
			$this->db->clear();
			$this->db->setTabela('enderecos as A, enderecos_fornecedores AS B');
			$this->db->setCondicao("B.id_fornecedor = '".$fornecedor->getId()."' AND A.id_endereco = B.id_endereco ");
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

			$fornecedor->setFoto($result['foto_fornecedor']);
			$fornecedor->setRazaoSocial($result['razao_social_fornecedor']);
			$fornecedor->setNomeFantasia($result['nome_fantasia_fornecedor']);
			$fornecedor->setCnpj($result['cnpj_fornecedor']);
			$fornecedor->setCpf($result['cpf_fornecedor']);
			$fornecedor->setPessoa($result['pessoa_fornecedor']);
			$fornecedor->setSite($result['site_fornecedor']);
			$fornecedor->setObservacoes($result['observacoes_fornecedor']);
			$fornecedor->setNomeContato($result['nome_contato_fornecedor']);
			$fornecedor->setEndereco($endereco);
			$fornecedor->setTelefones($telefonesList);
			$fornecedor->setEmail($emailsList);
			$fornecedor->setDataVisita($result['data_visita_fornecedor']);
			$fornecedor->setRetorno($result['retorno_fornecedor']);
			$fornecedor->setStatus(status::getAttribute($result['status_fornecedor']));
			return $fornecedor;
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
 			'data_visita_fornecedor' => $fornecedores->getDataVisita(),
 			'retorno_fornecedor' => $fornecedores->getRetorno(),
 			'status_fornecedor' => $fornecedores->getStatus(),
 			'data_cadastro_fornecedor' => $fornecedores->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('fornecedores');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
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
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
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
 			'nome_contato_fornecedor' => $fornecedor->getNomeContato(),
 			'data_visita_fornecedor' => $fornecedor->getDataVisita(),
 			'retorno_fornecedor' => $fornecedor->getRetorno()
 		);

 		$this->db->clear();
		$this->db->setTabela('fornecedores');
		$this->db->setCondicao("id_fornecedor = '".$fornecedor->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount() > 0)
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
 			return json_encode(array('erro'=>'Erro ao editar registro'));
 		}

	}






 	/**
 	 * Atualiza ou insere o endereço
 	 * @return void
 	 * */
 	public function atualizaEndereco(fornecedoresModel $fornecedor)
 	{

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


	/**
 	 * faz o upload do arquivo
 	 * @return boolean, String
 	 */
	public function uploadFoto($nomeArquivo, $arquivo)
	{

		//verifica se o diretório existe
		if(is_dir(BASEPATH.'skin/uploads/fornecedores/'))
		{
			$destino = BASEPATH.'skin/uploads/fornecedores/';
			$destino_p = BASEPATH.'skin/uploads/fornecedores/p/';

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