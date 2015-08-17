<?php
/*CLASSESMODEL*/
if(!defined('URL')) die('Acesso negado');
class aulaModel extends Controller{
	private $id;
	private $dataAula;
	private $horaAula;
	private $alunosPresentes;
	private $classe;


	public function setId($id)
	{
		$this->id = $id;
	}

	public function setDataAula($dataAula)
	{
		$this->dataAula = $dataAula;
	}

	public function setHoraAula($horaAula)
	{
		$this->horaAula = $horaAula;
	}

	public function setAlunosPresentes($alunosPresentes){
		$this->alunosPresentes = $alunosPresentes;
	}

	public function setClasse($classe){
		$this->classe = $classe;
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



	public function inserir()
	{
		$dataFormat = new dataFormat(); 
		$this->dataAula = $dataFormat->formatar($this->dataAula,'data','banco');
		$this->horaAula = $dataFormat->formatar($this->horaAula,'data','banco');
		
		$data = array(
			'id_classe' => $this->classe,
			'data_aula' => $this->dataAula,
			'hora_aula' => $this->horaAula,
			'data_cadastro_data_aula' => date('Y-m-d H:i:s')
		);
		$this->clear();
		$this->query('BEGIN');
		$this->setTabela('data_aula_ebd');
		$this->insert($data);
		$lastId = $this->getUltimoId();
		unset($data);
		if($this->rowCount() > 0)
		{
			//se houver alunos presentes
			if(!empty($this->alunosPresentes))
			{
				foreach ($this->alunosPresentes as $aluno)
				{
					$data = array(
						'id_aluno' => $aluno,
						'id_classe' => $this->classe,
						'id_data_aula_ebd' => $lastId,
						'data_cadastro_chamada_ebd' => date('Y-m-d H:i:s')
					 );

					$this->clear();
					$this->setTabela('chamada_aulas_ebd');
					$this->insert($data);
					unset($data);
				}
			}
			$this->query('COMMIT');
			return true;
		}else
		{
			$this->query('ROLLBACK');
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



	public function getAulas($ano = '2015',$classe = '1')
	{
		
		$ano = intval($ano);
		$this->clear();
		$this->setTabela('data_aula_ebd');
		$this->setCondicao('id_classe = "'.$classe.'" AND data_aula LIKE "'.$ano.'%"');
		$this->select();
		$aulas = $this->resultAll();
		$array = array();

		if($this->rowCount() > 0):
			$dataFormat = new dataFormat(); 
			foreach ($aulas as $aula)
			{
				$data = explode('-',$aula['data_aula']);
				$d = intval($data[2]);
				$m = intval($data[1]);
				$a = intval($data[0]);
				$data = $d.'/'.$m.'/'.$a;
				$_aula = array(
					'date' => $data,
			        //'title' => 'Getting Contacts Barcelona - test1',
			        'link' => URL.'ebd/classes/home/data_chamada/'.$aula['id_data_aula_ebd'],
			        'color' => 'green'
				);
				array_push($array, $_aula);
			}
		endif;
		return json_encode($array);
	}


	public function getChamada($data_aula)
	{
		//obtem todos os alunos da classe com a data especifica
		$this->clear();
		$this->query("SELECT A.*, B.*,C.id_membro, C.nome_membro, C.sobrenome_membro, C.foto_membro, D.id_classe_ebd, D.nome_classe_ebd
						FROM data_aula_ebd AS A 
						INNER JOIN classes_ebd AS D ON A.id_classe = D.id_classe_ebd
						INNER JOIN alunos_ebd AS B ON A.id_classe = B.id_classe
						INNER JOIN membros AS C ON B.id_membro = C.id_membro
						WHERE A.id_data_aula_ebd = '$data_aula'
			");
		//LEFT JOIN chamada_aulas_ebd AS B ON A.id_data_aula_ebd = B.id_data_aula_ebd
		$this->select();

		$listPresenca = array();

		if($this->rowCount() > 0):
			$alunosDaClasse = $this->resultAll();
			$dataFormat = new dataFormat();
			foreach ($alunosDaClasse as $alunos)
			{
				$alunos['nome']
			}
			
		else:
			return false;
		endif;





		$resp = array();

		$idclasse = 

		$resp['classe'] = 'Nome da classe';
		$resp['data'] = 'data';
		$resp['hora'] = 'hora';
		$resp['alunos'] = array(
			'0' => array('wellington cezar','presente','obs'),
			'1' => array('Kátia','ausente','obs'),
			'2' => array('Paula','presente',''),
			);


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