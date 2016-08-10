<?php
/**
 * Classe DAO de Caixas
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class caixasDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos Caixas
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('caixa/caixasModel');
		$caixas = Array();

		$this->db->clear();
		$this->db->setTabela('checkout');
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
	 * @return object [caixasModel]
	 */
	public function consultar(caixasModel $caixa)
	{

		$this->db->clear();
		$this->db->setTabela('checkout');
		$this->db->setCondicao("id_checkout = '".$caixa->getId()."'");
		$this->db->select();

		//CAIXAS
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$caixa->setCodigo($result['codigo_checkout']);
			$caixa->setIp($result['ip_maquina']);
			
			return $caixa;
		else:
			return $caixa;
		endif;
	}



	/**
	 * Insere novos caixas
	 * @return boolean, json
	 */
 	public function inserir(caixasModel $caixa)
 	{
 		
 		$data = array(
  			'codigo_checkout' => $caixa->getCodigo(),
 			'ip_maquina' => $caixa->getIp(),
 			'data_cadastro' => $caixa->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('checkout');
		if($this->db->insert($data))
		{
			return TRUE;
 		}else
 		{
 			return $this->db->getError();
 		}
 		
 	}


	/**
	 * Atualiza caixas
	 * @return boolean, json
	 */
 	public function atualizar(caixasModel $caixa)
 	{

 		$data = array(
 
 			'codigo_checkout' => $caixa->getCodigo(),
 			'ip_maquina' => $caixa->getIp()
 		);

 		$this->db->clear();
		$this->db->setTabela('checkout');
		$this->db->setCondicao ("id_checkout = '".$caixa->getId()."'");
		if($this->db->update($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 	}


}