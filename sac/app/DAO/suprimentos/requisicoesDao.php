<?php
/**
 * Classe DAO de Requisicoes
 * @author Wellington cezar, Diego Hernandes
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class requisicoesDao extends Dao{
	private $nUpdates = 0;
	public function __construct(){
		parent::__construct();
	}


	/**
	 * Lista os registros das Requisicoes
	 * @return Array
	 */
	public function listar()
	{
		$this->load->model('suprimentos/requisicoes/requisicoesModel');
		$requisicoes = Array();

		$this->db->clear();
		$this->db->setTabela('requisicoes');
		$this->db->setCondicao(" status_requisicao in('".statusRequisicoes::NOVO."','".statusRequisicoes::PENDENTE."','".statusRequisicoes::APROVADO."','".statusRequisicoes::REPROVADO."','".statusRequisicoes::APROVADO."', '".statusRequisicoes::CANCELADO."') ");
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$requisicoesModel = new requisicoesModel();
				$requisicoesModel->setId($value['id_requisicao']);
				$requisicoesModel->setCodigo($value['codigo_requisicao']);
				$requisicoesModel->setTitulo($value['titulo_requisicao']);
				$requisicoesModel->setObservacoes($value['observacoes_requisicao']);
				$requisicoesModel->setData($value['data_requisicao']);
				$requisicoesModel->setStatus(statusRequisicoes::getAttribute($value['status_requisicao']));
				array_push($requisicoes, $requisicoesModel);
				unset($requisicoesModel);
			}
		endif;
		return $requisicoes;
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
	 * Insere novas requisições
	 * @return boolean
	 */
 	public function inserir(requisicoesModel $requisicao)
 	{
 		$data = array(
  			'codigo_requisicao' => $requisicao->getCodigo(),
 			'titulo_requisicao' => $requisicao->getTitulo(),
 			'observacoes_requisicao' => $requisicao->getObservacoes(),
 			'data_requisicao' => $requisicao->getData(),
 			'status_requisicao' =>$requisicao->getStatus()
 		);


 		$this->db->clear();
		$this->db->setTabela('requisicoes');
		try {
			if($this->db->insert($data))
			{
				$id = $this->db->getUltimoId();
				$requisicao->setId($id);
				$this->atualizaProdutosRequisitados($requisicao);
				return TRUE;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		} catch (Exception $e) {

			throw new Exception($e, 1);
		}
 		
 	}


	/**
	 * Atualiza marcas
	 * @return boolean
	 */
 	public function atualizar(requisicoesModel $requisicao)
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

 	private function atualizaProdutosRequisitados(requisicoesModel $requisicao )
 	{
 		//excluir
		$produtosNaoExcluir = array();
		foreach ($requisicao->getProdutosRequisitados() as $produtos)
		{
			if($produtos->getId() != '')
				array_push($produtosNaoExcluir,$produtos->getProdutos()->getId());
		}
		$cond = '';
		if(!empty($produtosNaoExcluir))
		{
			$produtosNaoExcluir = implode(',', $produtosNaoExcluir);
			$this->db->clear();
			$cond = " AND id_requisicao_produto not in (".$produtosNaoExcluir.")";
		}
		$sql = "DELETE FROM requisicao_produto WHERE id_produto in( SELECT B.id_produto FROM requisicao_produto AS B WHERE B.id_requisicao = '".$requisicao->getId()."' AND id_produto = B.id_produto) $cond";
		$this->db->query($sql);
		if($this->db->rowCount() > 0)

		$this->db->clear();
		$this->db->setTabela('requisicao_produto');
		foreach ($requisicao->getProdutosRequisitados() as $produtosRequisitado)
		{
			if(!empty($produtosRequisitado))
			{
				$data = array(
					'id_produto' => $produtosRequisitado->getProdutos()->getId(),
					'id_requisicao' => $requisicao->getId(),
					'quantidade_produto' => $produtosRequisitado->getQuantidade()
				);
				if($produtosRequisitado->getId() != '')//verifica se o id existe para poder atualiza-lo - utilizado para o editar
				{
					$this->db->setCondicao('id_requisicao_produto = "'.$produtosRequisitado->getId().'"');
					$this->db->update($data);
				}else{
					$this->db->insert($data);
				}

				if($this->db->rowCount() > 0)
					$this->nUpdates++;
			}
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