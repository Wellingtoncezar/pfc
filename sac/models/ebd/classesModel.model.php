<?php
/*CLASSESMODEL*/
if(!defined('URL')) die('Acesso negado');
class classesModel extends Controller{
	private $id;
	private $status;
	private $nomeClasse;
	private $departamento;
	private $faixaEtariaMin;
	private $faixaEtariaMax;
	private $descricaoGeral;
	private $igreja;



	public function setId($id)
	{
		$this->id = $id;
	}

	public function setNomeClasse($nomeClasse)
	{
		$this->nomeClasse = $nomeClasse;
	}


	public function setDepartamento($departamento)
	{
		$this->departamento = $departamento;
	}


	public function setFaixaEtariaMin($faixaEtariaMin)
	{
		$this->faixaEtariaMin = $faixaEtariaMin;
	}


	public function setFaixaEtariaMax($faixaEtariaMax)
	{
		$this->faixaEtariaMax = $faixaEtariaMax;
	}


	public function setDescricaoGeral($descricaoGeral)
	{
		$this->descricaoGeral = $descricaoGeral;
	}

	public function setIgreja($igreja)
	{
		$this->igreja = $igreja;
	}


	public function setStatus($status)
	{
		$this->status = $status;
	}


	public function listar($condicao = '<>', $valor = 'Excluído')
	{
		$this->clear();
		$this->query("SELECT * FROM classes_ebd AS A 
						LEFT JOIN departamentos_ebd AS B ON A.id_departamento_ebd = B.id_departamento_ebd 
						LEFT JOIN igreja AS C ON A.id_igreja = C.id_igreja
						WHERE A.status_classe_ebd $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}




	public function getClasse()
	{
		$this->clear();
		$this->query("SELECT * FROM classes_ebd AS A 
						LEFT JOIN igreja AS B ON A.id_igreja = B.id_igreja
						LEFT JOIN departamentos_ebd AS C ON A.id_departamento_ebd = C.id_departamento_ebd 
						WHERE A.id_classe_ebd = '".$this->id."'");
		if($this->rowCount() > 0){
			return $this->result();
		}else{
			return false;
		}
	}

	
	public function inserir()
	{

		$dataFormat = new dataFormat();

		$data = array(
			'nome_classe_ebd' => $this->nomeClasse,
			'faixa_etaria_min' => $this->faixaEtariaMin,
			'faixa_etaria_max'=> $this->faixaEtariaMax,
			'descricao_geral_curriculo' => $this->descricaoGeral,
			'id_departamento_ebd' => $this->departamento,
			'id_igreja' => $this->igreja,
			'status_classe_ebd' => 'Inativo',
			'data_cadastro_classe_ebd' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('classes_ebd');
		$this->insert($data);

		if($this->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}

	public function atualizar()
	{
		$dataFormat = new dataFormat();
		$data = array(
			'nome_classe_ebd' => $this->nomeClasse,
			'faixa_etaria_min' => $this->faixaEtariaMin,
			'faixa_etaria_max'=> $this->faixaEtariaMax,
			'descricao_geral_curriculo' => $this->descricaoGeral,
			'id_departamento_ebd' => $this->departamento,
			'id_igreja' => $this->igreja
		);
		$this->clear();
		$this->setTabela('classes_ebd');
		$this->setCondicao('id_classe_ebd = "'.$this->id.'"');
		$this->update($data);
		if($this->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}



	
	//atualizarStatus
	public function atualizarStatus()
	{
		$data = array(
			'status_classe_ebd' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('classes_ebd');
		$this->setCondicao('id_classe_ebd = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}