<?php
/**
 * Classe DAO de cargos
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class cargosDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}
	/**
	 * Lista os registros de cargos
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('funcionarios/cargosModel');
		$cargos = Array();

		$this->db->clear();
		$this->db->setTabela('cargos');
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$cargosModel = new cargosModel();
				$cargosModel->setId($value['id_cargo']);
				$cargosModel->setNome($value['nome_cargo']);
				$cargosModel->setSetor($value['setor_cargo']);
				array_push($cargos, $cargosModel);
				unset($cargosModel);
			}
			return $cargos;
		else:
			return $cargos;
		endif;

	}


	/**
	 * Retorna a consulta de um cargos pelo id
	 * @return object [cargosModel]
	 */
	public function consultar(cargosModel $cargo)
	{
		$this->db->clear();
		$this->db->setTabela('cargos');
		$this->db->setCondicao("id_cargo = '".$cargo->getId()."'");
		$this->db->select();

		//cargos
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$cargo->setNome($result['nome_cargo']);
			$cargo->setSetor($result['setor_cargo']);
			return $cargo;
		else:
			
			return $cargosModel;
		endif;
	}



	/**
	 * Insere novas cargos
	 * @return boolean, json
	 */
 	public function inserir(cargosModel $cargos)
 	{
 		
 		$data = array(
 
 			'nome_cargo' => $cargos->getNome(),
 			'setor_cargo' => $cargos->getSetor()
 		);

 		$this->db->clear();
		$this->db->setTabela('cargos');
		if($this->db->insert($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 		
 	}


	/**
	 * Atualiza cargos
	 * @return boolean, json
	 */
 	public function atualizar(cargosModel $cargo)
 	{
 		$data = array(
  			'nome_cargo' => $cargo->getNome(),
  			'setor_cargo' => $cargo->getSetor()
 		);


 		$this->db->clear();
		$this->db->setTabela('cargos');
		$this->db->setCondicao ("id_cargo = '".$cargo->getId()."'");
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
	public function excluir(cargosModel $cargo)
	{
		$this->db->clear();
		$this->db->setTabela('cargos');
		$this->db->setCondicao("id_cargo = ?");
		$this->db->setParameter(1,$cargo->getId());
		if($this->db->delete())
			return true;
		else
			return $this->db->getError();
	}


}