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
		$this->load->model('caixa/caixaAbertoModel');
		$this->load->model('funcionarios/funcionariosModel');
		$this->load->model('funcionarios/usuariosModel');
		$caixa = Array();

		$this->db->clear();
		$this->db->setTabela('caixas');
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$caixasModel = new caixasModel();
				$caixasModel->setId($value['id_caixa']);
				$caixasModel->setCodigo($value['codigo_caixa']);
				$caixasModel->setIp($value['ip_maquina']);
				array_push($caixa, $caixasModel);
				unset($caixasModel);

			}
		endif;
		return $caixa;
	}


	public function listaAberturaCaixa(caixasModel $caixa)
	{

		$this->db->clear();
		$this->db->setParameter(1, $caixa->getId());
		if($this->db->query("select abertura_caixa.* from abertura_caixa where abertura_caixa.id_caixa= ? ORDER BY id_abertura_caixa DESC"))
		{
			$result = $this->db->resultAll();
			foreach ($result as $res)
			{
				$caixaAberto = new caixaAbertoModel();
				$caixaAberto->setId($res['id_abertura_caixa']);
				$caixaAberto->setSaldoInicial($res['saldo_inicial']);
				$caixaAberto->setSaldoFinal($res['saldo_final']);
				$caixaAberto->setDataAbertura($res['data_abertura_caixa']);
				$caixaAberto->setDataFechamento($res['data_fechamento_caixa']);
				
				$usuario = new usuariosModel();
				$usuario->setId($res['id_usuario']);
				$caixaAberto->setUsuario($usuario);

				$caixa->addCaixaAberto($caixaAberto);
			}
		}
		return $caixa;

	}

	/**
	 * verifica se o ip da máquina atual é um ip válido para abertura de caixa
	 * */
	public function checkmachine(caixasModel $caixasModel)
	{
		try {

			$this->db->clear();
			$this->db->setTabela('caixas');
			$this->db->setCondicao("ip_maquina = ?");
			$this->db->setParameter(1, $caixasModel->getIp());
			if($this->db->select())
			{
				return true;
			}else
				return false;
		} catch (dbException $e) {
			return $e->getMessageError();
		}
	}


	/**
	 * Retorna a consulta de um caixa pelo id
	 * @return object [caixasModel]
	 */
	public function consultar(IConsultaCaixa $consultaCaixa, caixasModel $caixa)
	{
		
		$result = $consultaCaixa->consultar($this->db, $caixa);
		if($result != null){
			$caixa->setId($result['id_caixa']);
			$caixa->setCodigo($result['codigo_caixa']);
			$caixa->setIp($result['ip_maquina']);
			$caixa->setDataCadastro($result['data_cadastro']);
			return $caixa;
		}else
			return null;
	}



	/**
	 * Insere novos caixas
	 * @return boolean
	 */
 	public function inserir(caixasModel $caixa)
 	{
 		$data = array(
  			'codigo_caixa' => $caixa->getCodigo(),
 			'ip_maquina' => $caixa->getIp(),
 			'data_cadastro' => $caixa->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('caixas');
		if($this->db->insert($data))
		{
			return TRUE;
 		}else
 		{
 			return FALSE;
 		}
 		
 	}


	/**
	 * Atualiza caixas
	 * @return boolean, json
	 */
 	public function atualizar(caixasModel $caixa)
 	{

 		$data = array(
 
 			'codigo_caixa' => $caixa->getCodigo(),
 			'ip_maquina' => $caixa->getIp()
 		);

 		$this->db->clear();
		$this->db->setTabela('caixas');
		$this->db->setCondicao ("id_caixa = '".$caixa->getId()."'");
		if($this->db->update($data))
		{
			return true;
 		}else
 		{
 			return $this->db->getError();
 		}
 	}


 	



	public function abrirCaixa(caixasModel $caixa)
	{
		foreach ($caixa->getCaixaAberto() as $caixaAberto) 
		{
			$data = array(
				'id_caixa' => $caixa->getId(),
				'id_usuario' => $caixaAberto->getUsuario()->getId(),
				'saldo_inicial' => $caixaAberto->getSaldoInicial(),
				'data_abertura_caixa' => $caixaAberto->getDataAbertura()	
			);

			$this->db->clear();
			$this->db->setTabela('abertura_caixa');
			$this->db->setCondicao('id_caixa = ? AND data_fechamento_caixa = "0000-00-00 00:00:00"');
			$this->db->setParameter(1, $caixa->getId());
			if($this->db->select())
			{
				return null;
			}else
			{
				$this->db->insert($data);
				$caixaAberto->setId($this->db->getUltimoId());
				return $caixa;
			}
		}
		return null;

	}



	public function finalizarCompra(caixasModel $caixa)
	{
		$data = array(
			'id_abertura_caixa' => $caixa->getCaixaAberto()[0]->getId(),
			'data_venda' => $caixa->getCaixaAberto()[0]->getVendas()[0]->getDataVenda(),
			'hora_venda' => $caixa->getCaixaAberto()[0]->getVendas()[0]->getHoraVenda(),
			'forma_pagamento' => $caixa->getCaixaAberto()[0]->getVendas()[0]->getFormaPagamento(),
			'valor_pago' => $caixa->getCaixaAberto()[0]->getVendas()[0]->getValorPago()
		);
		$this->db->clear();
		$this->db->query('BEGIN');
		$this->db->setTabela('vendas');
		if($this->db->insert($data))
		{
			$caixa->getCaixaAberto()[0]->getVendas()[0]->setId( $this->db->getUltimoId());
			$this->cadastraItemCompra($caixa);
			return true;
		}
	}

	private function cadastraItemCompra(caixasModel $caixa)
	{

		foreach ($caixa->getCaixaAberto()[0]->getVendas()[0]->getProdutosVendidos() as $produtoVendido){
			$data = array(
				'id_venda' => $caixa->getCaixaAberto()[0]->getVendas()[0]->getId(),
				'id_produto' => $produtoVendido->getProduto()->getId(),
				'quantidade_produto_vendido' => $produtoVendido->getQuantidade(),
				'unidade_medida_vendido' =>'', //$produtoVendido->getProduto()->getUnidadeMedidaParaVenda()->getUnidadeMedida()->getAbreviacao(),
				'preco_vendido' => $produtoVendido->getPrecoVendido()
			);

			$this->db->clear();
			$this->db->setTabela('produtos_vendidos');
			$this->db->insert($data);
		}
		$this->db->query('COMMIT');
	}
}