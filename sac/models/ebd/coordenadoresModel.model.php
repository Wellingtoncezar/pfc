<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class coordenadoresModel extends Controller{
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
		$this->query("SELECT * FROM coordenadores_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.status_coordenador_ebd $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}

	public function getCoordenador()
	{
		$this->clear();
		$this->query("SELECT A.*, B.nome_membro,B.sobrenome_membro, B.foto_membro FROM coordenadores_ebd AS A INNER JOIN membros AS B ON A.id_membro = B.id_membro WHERE A.id_coordenador_ebd = '".$this->id."'");
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
			'data_inicio_coordenador_ebd' => $this->dataInicio,
			'data_fim_coordenador_ebd' => $this->dataFim,
			'status_coordenador_ebd' => 'Inativo',
			'data_cadastro_coordenador' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('coordenadores_ebd');
		$this->insert($data);


		if($this->rowCount() > 0)
		{
			return true;
		}else
		{
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
			'data_inicio_coordenador_ebd' => $this->dataInicio,
			'data_fim_coordenador_ebd' => $this->dataFim
		);
		$this->clear();
		$this->setTabela('coordenadores_ebd');
		$this->setCondicao('id_coordenador_ebd = "'.$this->id.'"');
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
			'status_coordenador_ebd' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('coordenadores_ebd');
		$this->setCondicao('id_coordenador_ebd = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}