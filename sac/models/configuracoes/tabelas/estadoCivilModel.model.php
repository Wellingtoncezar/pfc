<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class estadoCivilModel extends Controller{
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
			$status = ' AND status_estado_civil = "Ativo"';

		$this->clear();
		$this->setTabela('estado_civil');
		$this->setCondicao("status_estado_civil <> 'Excluido' $status");
		$this->select();
		$estado_civil = $this->resultAll();
		return $estado_civil;
	}

	public function getEstadoCivil($id)
	{
		$this->clear();
		$this->setTabela('estado_civil');
		$this->setCondicao("id_estado_civil = '".$id."'");
		$this->select();
		$estado_civil = $this->result();
		return $estado_civil;
	}


	public function inserir()
	{
		$data = array(
			'nome_estado_civil' => filter_var($this->nome),
			'status_estado_civil' => filter_var($this->status),
			'data_cadastro' => date('Y-m-d H:i:s')
		);

		$this->clear();
		$this->setTabela('estado_civil');
		$this->insert($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	public function atualizar()
	{
		$data = array(
			'nome_estado_civil' => filter_var($this->nome),
			'status_estado_civil' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('estado_civil');
		$this->setCondicao('id_estado_civil = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_estado_civil' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('estado_civil');
		$this->setCondicao('id_estado_civil = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function deletar()
	{
		$this->clear();
		$this->setTabela('estado_civil');
		$this->setCondicao('id_estado_civil="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	
}

/**
*
*class: estadoCivilModel
*
*location : models/configuracoes/tabelas/estadoCivilModel.model.php
*/