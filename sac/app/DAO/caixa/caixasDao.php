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
		$this->db->setTabela('checkout');
		$this->db->select();
		if($this->db->rowCount() > 0):
			$result = $this->db->resultAll();
			foreach ($result as $value)
			{
				$caixasModel = new caixasModel();
				$this->db->clear();
				$this->db->setParameter(1, $value['id_checkout']);
				if($this->db->query("select abertura_caixa.*, funcionarios.nome_funcionario, funcionarios.sobrenome_funcionario from abertura_caixa 
						inner join checkout on abertura_caixa.id_checkout = checkout.id_checkout 
						inner join sys_usuarios on abertura_caixa.id_usuario = sys_usuarios.id_usuario 
						inner join funcionarios on funcionarios.id_funcionario = sys_usuarios.id_funcionario
					 where checkout.id_checkout= ?"))
				{
					$result = $this->db->result();
					$caixaAberto = new caixaAbertoModel();
					$caixaAberto->setSaldoInicial($result['saldo_inicial']);
					$caixaAberto->setSaldoFinal($result['saldo_final']);
					$caixaAberto->setDataAbertura($result['data_abertura_caixa']);
					$caixaAberto->setDataFechamento($result['data_fechamento_caixa']);

					$usuario = new usuariosModel();
					$funcionarios = new funcionariosModel();
					$funcionarios->setNome($result['nome_funcionario']);
					$funcionarios->setSobrenome($result['sobrenome_funcionario']);
					$usuario->setId($result['id_usuario']);
					$usuario->setFuncionario($funcionarios);
					$caixaAberto->setUsuario($usuario);
					$caixasModel->addListOpenBox($caixaAberto);
				}


				
				$caixasModel->setId($value['id_checkout']);
				$caixasModel->setCodigo($value['codigo_checkout']);
				$caixasModel->setIp($value['ip_maquina']);
				array_push($caixa, $caixasModel);
				unset($caixasModel);

			}
		endif;
		return $this->getJsoncaixa($caixa);
	}


	/**
	 * Retorna a consulta de um caixa pelo id
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
	 * @return boolean
	 */
 	public function inserir(caixasModel $caixa)
 	{
 		try {
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
 		} catch (dbException $e) {
 			if($e->getDbCode() == '23000'){
 				return 'Esta máquina já está registrada no sistema';
 			}else
	 			return $e->getMessageError();
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


 	public function getJsoncaixa($caixa)
	{
		$this->load->library('dataformat');
		$dataformat = new dataformat();
		$_arCaixa = Array();
		foreach ($caixa as $cx):
			$aux = array(
				    	'id'=> $cx->getId(),
				    	'codigo' => $cx->getCodigo(),
						'ip'=> $cx->getIp(),
						'acoes'=> "",
						'linkEditar'=> URL.'caixa/gerenciar/editar/'.$cx->getId(),
						'abertos'=> array()
				    );
			$arrAberturaCaixa = array();
			foreach ($cx->getListOpenBox() as $OpenBox){
				$valorUndEstoque = 0;
		        $aux2 = array( 
				        	'id' => $OpenBox->getId(),
							'dateOpen' => $OpenBox->getDataAbertura(),
							'dateClose' => $OpenBox->getDataFechamento(),
							'user' => $OpenBox->getUsuario()->getFuncionario()->getNome().' '.$OpenBox->getUsuario()->getFuncionario()->getSobreNome(),
							'acoes' => ""
							
				    	);

				array_push($aux['abertos'], $aux2);
			}

			array_push($_arCaixa, $aux);
        endforeach;

        return json_encode($_arCaixa);
	}

}