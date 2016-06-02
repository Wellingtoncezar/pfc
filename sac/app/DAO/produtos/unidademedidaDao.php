<?php
/**
 * Classe DAO de unidade_medida
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class unidademedidaDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos unidademedida
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('produtos/unidadeMedidaModel');
		$unidademedida = Array();

		$this->db->clear();
		$this->db->setTabela('unidade_medida');
		$this->db->select();
		$this->db->setOrderBy('nome_unidade_medida');
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$unidademedidaModel = new unidadeMedidaModel();
				$unidademedidaModel->setId($value['id_unidade_medida']);
				$unidademedidaModel->setNome($value['nome_unidade_medida']);
				$unidademedidaModel->setAbreviacao($value['abreviacao_unidade_medida']);
				array_push($unidademedida, $unidademedidaModel);
				unset($unidademedidaModel);
			}
			return $unidademedida;
		else:
			return $unidademedida;
		endif;

	}


	/**
	 * Retorna a consulta de um unidademedida pelo id
	 * @return object [unidademedidaModel]
	 */
	public function consultar(unidadeMedidaModel $unidade_medida)
	{
		$this->db->clear();
		$this->db->setTabela('unidade_medida');
		$this->db->setCondicao("id_unidade_medida = '".$unidade_medida->getId()."'");
		$this->db->select();

		//unidademedida
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$unidade_medida->setNome($result['nome_unidade_medida']);
			$unidade_medida->setStatus(status::getAttribute($result['status_unidade_medida']));
			return $unidade_medida;
		else:
			
			return $unidademedidaModel;
		endif;
	}



	/**
	 * Insere novas unidademedida
	 * @return boolean, json
	 */
 	public function inserir(unidademedidaModel $unidade_medida)
 	{
 		
 		$data = array(
 
 			'nome_unidade_medida' => $unidade_medida->getNome(),
 			'status_unidade_medida' => $unidade_medida->getStatus(),
 			'data_cadastro_unidade_medida' => $unidade_medida->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('unidade_medida');
		if($this->db->insert($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 		
 	}


	/**
	 * Atualiza unidademedida
	 * @return boolean, json
	 */
 	public function atualizar(unidademedidaModel $unidade_medida)
 	{
 		$data = array(
 
 			'nome_unidade_medida' => $unidade_medida->getNome()
 		);


 		$this->db->clear();
		$this->db->setTabela('unidade_medida');
		$this->db->setCondicao ("id_unidade_medida = '".$unidade_medida->getId()."'");
		if($this->db->update($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 	}

	


	/**
 	 * Atualiza o status
 	 * @return boolean
 	 */
	public function atualizarStatus(unidademedidaModel $unidade_medida)
	{
		$data = array('status_unidade_medida'=>$unidade_medida->getStatus());
		$this->db->clear();
		$this->db->setTabela('unidade_medida');
		$this->db->setCondicao("id_unidade_medida = '".$unidade_medida->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


}