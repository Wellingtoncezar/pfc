<?php
/**
 * Classe DAO de Marcas
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class marcasDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos Marcas
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('produtos/marcasModel');
		$marcas = Array();

		$this->db->clear();
		$this->db->setTabela('marcas');
		$this->db->setCondicao(" status_marca in('".status::ATIVO."','".status::INATIVO."') ");
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$marcasModel = new marcasModel();
				$marcasModel->setId($value['id_marca']);
				$marcasModel->setNome($value['nome_marca']);
				$marcasModel->setStatus(status::getAttribute($value['status_marca']));
				array_push($marcas, $marcasModel);
				unset($marcasModel);
			}
			return $marcas;
		else:
			return $marcas;
		endif;
	}


	/**
	 * Retorna a consulta de um marcas pelo id
	 * @return object [marcasModel]
	 */
	public function consultar(marcasModel $marca)
	{
		$this->db->clear();
		$this->db->setTabela('marcas');
		$this->db->setCondicao("id_marca = '".$marca->getId()."'");
		$this->db->select();

		//MARCAS
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$marca->setNome($result['nome_marca']);
			$marca->setStatus(status::getAttribute($result['status_marca']));
			return $marca;
		else:
			return $marca;
		endif;
	}



	/**
	 * Insere novos marcas
	 * @return boolean, json
	 */
 	public function inserir(marcasModel $marca)
 	{
 		
 		$data = array(
 
 			'nome_marca' => $marca->getNome(),
 			'status_marca' => $marca->getStatus(),
 			'data_cadastro_marca' => $marca->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('marcas');
		if($this->db->insert($data))
		{
			return TRUE;
 		}else
 		{
 			return $this->db->getError();
 		}
 		
 	}


	/**
	 * Atualiza marcas
	 * @return boolean, json
	 */
 	public function atualizar(marcasModel $marca)
 	{
 		$data = array(
 
 			'nome_marca' => $marca->getNome(),

 		);

 		$this->db->clear();
		$this->db->setTabela('marcas');
		$this->db->setCondicao ("id_marca = '".$marca->getId()."'");
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
	public function atualizarStatus(marcasModel $marca)
	{
		$data = array('status_marca'=>$marca->getStatus());
		$this->db->clear();
		$this->db->setTabela('marcas');
		$this->db->setCondicao("id_marca = '".$marca->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


}