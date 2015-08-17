<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class secretariaModel extends Controller{
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
		$this->query("SELECT * FROM secretaria_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.status_secretaria_ebd $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}

	public function getsecretaria()
	{
		$this->clear();
		$this->query("SELECT A.*, B.nome_membro,B.sobrenome_membro, B.foto_membro FROM secretaria_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.id_secretaria_ebd = '".$this->id."'");
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
			'data_inicio_secretaria_ebd' => $this->dataInicio,
			'data_fim_secretaria_ebd' => $this->dataFim,
			'status_secretaria_ebd' => 'Inativo',
			'data_cadastro_secretaria' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('secretaria_ebd');
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
			'data_inicio_secretaria_ebd' => $this->dataInicio,
			'data_fim_secretaria_ebd' => $this->dataFim
		);
		$this->clear();
		$this->setTabela('secretaria_ebd');
		$this->setCondicao('id_secretaria_ebd = "'.$this->id.'"');
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
			'status_secretaria_ebd' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('secretaria_ebd');
		$this->setCondicao('id_secretaria_ebd = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}