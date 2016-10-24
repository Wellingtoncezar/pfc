<?php
/**
 * Classe DAO de Produtos
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class precosDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros dos produtos
	 * @return Array
	 */
	public function listar(produtosModel $produto)
	{
		$this->load->model('produtos/precosModel');
		$precos = Array();

		$this->db->clear();
		$this->db->setTabela('produtos_preco');
		$this->db->setCondicao("id_produto = ?");
		$this->db->setParameter(1, $produto->getId());
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$precosModel = new precosModel();
				$precosModel->setId($value['id_produto_preco']);
				$precosModel->setPreco($value['preco_produto']);
				$precosModel->setDataInicio($value['data_inicio']);
				$precosModel->setDataFim($value['data_fim']);
				$precosModel->setPadrao($value['preco_padrao']);
				$precosModel->setDataCadastro($value['data_cadastro']);

				array_push($precos, $precosModel);
				unset($precosModel);
			}
		endif;
		
		return $precos;
	}


	public function consultar(produtosModel $produto )
	{
		// $this->load->model('produtos/precosModel');
		// $precos = Array();

		// $this->db->clear();
		// $this->db->setTabela('produtos_preco');
		// $this->db->setCondicao("id_produto = ?");
		// $this->db->setParameter(1, $produto->getId());
		// $this->db->select();
		// if($this->db->rowCount() > 0):
		// 	$result = $this->db->resultAll();
		// 	foreach ($result as $value)
		// 	{
		// 		$precosModel = new precosModel();
		// 		$precosModel->setId($value['id_produto_preco']);
		// 		$precosModel->setPreco($value['preco_produto']);
		// 		$precosModel->setDataInicio($value['data_inicio']);
		// 		$precosModel->setDataFim($value['data_fim']);
		// 		$precosModel->setPadrao($value['preco_padrao']);
		// 		$precosModel->setDataCadastro($value['data_cadastro']);

		// 		array_push($precos, $precosModel);
		// 		unset($precosModel);
		// 	}
		// endif;
		
		// return $precos;
	}

	/**
	 * consulta o preço de venda
	 * Caso esteja em um período, retornará o ultimo preço no período cadastrado
	 * senão retornará o preço definido como padrão
	 * */
	public function consultarPrecoVenda(produtosModel $produto)
	{
		try{
			$this->load->model('produtos/precosModel');
			$precosModel = new precosModel();

			$this->db->clear();
			$sql = "SELECT *
					FROM produtos_preco as P
					WHERE P.id_produto = ? 
					AND id_produto_preco = 
						CASE
					    	WHEN (CURDATE() BETWEEN P.data_inicio  AND P.data_fim) THEN (
					        	select PP.id_produto_preco 
					            from produtos_preco as PP 
					            where PP.id_produto = P.id_produto 
					            AND CURDATE() BETWEEN PP.data_inicio AND PP.data_fim 
					            LIMIT 1
					    )
					    ELSE (
					        select PP.id_produto_preco 
					            from produtos_preco as PP 
					            where PP.id_produto = P.id_produto 
					        AND PP.preco_padrao = TRUE LIMIT 1 
					    )
					END
					ORDER BY `P`.`id_produto_preco`  DESC LIMIT 1";

			$this->db->setParameter(1, $produto->getId());

			if($this->db->query($sql)):
				$result = $this->db->result();
				$precosModel->setId($result['id_produto_preco']);
				$precosModel->setPreco($result['preco_produto']);
				$precosModel->setDataInicio($result['data_inicio']);
				$precosModel->setDataFim($result['data_fim']);
				$precosModel->setPadrao($result['preco_padrao']);
				$precosModel->setDataCadastro($result['data_cadastro']);
			endif;
			return $precosModel;
		}catch(dbException $e)
 		{

 			return $e->getMessageError();
 		}
	}



 	public function inserir(produtosModel $produto, precosModel $preco)
 	{
 		try{
	 		$data = array(
	 			'id_produto' => $produto->getId(),
	 			'preco_produto' => $preco->getPreco(),
	 			'data_inicio' => $preco->getDataInicio(),
	 			'data_fim' => $preco->getDataFim(),
	 			'preco_padrao' => $preco->getPadrao(),
	 			'data_cadastro' => $preco->getDataCadastro()
	 		);


	 		$this->db->clear();
			$this->db->setTabela('produtos_preco');
			$this->db->insert($data);
			if($this->db->rowCount() > 0)
			{
				return true;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
	 	
 		}catch(dbException $e)
 		{

 			return $e->getMessageError();
 		}

	}
}