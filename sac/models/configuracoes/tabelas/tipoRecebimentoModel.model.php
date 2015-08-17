<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipoRecebimentoModel extends Controller{
	private $id;
	private $letra;
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
	public function setLetra($letra)
	{
		$this->letra = $letra;
	}

	/**
	*Retorna a lista de estado civil
	*/
	public function listar($condicao = "status_tipo_recebimento <> 'Excluido'")
	{
		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->setCondicao($condicao);
		$this->select();
		$tipo_recebimento = $this->resultAll();
		return $tipo_recebimento;
	}

	public function getTipoRecebimento($id)
	{
		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->setCondicao("id_tipo_recebimento = '".$id."'");
		$this->select();
		$tipo_recebimento = $this->result();
		return $tipo_recebimento;
	}


	public function inserir()
	{
		$data = array(
			'letra_tipo_recebimento' => filter_var($this->letra), 
			'nome_tipo_recebimento' => filter_var($this->nome),
			'status_tipo_recebimento' => filter_var($this->status),
			'data_cadastro_tipo_recebimento' => date('Y-m-d H:i:s')
		);

		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->insert($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}



	public function atualizar()
	{
		$data = array(
			'letra_tipo_recebimento' => filter_var($this->letra), 
			'nome_tipo_recebimento' => filter_var($this->nome),
			'status_tipo_recebimento' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->setCondicao('id_tipo_recebimento = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_tipo_recebimento' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->setCondicao('id_tipo_recebimento = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function deletar()
	{
		$this->clear();
		$this->setTabela('tipo_recebimento');
		$this->setCondicao('id_tipo_recebimento="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	
}

/**
*
*class: tipoRecebimentoModel
*
*location : models/configuracoes/tabelas/tipoRecebimentoModel.model.php
*/