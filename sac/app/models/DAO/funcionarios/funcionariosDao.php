<?php
/**
 * Classe DAO de funcionários
 * @author Wellington cezar, Diego Hernandes, Jessica Azevedo
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosDao extends Dao{
	private $nomeArquivoFoto;
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
		$funcionarios = Array();

		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->setCondicao(" status_funcionario in('".status::ATIVO."','".status::INATIVO."') ");
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


	// public function consultar(funcionariosModel $funcionario)
	// {

	// }



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
			$this->db->setCondicao('id_telefone = "'.$funcionario->getEndereco()->getId().'"');
			$this->db->update($data);
		}else
			$this->db->insert($data);
 	}



 	/**
 	 * 
 	 * Atualiza ou insere os telefones
 	 * @return void
 	 */
 	private function atualizaTelefones(funcionariosModel $funcionario)
	{
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
				}else
					$this->db->insert($data);
			}
		}
	}



	/**
 	 * Atualiza ou insere os emails
 	 * @return void
 	 */
	private function atualizaEmails(funcionariosModel $funcionario)
	{
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