<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class lixeiraModel extends Controller{
	private $id;
	private $nome;
	private $tabela;
	private $campo_status;
	private $campo_id;
	private $nome_campo_id;

	public function setId($id){
		$this->id = $id;
	}
	
	//listar
	public function listar(){
		$this->clear();
		$this->query("SELECT * FROM lixeira ORDER BY id_lixeira DESC");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}


	//atualizarStatus
	public function atualizarStatus()
	{
		$data = array(
			$this->campo_status => 'Inativo'
		);

		$this->clear();
		$this->setTabela($this->tabela);
		$this->setCondicao($this->nome_campo_id.'="'.$this->campo_id.'"');
		$this->update($data);
		//echo $this->getSql();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	public function restaurar(){
		$this->clear();
		$this->setTabela('lixeira');
		$this->setCondicao('id_lixeira = "'.$this->id.'"');
		$this->select();
		if($this->rowCount() > 0)
		{
			$lixo = $this->result();
			$this->tabela = $lixo['tabela'];
			$this->campo_status = $lixo['campo_status'];
			$this->campo_id = $lixo['campo_id'];
			$this->nome_campo_id = $lixo['nome_campo_id'];
			
			if($this->atualizarStatus()){
				//echo 'restaurado';
				return $this->deletar();
			}else
				return false;

		}else
			return false;
	}





	public function deletar()
	{
		$this->clear();
		$this->setTabela('lixeira');
		$this->setCondicao('id_lixeira="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0){
			return true;
		}
		else
			return false;
	}

	public function getNumLixeira()
	{
		$this->clear();
		$this->setTabela('lixeira');
		$this->select();
		return $this->rowCount();
	}


	
}

