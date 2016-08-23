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
			$cond = "'".$ano."-".$mes."-".$dia."%'";
		elseif($mes != null)
			$cond = "'".$ano."-".$mes."%'";
		else
			$cond = "'".$ano."%'";
		
		$this->db->clear();
		$this->db->setTabela('fornecedores_agenda AS  FA, fornecedores AS F');
		$this->db->setCondicao("FA.data_agenda like $cond AND FA.id_fornecedor = F.id_fornecedor");
		$this->db->setOrderBy('FA.data_agenda');
		$this->db->select();
		$agendasList = array();
		if($this->db->rowCount() > 0)
		{
			$agendas = $this->db->resultAll();
			//AGENDA MODEL
			$this->load->model('agenda/agendaModel');

			//FORNECEDORES MODEL
			$this->load->model('fornecedores/fornecedoresModel');

			foreach ($agendas as $agenda)
			{
				$fornecedorModel = new fornecedoresModel();
				$fornecedorModel->setId($agenda['id_fornecedor']);
				$fornecedorModel->setNomeFantasia($agenda['nome_fantasia_fornecedor']);

				$agendaModel = new agendaModel();
				$agendaModel->setId($agenda['id_fornecedor_agenda']);
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

	
	public function getDataNotificar()
	{
		$this->db->clear();
		$this->db->query("SELECT * FROM fornecedores_agenda AS A 
			INNER JOIN fornecedores AS B ON A.data_agenda between curdate() AND DATE_ADD(curdate(),INTERVAL 30 DAY) AND A.id_fornecedor=B.id_fornecedor 
			ORDER BY A.data_agenda");
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
		
				$this->db->clear();
				$this->db->setTabela('fornecedores_agenda_notificado');
				$this->db->setCondicao("curdate() = data_notificacao AND id_fornecedor_agenda = '".$agenda['id_fornecedor_agenda']."'");
				$this->db->select();
				if($this->db->rowCount() == 0):
					$values = array(
						'data_notificacao' => date('Y-m-d'),
						'id_fornecedor_agenda' => $agenda['id_fornecedor_agenda'],
					);
					$this->db->insert($values);

					//LEFT JOIN fornecedores_agenda_notificado AS C ON 
					$fornecedorModel = new fornecedoresModel();
					$fornecedorModel->setId($agenda['id_fornecedor']);
					$fornecedorModel->setNomeFantasia($agenda['nome_fantasia_fornecedor']);
					$fornecedorModel->setNomeFantasia($agenda['nome_fantasia_fornecedor']);

					$agendaModel = new agendaModel();
					$agendaModel->setTitulo($agenda['titulo_agenda']);
					$agendaModel->setData($agenda['data_agenda']);
					$agendaModel->setObservacoes($agenda['observacoes_agenda']);
					$agendaModel->setDataCadastro($agenda['data_cadastro_agenda']);
					$agendaModel->setFornecedor($fornecedorModel);
					array_push($agendasList, $agendaModel);
					unset($agendaModel);
				endif;

			}
 		}
 		return $agendasList;
	}
	public function adiarCompromissos($agendaModel)
	{
		try {
			$this->db->clear();
			$this->db->setTabela('fornecedores_agenda');
			$this->db->setCondicao("id_fornecedor_agenda = ?");
			$this->db->setParameter(1,$agendaModel->getId());
			if($this->db->update(array('data_agenda'=>$agendaModel->getData()))){
				
				//selecionando o email do fornecedor 
				$this->db->clear();
				$this->db->setTabela('fornecedores as A, fornecedores_agenda as B, emails_fornecedores as C, emails as D');
				$this->db->setCondicao("B.id_fornecedor_agenda = ? AND B.id_fornecedor = A.id_fornecedor AND A.id_fornecedor = C.id_fornecedor AND C.id_email = D.id_email");
				$this->db->setParameter(1,$agendaModel->getId());
				if($this->db->select())
				{
					$res = $this->db->resultAll();
					foreach ($variable as $key => $value) {
						$email = new email();
						$email->de('prysmarket@gmail.com');
						$email->para($res['endereco_email']);
						$email->mensagem('teste');
						$email->send();
					}
				}



				return true;
			}else{
				return $this->db->getError();
			}
		} catch (Exception $e) {
			return $e->getMessageError();
		}

	}


}