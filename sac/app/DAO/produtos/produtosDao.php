<?php
/**
 * Classe DAO de Produtos
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtosDao extends Dao{
	private $nomeArquivoFoto;
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos produtos
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('produtos/produtosModel');
		$produtos = Array();

		$this->db->clear();
		$this->db->setTabela('produtos');
		$this->db->setCondicao(" status_produto in('".status::ATIVO."','".status::INATIVO."') ");
		$campos = array('id_funcionario','codigo_funcionario','foto_funcionario','nome_funcionario','sobrenome_funcionario','cargo_funcionario','cpf_funcionario','status_funcionario');
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
				$funcionariosModel->setCargo($value['cargo_funcionario']);
				$funcionariosModel->setStatus(status::getAttribute($value['status_funcionario']));
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
			$this->db->setTabela('telefones');
			$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
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
			$this->db->setTabela('emails');
			$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
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
			$this->db->setTabela('enderecos');
			$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
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
			$funcionario->setTelefones($telefonesList);
			$funcionario->setEmail($emailsList);
			$funcionario->setCodigo($result['codigo_funcionario']);
			$funcionario->setCargo($result['cargo_funcionario']);
			$funcionario->setDataAdmissao($result['data_admissao_funcionario']);
			$funcionario->setSalario($result['salario_funcionario']);
			$funcionario->setStatus(status::getAttribute($result['status_funcionario']));
			return $funcionario;
		else:
			
			return $funcionariosModel;
		endif;
	}



	/**
	 * Insere novos funcionários
	 * @return boolean, json
	 */
 	public function inserir(funcionariosModel $funcionario)
 	{
 		

		if($funcionario->getFoto() != '')
		{
	 		//nome da imagem
			$char = new caracteres($funcionario->getNome());
			$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			
			$upload = $this->uploadFoto($this->nomeArquivoFoto, $funcionario->getFoto()); //upload da foto
			if($upload)
				return $this->insertData($funcionario);
			else
				return $upload;
		}else
		{
			return $this->insertData($funcionario);
		}

	}

	/**
	 * Atualiza funcionários
	 * @return boolean, json
	 */
 	public function atualizar(funcionariosModel $funcionario)
 	{

		if($funcionario->getFoto() != '')
		{
	 		$this->db->clear();
	 		$this->db->setTabela('funcionarios');
	 		$this->db->setCondicao("id_funcionario = '".$funcionario->getId()."'");
	 		$this->db->select(array('foto_funcionario'));
	 		$res = $this->db->result();
	 		$this->nomeArquivoFoto = pathinfo($res['foto_funcionario'],PATHINFO_FILENAME);
			if($this->nomeArquivoFoto == '')
			{
		 		//nome da imagem
				$char = new caracteres($funcionario->getNome());
				$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			}
				
			$upload = $this->uploadFoto($this->nomeArquivoFoto, $funcionario->getFoto()); //upload da foto
			if($upload)
				return $this->updateData($funcionario);
			else
				return $upload;
		}else
		{
			return $this->updateData($funcionario);
		}

	}


	private function insertData(funcionariosModel $funcionario)
	{

 		$data = array(
 			'foto_funcionario' => $this->nomeArquivoFoto,
 			'nome_funcionario' => $funcionario->getNome(),
 			'sobrenome_funcionario' => $funcionario->getSobrenome(),
 			'data_nascimento_funcionario' => $funcionario->getDataNascimento(),
 			'sexo_funcionario' => $funcionario->getSexo(),
 			'rg_funcionario' => $funcionario->getRg(),
 			'cpf_funcionario' => $funcionario->getCpf(),
 			'estado_civil_funcionario' => $funcionario->getEstadoCivil(),
 			'escolaridade_funcionario' => $funcionario->getEscolaridade(),
 			'codigo_funcionario' => $funcionario->getCodigo(),
 			'cargo_funcionario' => $funcionario->getCargo(),
 			'data_admissao_funcionario' => $funcionario->getDataAdmissao(),
 			'salario_funcionario' => $funcionario->getSalario(),
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
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
 		}
 		
 	}

 	private function updateData(funcionariosModel $funcionario)
	{

 		$data = array(
 			'foto_funcionario' => $this->nomeArquivoFoto,
 			'nome_funcionario' => $funcionario->getNome(),
 			'sobrenome_funcionario' => $funcionario->getSobrenome(),
 			'data_nascimento_funcionario' => $funcionario->getDataNascimento(),
 			'sexo_funcionario' => $funcionario->getSexo(),
 			'rg_funcionario' => $funcionario->getRg(),
 			'cpf_funcionario' => $funcionario->getCpf(),
 			'estado_civil_funcionario' => $funcionario->getEstadoCivil(),
 			'escolaridade_funcionario' => $funcionario->getEscolaridade(),
 			'codigo_funcionario' => $funcionario->getCodigo(),
 			'cargo_funcionario' => $funcionario->getCargo(),
 			'data_admissao_funcionario' => $funcionario->getDataAdmissao(),
 			'salario_funcionario' => $funcionario->getSalario(),
 			'status_funcionario' => $funcionario->getStatus(),
 			'data_cadastro_funcionario' => $funcionario->getDataCadastro()
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
			'id_funcionario' => $funcionario->getId(),
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
		}else
			$this->db->insert($data);

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
		$sql = "DELETE FROM telefones WHERE id_funcionario = '".$funcionario->getId()."' $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('telefones');
		foreach ($funcionario->getTelefones() as $telefones)
		{
			if(!empty($telefones))
			{
				$data = array(
					'id_funcionario' => $funcionario->getId(),
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
		$sql = "DELETE FROM emails WHERE id_funcionario = '".$funcionario->getId()."' $cond";
		$this->db->query($sql);


		$this->db->clear();
		$this->db->setTabela('emails');
		foreach ($funcionario->getEmail() as $emails)
		{
			if(!empty($emails))
			{
				$data = array(
					'id_funcionario' => $funcionario->getId(),
					'tipo_email' => $emails->getTipo(),
					'endereco_email' => $emails->getEmail()
				);

				if($emails->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_email = "'.$emails->getId().'"');
					$this->db->update($data);
				}else
					$this->db->insert($data);

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