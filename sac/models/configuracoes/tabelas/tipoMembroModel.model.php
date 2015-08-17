<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipoMembroModel extends Controller{
	private $id;
	private $nome;
	private $status;

	public function __construct(){
		parent::__construct();
	}
	
	public function setId($id){
		$this->id = $id;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}
	public function setStatus($status)
	{
		$this->status = $status;
	}

	/**
	*Retorna a lista de estado civil
	*/
	public function listar($condicao = "status_tipo_membro <> 'Excluido'")
	{
		$this->clear();
		$this->setTabela('tipo_membro');
		$this->setCondicao($condicao);
		$this->select();
		$tipo_membro = $this->resultAll();
		return $tipo_membro;
	}

	public function getTipoMembro($id)
	{
		$this->clear();
		$this->setTabela('tipo_membro');
		$this->setCondicao("id_tipo_membro = '".$id."'");
		$this->select();
		$tipo_membro = $this->result();
		return $tipo_membro;
	}


	public function inserir()
	{
		$data = array(
			'nome_tipo_membro' => filter_var($this->nome),
			'status_tipo_membro' => filter_var($this->status),
			'data_cadastro_tipo_membro' => date('Y-m-d H:i:s')
		);

		$this->clear();
		$this->setTabela('tipo_membro');
		$this->insert($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	public function atualizar()
	{
		$data = array(
			'nome_tipo_membro' => filter_var($this->nome),
			'status_tipo_membro' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_membro');
		$this->setCondicao('id_tipo_membro = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_tipo_membro' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_membro');
		$this->setCondicao('id_tipo_membro = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function deletar()
	{
		$this->clear();
		$this->setTabela('tipo_membro');
		$this->setCondicao('id_tipo_membro="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	
}

/**
*
*class: tipoMembroModel
*
*location : models/configuracoes/tabelas/tipoMembroModel.model.php
*/