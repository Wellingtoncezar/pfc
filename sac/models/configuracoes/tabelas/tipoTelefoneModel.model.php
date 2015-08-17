<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipoTelefoneModel extends Controller{
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
	public function listar($status = '')
	{
		if($status != '')
			$status = ' AND status_tipo_telefone = "Ativo"';

		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->setCondicao("status_tipo_telefone <> 'Excluído' $status");
		$this->select();
		$tipo_telefone = $this->resultAll();
		return $tipo_telefone;
	}

	public function getTipoTelefone($id)
	{
		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->setCondicao("id_tipo_telefone = '".$id."'");
		$this->select();
		$tipo_telefone = $this->result();
		return $tipo_telefone;
	}


	public function inserir()
	{
		$data = array(
			'nome_tipo_telefone' => filter_var($this->nome),
			'status_tipo_telefone' => filter_var($this->status),
			'data_cadastro_tipo_telefone' => date('Y-m-d H:i:s')
		);

		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->insert($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	public function atualizar()
	{
		$data = array(
			'nome_tipo_telefone' => filter_var($this->nome),
			'status_tipo_telefone' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->setCondicao('id_tipo_telefone = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_tipo_telefone' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->setCondicao('id_tipo_telefone = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function deletar()
	{
		$this->clear();
		$this->setTabela('tipo_telefone');
		$this->setCondicao('id_tipo_telefone="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	
}

/**
*
*class: tipoTelefoneModel
*
*location : models/configuracoes/tabelas/tipoTelefoneModel.model.php
*/