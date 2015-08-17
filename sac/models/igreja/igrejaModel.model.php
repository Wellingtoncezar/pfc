<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class igrejaModel extends Controller{
	private $id;
	private $nome;
	private $cep;
	private $rua;
	private $numero;
	private $complemento;
	private $bairro;
	private $cidade;
	private $estado;
	private $telefones;
	private $telefonesExcluir;
	private $data_fundacao;
	private $tipo_igreja;
	private $cnpj;
	private $pastor;

	private $status;


	public function __construct(){
		parent::__construct();
	}

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getNome(){
		return $this->nome;
	}


	public function setCep($cep)
	{
		$this->cep = $cep;
	}
	public function getCep()
	{
		return $this->cep;
	}


	public function setRua($rua)
	{
		$this->rua = $rua;
	}
	public function getRua()
	{
		return $this->rua;
	}


	public function setNumero($numero)
	{
		$this->numero = $numero;
	}
	public function getNumero()
	{
		return $this->numero;
	}


	public function setComplemento($complemento)
	{
		$this->complemento = $complemento;
	}
	public function getComplemento()
	{
		return $this->complemento;
	}


	public function setBairro($bairro)
	{
		$this->bairro = $bairro;
	}
	public function getBairro()
	{
		return $this->bairro;
	}


	public function setCidade($cidade)
	{
		$this->cidade = $cidade;
	}
	public function getCidade()
	{
		return $this->cidade;
	}


	public function setEstado($estado)
	{
		$this->estado = $estado;
	}
	public function getEstado()
	{
		return $this->estado;
	}

	public function setTelefones($telefones){
		$this->telefones = $telefones;
	}
	public function getTelefones()
	{
		return $this->telefones;
	}

	public function setListTelefonesExcluir($telefonesExcluir){
		$this->telefonesExcluir = $telefonesExcluir;
	}
	public function getListTelefonesExcluir()
	{
		return $this->telefonesExcluir;
	}

	



	public function setData_fundacao($data_fundacao)
	{
		$this->data_fundacao = $data_fundacao;
	}
	public function getData_fundacao()
	{
		return $this->data_fundacao;
	}

	public function setTipo_igreja($tipo_igreja)
	{
		$this->tipo_igreja = $tipo_igreja;
	}
	public function getTipo_igreja()
	{
		return $this->tipo_igreja;
	}

	public function setCnpj($cnpj)
	{
		$this->cnpj = $cnpj;
	}
	public function getCnpj()
	{
		return $this->cnpj;
	}

	public function setPastor($pastor)
	{
		$this->pastor = $pastor;
	}
	public function getPastor()
	{
		return $this->pastor;
	}



	public function setStatus($status){
		$this->status = $status;
	}

	public function getStatus(){
		return $this->status;
	}


	public function inserir()
	{
		//formata a data para o banco de dados
		$dataFormat = new dataFormat();
		$this->data_fundacao = $dataFormat->formatar($this->data_fundacao,'data','banco');

		$data = array(
			'nome_igreja' => filter_var($this->nome),
			'cep_igreja' => filter_var($this->cep),
			'rua_igreja' => filter_var($this->rua),
			'numero_igreja' => filter_var($this->numero),
			'complemento_igreja' => filter_var($this->complemento),
			'bairro_igreja' => filter_var($this->bairro),
			'cidade_igreja' => filter_var($this->cidade),
			'estado_igreja' => filter_var($this->estado),
			'pais_igreja' => 'Brasil',
			'data_fundacao' => filter_var($this->data_fundacao),
			'tipo_igreja' => filter_var($this->tipo_igreja),
			'cnpj' => filter_var($this->cnpj),
			'pastor' => filter_var($this->pastor),
			'status_igreja' => 'Ativo',
			'data_cadastro' => date('Y-m-d H:i:s')
		);
		
		$this->clear();
		//$this->query('BEGIN');
		$this->setTabela('igreja');
		$this->insert($data);
		if($this->rowCount() > 0)
		{
			$this->id = $this->getUltimoId();

			if($this->telefones != '' &&  !empty($this->telefones))
				$this->insertTelefones();


			$this->query('COMMIT');
			return true;
		}else{
			$this->query('ROLLBACK');
			return json_encode(array('erro'=>'Erro ao inserir igreja'));
		}
	}



	public function atualizar()
	{
		//formata a data para o banco de dados
		$dataFormat = new dataFormat();
		$this->data_fundacao = $dataFormat->formatar($this->data_fundacao,'data','banco');

		$data = array(
			'nome_igreja' => filter_var($this->nome),
			'cep_igreja' => filter_var($this->cep),
			'rua_igreja' => filter_var($this->rua),
			'numero_igreja' => filter_var($this->numero),
			'complemento_igreja' => filter_var($this->complemento),
			'bairro_igreja' => filter_var($this->bairro),
			'cidade_igreja' => filter_var($this->cidade),
			'estado_igreja' => filter_var($this->estado),
			'pais_igreja' => 'Brasil',
			'data_fundacao' => filter_var($this->data_fundacao),
			'tipo_igreja' => filter_var($this->tipo_igreja),
			'cnpj' => filter_var($this->cnpj),
			'pastor' => filter_var($this->pastor),
			'status_igreja' => 'Ativo',
			'data_cadastro' => date('Y-m-d H:i:s')
		);
		
		$this->clear();
		$this->query('BEGIN');
		$this->setTabela('igreja');
		$this->setCondicao('id_igreja = "'.$this->id.'"');
		$this->update($data);

		if($this->telefonesExcluir != '' &&  !empty($this->telefonesExcluir))
			$this->excluirTelefones();

		
		if($this->telefones != '' &&  !empty($this->telefones))
			$this->updateTelefones();



		if($this->rowCount() > 0)
		{
			$this->query('COMMIT');
			return true;
		}else{
			$this->query('ROLLBACK');
			return json_encode(array('erro'=>'Erro ao inserir igreja'));
		}
	}


	private function excluirTelefones()
	{
		foreach ($this->telefonesExcluir as $value)
		{
			$this->clear();
			$this->setTabela('telefones_igreja');
			$this->setCondicao('id_telefone_igreja = "'.$value.'"');
			$this->delete();
		}
	}


	private function insertTelefones()
	{
		$this->clear();
		$this->setTabela('telefones_igreja');
		$arr = array();
		
		foreach ($this->telefones as $key => $value){
			if(!empty($value))
			{
				$data = array(
					'id_igreja' => $this->id,
					'telefone_igreja' => $value['telefone'],
					'operadora_igreja' => $value['operadora'],
					'data_cadastro_igreja' => date('Y-m-d H:i:s')
				);
				$this->insert($data);
			}
		}
	}

	private function updateTelefones()
	{
		$this->clear();
		$this->setTabela('telefones_igreja');
		$arr = array();
		
		foreach ($this->telefones as $key => $value){
			if(!empty($value))
			{
				$data = array(
					'id_igreja' => $this->id,
					'telefone_igreja' => $value['telefone'],
					'operadora_igreja' => $value['operadora'],
					'data_cadastro_igreja' => date('Y-m-d H:i:s')
				);
				
				if($value['id_telefone'] == '')
					$this->insert($data);
				else
				{
					$this->setCondicao('id_telefone_igreja = "'.$value['id_telefone'].'"');
					$this->update($data);
				}
				
			}
		}
	}
	


	public function listar($condicao = '<>', $valor = 'Excluído'){
		$this->clear();
		$this->query("SELECT * FROM igreja WHERE status_igreja $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}


	public function getIgreja(){
		$this->clear();
		$this->query("SELECT * FROM igreja WHERE id_igreja = '".$this->id."'");
		if($this->rowCount() > 0){
			return $this->result();
		}else{
			return false;
		}
	}

	public function getPrimeiraIgreja(){
		$this->clear();
		$this->query("SELECT * FROM igreja LIMIT 1");
		if($this->rowCount() > 0){
			return $this->result();
		}else{
			return false;
		}
	}


	public function getTelefonesIgreja(){
		$this->clear();
		$this->query("SELECT * FROM telefones_igreja WHERE id_igreja = '".$this->id."'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_igreja' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('igreja');
		$this->setCondicao('id_igreja = "'.$this->id.'"');
		$this->query('SELECT setLog("'.$_SESSION['login_adm']['id'].'")');
		$this->update($data);
		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}




	
}




