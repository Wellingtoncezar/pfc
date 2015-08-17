<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class tipoOficioIgrejaModel extends Controller{
	private $id;
	private $letra;
	private $nome;
	private $status;
	private $statusOficio;
	private $listExcluirStatusOficio;

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
	public function setStatusOficio($statusOficio)
	{
		$this->statusOficio = $statusOficio;
	}

	public function getStatusOficio()
	{
		return $this->statusOficio;
	}

	public function setListExcluirStatusOficio($list)
	{
		$this->listExcluirStatusOficio = $list;
	}


	/**
	*Retorna a lista de estado civil
	*/
	public function listar($condicao = "status_tipo_oficio_igreja <> 'Excluido'")
	{
		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->setCondicao($condicao);
		$this->select();
		$tipo_oficio_igreja = $this->resultAll();
		return $tipo_oficio_igreja;
	}

	public function getTipoOficioIgreja($id)
	{
		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->setCondicao("id_tipo_oficio_igreja = '".$id."'");
		$this->select();
		$tipo_oficio_igreja = $this->result();

		$this->listStatusOficio($id);

		return $tipo_oficio_igreja;
	}

	public function listStatusOficio($id)
	{
		$this->clear();
		$this->setTabela('status_tipo_oficio_igreja');
		$this->setCondicao("id_tipo_oficio_igreja = '".$id."'");
		$this->select();
		$this->statusOficio = $this->resultAll();
		return $this->statusOficio;
	}

	public function inserir()
	{
		$data = array(
			'nome_tipo_oficio_igreja' => filter_var($this->nome),
			'status_tipo_oficio_igreja' => filter_var($this->status),
			'data_cadastro_tipo_oficio_igreja' => date('Y-m-d H:i:s')
		);
		$this->query('BEGIN');
		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->insert($data);

		$this->id = $this->getUltimoId();



		$this->clear();
		$this->setTabela('status_tipo_oficio_igreja');
		if(is_array($this->statusOficio))
		{
			foreach ($this->statusOficio as $value) {
				$data = array(
					'id_tipo_oficio_igreja' =>  $this->id,
					'nome_status_tipo_oficio_igreja' => $value['statusOficio']
				);
				$this->insert($data);
			}
		}

		if($this->rowCount() > 0)
		{
			$this->query('COMMIT');
			return true;
		}
		else
		{
			$this->query('CALLBACK');
			return false;
		}
	}



	public function atualizar()
	{
		$updates = 0;
		$data = array(
			'nome_tipo_oficio_igreja' => filter_var($this->nome),
			'status_tipo_oficio_igreja' => filter_var($this->status)
		);
		$this->query('BEGIN');
		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->setCondicao('id_tipo_oficio_igreja = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			$updates++;


		$this->clear();
		$this->setTabela('status_tipo_oficio_igreja');

		if(is_array($this->listExcluirStatusOficio))
		{
			foreach ($this->listExcluirStatusOficio as $value)
			{
				$this->setCondicao('id_status_tipo_oficio_igreja = "'.$value.'"');
				$this->delete();
				if($this->rowCount() > 0)
					$updates++;
			}
		}

		if(is_array($this->statusOficio))
		{
			foreach ($this->statusOficio as $value)
			{

				$data = array(
					'id_tipo_oficio_igreja' =>  $this->id,
					'nome_status_tipo_oficio_igreja' => $value['statusOficio']
				);

				if($value['id'] != '')
				{
					$this->setCondicao('id_status_tipo_oficio_igreja = "'.$value['id'].'"');
					$this->update($data);
					if($this->rowCount() > 0)
						$updates++;
				}else
				{
					$this->insert($data);
					if($this->rowCount() > 0)
						$updates++;
				}
			}
		}

		if($updates > 0)
		{
			$this->query('COMMIT');
			return true;
		}
		else
		{
			$this->query('ROLLBACK');
			return false;
		}
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_tipo_oficio_igreja' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->setCondicao('id_tipo_oficio_igreja = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}

	public function deletar()
	{
		$this->clear();
		$this->setTabela('tipo_oficio_igreja');
		$this->setCondicao('id_tipo_oficio_igreja="'.$this->id.'"');
		$this->delete();
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}


	
}

/**
*
*class: tipoOficioIgrejaModel
*
*location : models/configuracoes/tabelas/tipoOficioIgrejaModel.model.php
*/