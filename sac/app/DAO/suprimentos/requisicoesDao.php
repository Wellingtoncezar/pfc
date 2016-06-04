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
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('funcionarios/usuariosModel');
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

				$this->db->clear();
				$this->db->setTabela('sys_usuarios as a , requisicao_usuario as b, funcionarios as c');
				$this->db->setCondicao("a.id_usuario = b.id_usuario and a.id_funcionario = c.id_funcionario and b.id_requisicao = ?");
				$this->db->setParameter(1,$requisicoesModel->getId());
				$usuariosModel = new usuariosModel();
				$funcionariosModel = new funcionariosModel();
				
				if($this->db->select())
				{
					$user = $this->db->result();
					$funcionariosModel->setId($user['id_funcionario']);
					$funcionariosModel->setNome($user['nome_funcionario']);
					$funcionariosModel->setSobrenome($user['sobrenome_funcionario']);

					$usuariosModel->setId($user['id_usuario']);
				}
				$usuariosModel->setFuncionario($funcionariosModel);
				$requisicoesModel->setUsuarioCadastrado($usuariosModel);
				array_push($requisicoes, $requisicoesModel);
				unset($requisicoesModel);
			}
		endif;
		return $requisicoes;
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
				$this->inserirUser($requisicao->getUsuarioCadastrado(),$id);
				return TRUE;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		} catch (Exception $e) {

			throw new Exception($e, 1);
		}
 		
 	}
    
    public function inserirUser (usuariosModel $usuario, $id_requisicao)
    {
    	$data = array(
    		'id_requisicao' => $id_requisicao,
 			'id_usuario' => $usuario->getId(),
    		);

    	$this->db->clear();
		$this->db->setTabela('requisicao_usuario');
		try {
			if($this->db->insert($data))
			{
				
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
	 * Atualiza Requisições
	 * @return boolean
	 */
 	public function atualizar(requisicoesModel $requisicao)
 	{
 		$data = array(
  			'codigo_requisicao' => $requisicao->getCodigo(),
 			'titulo_requisicao' => $requisicao->getTitulo(),
 			'observacoes_requisicao' => $requisicao->getObservacoes(),
 		);


 		$this->db->clear();
		$this->db->setTabela('requisicoes');
		$this->db->setCondicao("id_requisicao = '".$requisicao->getId()."'");
		try {
			if($this->db->update($data))
			{
				$this->atualizaProdutosRequisitados($requisicao);
				//$this->inserirUser($requisicao->getUsuarioCadastrado(),$requisicao->getId());
				return TRUE;
	 		}else
	 		{
	 			return $this->db->getError();
	 		}
		} catch (Exception $e) {

			throw new Exception($e, 1);
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
					'id_unidade_medida_produto' => $produtosRequisitado->getProdutos()->getUnidadeMedida()[0]->getId(),
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
	



	public function listarProdutosRequisitados(requisicoesModel $requisicao)
	{
		// $this->db->clear();
		// $this->db->setTabela('requisicoes');
		// $this->db->setCondicao(" id_requisicao = ? ");
		// $this->db->setParameter(1,$requisicao->getId());
		// if($this->db->select()):
		// 	$result = $this->db->resultAll();
			
		// 	$requisicoesModel = new requisicoesModel();
		// 	$requisicoesModel->setId($value['id_requisicao']);
		// 	$requisicoesModel->setCodigo($value['codigo_requisicao']);
		// 	$requisicoesModel->setTitulo($value['titulo_requisicao']);
		// 	$requisicoesModel->setObservacoes($value['observacoes_requisicao']);
		// 	$requisicoesModel->setData($value['data_requisicao']);
		// 	$requisicoesModel->setStatus(statusRequisicoes::getAttribute($value['status_requisicao']));

		// 	$this->db->clear();
		// 	$this->db->setTabela('produtos as a , requisicao_produto as b , unidade_media as c');
		// 	$this->db->setCondicao("a.id_usuario = b.id_usuario and a.id_funcionario = c.id_funcionario and b.id_requisicao = ?");
		// 	$this->db->setParameter(1,$requisicoesModel->getId());
		// 	$usuariosModel = new usuariosModel();
		// 	$funcionariosModel = new funcionariosModel();
			
		// 	if($this->db->select())
		// 	{
		// 		$user = $this->db->result();
		// 		$funcionariosModel->setId($user['id_funcionario']);
		// 		$funcionariosModel->setNome($user['nome_funcionario']);
		// 		$funcionariosModel->setSobrenome($user['sobrenome_funcionario']);

		// 		$usuariosModel->setId($user['id_usuario']);
		// 	}
		// 	$usuariosModel->setFuncionario($funcionariosModel);
		// 	$requisicoesModel->setUsuarioCadastrado($usuariosModel);
		
			





	}
	


	public function consultar(requisicoesModel $requisicao)
	{
		$this->load->model('produtos/produtosModel');
		$this->load->model('produtos/unidademedidaModel');
		$this->load->model('produtos/unidadeMedidaProdutoModel');
		$this->db->clear();
		$this->db->setTabela('requisicoes');
		$this->db->setCondicao("id_requisicao = '".$requisicao->getId()."'");
		$this->db->select();

		//Requisição
		if($this->db->rowCount() > 0):
			$value = $this->db->result();
			$requisicoesModel = new requisicoesModel();
			$requisicoesModel->setId($value['id_requisicao']);
			$requisicoesModel->setCodigo($value['codigo_requisicao']);
			$requisicoesModel->setTitulo($value['titulo_requisicao']);
			$requisicoesModel->setObservacoes($value['observacoes_requisicao']);
			$requisicoesModel->setData($value['data_requisicao']);
			$requisicoesModel->setStatus(statusRequisicoes::getAttribute($value['status_requisicao']));

			$this->db->clear();
	 		$this->db->setTabela('produtos as a , requisicao_produto as b , unidade_media as c, unidade_medida_produto as d');
			$this->db->setCondicao("a.id_produto = b.id_produto and b.id_requisicao = ? and b.id_unidade_medida_produto = c.id_unidade_medida_produto c.id_unidade_medida = d.id_unidade_medida");
			$this->db->setParameter(1,$value['id_requisicao']);

			if($this->db->select())
			{
				$resultProd = $this->db->resultAll();
				foreach ($resultProd as $key => $value) 
				{
					//unidade medida
					$unidademedidaModel = new unidademedidaModel();
					$unidademedidaModel->setId($value['id_unidade_medida']);

					//unidade de medida do produto
					$unidadeMedidaProdutoModel = new unidadeMedidaProdutoModel();
					$unidadeMedidaProdutoModel->setId($produto['idUnidadeMedida']);
					$unidadeMedidaProdutoModel->setUnidadeMedida($unidademedidaModel);

					//prodtos
					$produtosModel = new produtosModel();
					$produtosModel->setId($value['id_produto']);
					$produtosModel->setNome($value['nome_produto']);
					$produtosModel->setFoto($value['foto_produto']);
					
					//produtos requisitados
					$requisicaoProdutoModel = new requisicaoProdutoModel();
					$requisicaoProdutoModel->setId($value['id_requisicao_produto']);
					$requisicaoProdutoModel->setQuantidade($value['quantidade_produto']);
					$requisicaoProdutoModel->setProduto($produtosModel);
					$requisicoesModel ->addProdutoRequisitado($produtosModel);
				}
			}

		endif;

		return $requisicao;
		
	}



}