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
				$this->db->clear();
				$this->db->setParameter(1, $value['id_caixa']);
				if($this->db->query("select abertura_caixa.*, funcionarios.nome_funcionario, funcionarios.sobrenome_funcionario from abertura_caixa 
						inner join caixas on abertura_caixa.id_caixa = caixas.id_caixa 
						inner join sys_usuarios on abertura_caixa.id_usuario = sys_usuarios.id_usuario 
						inner join funcionarios on funcionarios.id_funcionario = sys_usuarios.id_funcionario
					 where caixas.id_caixa= ?"))
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
					$caixasModel->addCaixaAberto($caixaAberto);
				}


				
				$caixasModel->setId($value['id_caixa']);
				$caixasModel->setCodigo($value['codigo_caixa']);
				$caixasModel->setIp($value['ip_maquina']);
				array_push($caixa, $caixasModel);
				unset($caixasModel);

			}
		endif;
		return $this->getJsoncaixa($caixa);
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
			foreach ($cx->getCaixaAberto() as $OpenBox){
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
				return false;

			}else
				$this->db->insert($data);
		}
		return true;

	}

}