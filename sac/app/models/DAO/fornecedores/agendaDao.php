<?php
/**
 * Classe DAO de agenda
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class agendaDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	/**
	 * retorna a lista de agendamento do ano selecionado
	 * @return array
	 */
	public function listar($ano, $mes = null, $dia = null)
	{
		if($dia != null)
			$cond = "'".$ano."-".$mes."-".$dia."'%";
		elseif($mes != null)
			$cond = "'".$ano."-".$mes."'%";
		else
			$cond = "'".$ano."%'";
		
		$this->db->clear();
		$this->db->setTabela('fornecedores_agenda');
		$this->db->setCondicao("data_agenda like $cond");
		$this->db->select();
		$agendasList = array();
		if($this->db->rowCount() > 0)
		{
			$agendas = $this->db->resultAll();
			//AGENDA MODEL
			$this->load->model('fornecedores/agendaModel');

			//FORNECEDORES MODEL
			$this->load->model('fornecedores/fornecedoresModel');

			foreach ($agendas as $agenda)
			{
				$fornecedorModel = new fornecedoresModel();
				$fornecedorModel->setId($agenda['id_fornecedor']);

				$agendaModel = new agendaModel();
				$agendaModel->setTitulo($agenda['titulo_agenda']);
				$agendaModel->setData($agenda['data_agenda']);
				$agendaModel->setObservacoes($agenda['observacoes_agenda']);
				$agendaModel->setDataCadastro($agenda['data_cadastro_agenda']);
				$agendaModel->setFornecedor($fornecedorModel);
				array_push($agendasList, $agendaModel);
				unset($agendaModel);
			}
 		}
 		return $agendasList;
	}



	
	/**
	 * Insere novas agenda
	 * @return boolean, json
	 */
 	public function inserir(agendaModel $agenda)
 	{
 		$data = array(
 			'id_fornecedor' => $agenda->getFornecedor()->getId(),
 			'titulo_agenda' => $agenda->getTitulo(),
 			'observacoes_agenda' => $agenda->getObservacoes(),
 			'data_agenda' => $agenda->getData(),
 			'data_cadastro_agenda' => $agenda->getDataCadastro()
 		);


 		$this->db->clear();
		$this->db->setTabela('fornecedores_agenda');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
		{
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

		if($fornecedor->getFoto() != '')
		{
	 		$this->db->clear();
	 		$this->db->setTabela('fornecedores');
	 		$this->db->setCondicao("id_fornecedor = '".$fornecedor->getId()."'");
	 		$this->db->select(array('foto_fornecedor'));
	 		$res = $this->db->result();
	 		$this->nomeArquivoFoto = pathinfo($res['foto_fornecedor'],PATHINFO_FILENAME);
			if($this->nomeArquivoFoto == '')
			{
		 		//nome da imagem
				$char = new caracteres($fornecedor->getNomeFantasia());
				$this->nomeArquivoFoto = $char->getValor().'_'.date('HisdmY').'';
			}
				
			$upload = $this->uploadFoto($this->nomeArquivoFoto, $fornecedor->getFoto()); //upload da foto
			if($upload)
				return $this->updateData($fornecedor);
			else
				return $upload;
		}else
		{
			return $this->updateData($fornecedor);
		}

	}


 	private function updateData(fornecedoresModel $fornecedor)
	{

 		$data = array(
 			'foto_fornecedor' => $this->nomeArquivoFoto,
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
			'id_fornecedor' => $fornecedor->getId(),
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
		$sql = "DELETE FROM telefones WHERE id_fornecedor = '".$fornecedor->getId()."' $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('telefones');
		foreach ($fornecedor->getTelefones() as $telefones)
		{
			if(!empty($telefones))
			{

				$data = array(
					'id_fornecedor' => $fornecedor->getId(),
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
		$sql = "DELETE FROM emails WHERE id_fornecedor = '".$fornecedor->getId()."' $cond";
		$this->db->query($sql);


		$this->db->clear();
		$this->db->setTabela('emails');
		foreach ($fornecedor->getEmail() as $emails)
		{
			if(!empty($emails))
			{
				$data = array(
					'id_fornecedor' => $fornecedor->getId(),
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