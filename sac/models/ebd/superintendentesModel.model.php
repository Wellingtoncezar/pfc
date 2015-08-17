<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class superintendentesModel extends Controller{
	private $id;
	private $membro;
	private $dataInicio;
	private $dataFim;
	private $status;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setMembro($membro)
	{
		$this->membro = $membro;
	}

	public function setDataInicio($dataInicio)
	{
		$this->dataInicio = $dataInicio;
	}
	public function setDataFim($dataFim)
	{
		$this->dataFim = $dataFim;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}


	public function listar($condicao = '<>', $valor = 'Excluído')
	{
		$this->clear();
		$this->query("SELECT * FROM superintendente_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.status_superintendente_ebd $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}

	public function getSuperintendente()
	{
		$this->clear();
		$this->query("SELECT A.*, B.nome_membro,B.sobrenome_membro, B.foto_membro FROM superintendente_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.id_superintendente_ebd = '".$this->id."'");
		if($this->rowCount() > 0){
			return $this->result();
		}else{
			return false;
		}
	}

	
	public function inserir()
	{
		$dataFormat = new dataFormat();
		$this->dataInicio = $dataFormat->formatar($this->dataInicio,'data','banco');
		$this->dataFim = $dataFormat->formatar($this->dataFim,'data','banco');


		$data = array(
			'id_membro' => $this->membro,
			'data_inicio_superintendente_ebd' => $this->dataInicio,
			'data_fim_superintendente_ebd' => $this->dataFim,
			'status_superintendente_ebd' => 'Inativo',
			'data_cadastro_superintendente' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('superintendente_ebd');
		$this->insert($data);


		if($this->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function atualizar()
	{
		$dataFormat = new dataFormat();
		$this->dataInicio = $dataFormat->formatar($this->dataInicio,'data','banco');
		$this->dataFim = $dataFormat->formatar($this->dataFim,'data','banco');


		$data = array(
			'id_membro' => $this->membro,
			'data_inicio_superintendente_ebd' => $this->dataInicio,
			'data_fim_superintendente_ebd' => $this->dataFim
		);
		$this->clear();
		$this->setTabela('superintendente_ebd');
		$this->setCondicao('id_superintendente_ebd = "'.$this->id.'"');
		$this->update($data);


		if($this->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}	



	
	//atualizarStatus
	public function atualizarStatus()
	{
		$data = array(
			'status_superintendente_ebd' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('superintendente_ebd');
		$this->setCondicao('id_superintendente_ebd = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}