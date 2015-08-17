<?php
/*LOGINMODEL*/
if(!defined('URL')) die('Acesso negado');
class departamentosModel extends Controller{
	private $id;
	private $coordenador;
	private $nomeDepartamento;
	private $status;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setCoordenador($coordenador)
	{
		$this->coordenador = $coordenador;
	}

	public function setNomeDepartamento($nomeDepartamento)
	{
		$this->nomeDepartamento = $nomeDepartamento;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}


	public function listar($condicao = '<>', $valor = 'Excluído')
	{
		$this->clear();
		$this->query("SELECT A.*,B.id_coordenador_ebd, C.foto_membro AS foto_coodenador, C.nome_membro AS nome_coordenador, C.sobrenome_membro AS sobrenome_coordenador 
						FROM departamentos_ebd AS A 
						LEFT JOIN coordenadores_ebd AS B ON A.id_coordenador_ebd = B.id_coordenador_ebd 
						LEFT JOIN membros AS C ON B.id_membro = C.id_membro
						WHERE A.status_departamento_ebd $condicao '$valor'");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}

	public function getDepartamento()
	{
		$this->clear();
		$this->query("SELECT A.*,B.id_coordenador_ebd, C.foto_membro AS foto_coodenador, C.nome_membro AS nome_coordenador, C.sobrenome_membro AS sobrenome_coordenador 
						FROM departamentos_ebd AS A 
						LEFT JOIN coordenadores_ebd AS B ON A.id_coordenador_ebd = B.id_coordenador_ebd 
						LEFT JOIN membros AS C ON B.id_membro = C.id_membro
						WHERE A.id_departamento_ebd = '".$this->id."'
						");
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
			'nome_departamento_ebd' => $this->nomeDepartamento,
			'id_coordenador_ebd' => $this->coordenador,
			'status_departamento_ebd' => 'Inativo',
			'data_cadastro_departamento' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->setTabela('departamentos_ebd');
		$this->insert($data);


		if($this->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function atualizar()
	{
		$data = array(
			'nome_departamento_ebd' => $this->nomeDepartamento,
			'id_coordenador_ebd' => $this->coordenador
		);
		$this->clear();
		$this->setTabela('departamentos_ebd');
		$this->setCondicao('id_departamento_ebd = "'.$this->id.'"');
		$this->update($data);


		if($this->rowCount() > 0){
			return true;
		}else{
			return false;
		}
	}	



	
	//atualizarStatus
	public function atualizarStatus()
	{
		$data = array(
			'status_departamento_ebd' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('departamentos_ebd');
		$this->setCondicao('id_departamento_ebd = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}