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
	public function adiarCompromissos(agendaModel $agendaModel)
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
					foreach ($res as $e) {
						$this->sendMail($e['endereco_email'], $agendaModel->getData());
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



	private function sendMail($emailPara, $novadata)
	{
		$dataFormat = new dataFormat();
		$novadata = $dataFormat->formatar($novadata, 'data');
		$corpo = utf8_decode('<table border=0 cellpacing=0 cellpadding=0 style="border:1px solid #CCC"> <thead> <tr> <th><img src=skin/img/imagens/topo_email.png> <tbody> <tr> <td> <h3 style=margin:0;font-size:23px;color:#FFF;background-color:#008fd4;padding:8px;text-align:center;font-family:monospace>Informativo importante</h3> <tr> <td style=font-family:monospace;font-size:14px;padding:5px> <p>A data de visita foi alterada, verifique a nova data</p><p>Nova data agendada: '.$novadata.'</p><p>Em caso de dúvidas entre em contato. (11) 1234-5678</p><tr> <td style=padding:0;background-color:#024D82> <p style=margin:5px;color:#FFF><small>Start Softwares - Prysmarket</small> </table>');
		$mail = new PHPMailer(); // instancia a classe PHPMailer
		$mail->IsSMTP();

		//configuração do gmail
		$mail->Port = '465'; //porta usada pelo gmail.
		$mail->Host = 'smtp.gmail.com'; 
		$mail->IsHTML(true); 
		$mail->Mailer = 'smtp'; 
		$mail->SMTPSecure = 'ssl';

		//configuração do usuário do gmail
		$mail->SMTPAuth = true;
		$mail->Username = 'prysmarket@gmail.com'; // usuario gmail.   
		$mail->Password = 'prysmarket123'; // senha do email.

		$mail->SingleTo = true; 

		// configuração do email a ver enviado.
		$mail->From = "prysmarket@gmail.com";
		$mail->FromName = "Prysmarket"; 

		$mail->addAddress($emailPara); // email do destinatario.

		$mail->Subject = utf8_decode("Mudança de Data Agendada"); 
		$mail->Body = $corpo;

		$mail->IsHTML(true); 
		if(!$mail->Send())
		    echo "Erro ao enviar Email:" . $mail->ErrorInfo;
	}


}