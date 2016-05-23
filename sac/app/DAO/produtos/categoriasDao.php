<?php
/**
 * Classe DAO de Categoria
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class categoriasDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos Categorias
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('produtos/categoriasModel');
		$categorias = Array();

		$this->db->clear();
		$this->db->setTabela('categorias');
		$this->db->setCondicao(" status_categoria in('".status::ATIVO."','".status::INATIVO."') ");
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$categoriasModel = new categoriasModel();
				$categoriasModel->setId($value['id_categoria']);
				$categoriasModel->setNome($value['nome_categoria']);
				$categoriasModel->setStatus(status::getAttribute($value['status_categoria']));
				array_push($categorias, $categoriasModel);
				unset($categoriasModel);
			}
			return $categorias;
		else:
			return $categorias;
		endif;

	}


	/**
	 * Retorna a consulta de um categorias pelo id
	 * @return object [categoriasModel]
	 */
	public function consultar(categoriasModel $categoria)
	{
		$this->db->clear();
		$this->db->setTabela('categorias');
		$this->db->setCondicao("id_categoria = '".$categoria->getId()."'");
		$this->db->select();

		//CATEGORIAS
		if($this->db->rowCount() > 0):
			$result = $this->db->result();

			$categoria->setNome($result['nome_categoria']);
			$categoria->setStatus(status::getAttribute($result['status_categoria']));
			return $categoria;
		else:
			
			return $categoriasModel;
		endif;
	}



	/**
	 * Insere novas categorias
	 * @return boolean, json
	 */
 	public function inserir(categoriasModel $categoria)
 	{
 		
 		$data = array(
 
 			'nome_categoria' => $categoria->getNome(),
 			'status_categoria' => $categoria->getStatus(),
 			'data_cadastro_categoria' => $categoria->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('categorias');
		if($this->db->insert($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 		
 	}


	/**
	 * Atualiza categorias
	 * @return boolean, json
	 */
 	public function atualizar(categoriasModel $categoria)
 	{
 		$data = array(
 
 			'nome_categoria' => $categoria->getNome()
 		);


 		$this->db->clear();
		$this->db->setTabela('categorias');
		$this->db->setCondicao ("id_categoria = '".$categoria->getId()."'");
		try {
			if($this->db->update($data))
			{
				return true;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		} catch (Exception $e) {
			throw new Exception($e, 1);
		}
 	}

	


	/**
 	 * Atualiza o status
 	 * @return boolean
 	 */
	public function atualizarStatus(categoriasModel $categoria)
	{
		$data = array('status_categoria'=>$categoria->getStatus());
		$this->db->clear();
		$this->db->setTabela('categorias');
		$this->db->setCondicao("id_categoria = '".$categoria->getId()."'");
		$this->db->update($data);
		if($this->db->rowCount()>0)
			return true;
		else
			return false;
	}


}