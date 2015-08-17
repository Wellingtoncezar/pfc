<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('URL')) die('Acesso negado');
class relatorioEspecificoModel extends Controller{
	private $id;
	private $dataNascimento;
	private $sexo;
	private $estadoCivil;
	private $dataCasamento;
	private $igreja;
	private $data_recebimento;
	private $data_batismo;
	private $data_profissao_fe;
	private $tipo_recebimento;
	private $tipo_membro;
	private $oficial_igreja;
	private $dizimista;
	private $dataCadastro;
	private $status;
	private $busca;
	private $camposSelect = ' * ';
	
	private $sqlQuery;
	private $totalReg;

	public function __construct(){
		parent::__construct();
	}

	public function setId($id){
		$this->id = $id;
	}


	/*
	* filtragem da consulta pela data de nascimento
	*/
	public function setDataNascimento($dataNascimentoDe, $dataNascimentoAte){
		$dataFormat = new dataFormat();
		$dataNascimentoDe = $dataFormat->formatar($dataNascimentoDe,'data','banco');
		$dataNascimentoAte= $dataFormat->formatar($dataNascimentoAte,'data','banco');

		if($dataNascimentoDe != '' && $dataNascimentoAte != '')
			$this->dataNascimento = "AND M.data_nascimento_membro between '".$dataNascimentoDe."' and '".$dataNascimentoAte."'";
	}


	/*
	* filtragem da consulta pelo sexo
	*/
	public function setSexo($sexo){
		$sexo = implode('","',$sexo);
		$this->sexo = ' AND sexo_membro IN ("'.$sexo.'")';
	}

	/*
	* filtragem da consulta pelo estado civil
	*/
	public function setEstadoCivil($estadoCivil)
	{
		$estadoCivil = implode('","',$estadoCivil);
		$this->estadoCivil = ' AND ESTCIV.id_estado_civil IN ("'.$estadoCivil.'")';
	}

	/*
	* filtragem da consulta pela data de casamento
	*/
	public function setDataCasamento($dataCasamentoDe, $dataCasamentoAte){
		$dataFormat = new dataFormat();
		$dataCasamentoDe = $dataFormat->formatar($dataCasamentoDe,'data','banco');
		$dataCasamentoAte= $dataFormat->formatar($dataCasamentoAte,'data','banco');

		if($dataCasamentoDe != '' && $dataCasamentoAte != '')
			$this->dataCasamento = " AND M.data_casamento_membro between '".$dataCasamentoDe."' and '".$dataCasamentoAte."'";
		else
		if($dataCasamentoDe != '')
			$this->dataCasamento = " AND M.data_casamento_membro >= '".$dataCasamentoDe."'";
		else
		if($dataCasamentoAte != '')
			$this->dataCasamento = " AND M.data_casamento_membro <= '".$dataCasamentoAte."'";
	}

	/*
	* filtragem da consulta pela igreja
	*/
	public function setIgreja($igreja)
	{
		$igreja = implode('","',$igreja);
		$this->igreja = ' AND IGREJ.id_igreja IN ("'.$igreja.'")';
	}

	/*
	* filtragem da consulta pela data de recebimento
	*/
	public function setDataRecebimento($data_recebimentoDe,$data_recebimentoAte)
	{
		//$this->data_recebimento = $data_recebimento;
		$dataFormat = new dataFormat();
		$data_recebimentoDe = $dataFormat->formatar($data_recebimentoDe,'data','banco');
		$data_recebimentoAte= $dataFormat->formatar($data_recebimentoAte,'data','banco');

		if($data_recebimentoDe != '' && $data_recebimentoAte != '')
			$this->data_recebimento = " AND M.data_recebimento_membro between '".$data_recebimentoDe."' and '".$data_recebimentoAte."'";
		else
		if($data_recebimentoDe != '')
			$this->data_recebimento = " AND M.data_recebimento_membro >= '".$data_recebimentoDe."'";
		else
		if($data_recebimentoAte != '')
			$this->data_recebimento = " AND M.data_recebimento_membro <= '".$data_recebimentoAte."'";
	}

	/*
	* filtragem da consulta pela data de batismo
	*/
	public function setDataBatismo($data_batismoDe, $data_batismoAte)
	{
		//$this->data_batismo = $data_batismo;
		$dataFormat = new dataFormat();
		$data_batismoDe = $dataFormat->formatar($data_batismoDe,'data','banco');
		$data_batismoAte= $dataFormat->formatar($data_batismoAte,'data','banco');

		if($data_batismoDe != '' && $data_batismoAte != '')
			$this->data_batismo = " AND M.data_batismo between '".$data_batismoDe."' and '".$data_batismoAte."'";
		else
		if($data_batismoDe != '')
			$this->data_batismo = " AND M.data_batismo >= '".$data_batismoDe."'";
		else
		if($data_batismoAte != '')
			$this->data_batismo = " AND M.data_batismo <= '".$data_batismoAte."'";
	}

	/*
	* filtragem da consulta pela data de profissão de fé
	*/
	public function setDataProfissaoFe($data_profissao_feDe, $data_profissao_feAte)
	{
		//$this->data_profissao_fe = $data_profissao_fe;
		$dataFormat = new dataFormat();
		$data_profissao_feDe = $dataFormat->formatar($data_profissao_feDe,'data','banco');
		$data_profissao_feAte= $dataFormat->formatar($data_profissao_feAte,'data','banco');

		if($data_profissao_feDe != '' && $data_profissao_feAte != '')
			$this->data_profissao_fe = " AND M.data_profissao_fe_membro between '".$data_profissao_feDe."' and '".$data_profissao_feAte."'";
		else
		if($data_profissao_feDe != '')
			$this->data_profissao_fe = " AND M.data_profissao_fe_membro >= '".$data_profissao_feDe."'";
		else
		if($data_profissao_feAte != '')
			$this->data_profissao_fe = " AND M.data_profissao_fe_membro <= '".$data_profissao_feAte."'";
	}

	/*
	* filtragem da consulta pelo tipo de recebimento
	*/
	public function setTipoRecebimento($tipo_recebimento)
	{
		$tipo_recebimento = implode('","',$tipo_recebimento);
		$this->tipo_recebimento = ' AND TIPORECE.id_tipo_recebimento IN ("'.$tipo_recebimento.'")';
	}

	/*
	* filtragem da consulta pelo tipo de membro
	*/
	public function setTipoMembro($tipo_membro)
	{
		$tipo_membro = implode('","',$tipo_membro);
		$this->tipo_membro = ' AND TIPOMEMB.id_tipo_membro IN ("'.$tipo_membro.'")';
	}

	/*
	* filtragem da consulta pelo status
	*/
	public function setStatus($status){
		if(is_array($status))
		{
			$status = implode('","',$status);
			$this->status = ' AND M.status_membro IN ("'.$status.'")';
		}else
		{
			$this->status = $status;
		}
	}

	/*
	* filtragem da consulta pelo ofício da igreja
	*/
	public function setOficial_igreja($oficial_igreja)
	{
		$oficial_igreja = implode('","',$oficial_igreja);
		$this->oficial_igreja = ' AND OFICIGRE.id_tipo_oficio_igreja IN ("'.$oficial_igreja.'")';
	}

	/*
	* filtragem da consulta pelo dizimista
	*/
	public function setDizimista($dizimista)
	{
		$dizimista = implode('","',$dizimista);
		$this->dizimista = ' AND M.dizimista_membro IN ("'.$dizimista.'")';
	}

	/*
	* filtragem da consulta pela data de cadastro
	*/
	public function setDataCadastro($dataCadastroDe,$dataCadastroAte)
	{

		$dataFormat = new dataFormat();
		$dataCadastroDe = $dataFormat->formatar($dataCadastroDe,'datahora','banco');
		$dataCadastroAte= $dataFormat->formatar($dataCadastroAte,'datahora','banco');

		if($dataCadastroDe != '' && $dataCadastroAte != '')
			$this->dataCadastro = " AND M.data_cadastro_membro between '".$dataCadastroDe."' and '".$dataCadastroAte."'";
		else
		if($dataCadastroDe != '')
			$this->dataCadastro = " AND M.data_cadastro_membro >= '".$dataCadastroDe."'";
		else
		if($dataCadastroAte != '')
			$this->dataCadastro = " AND M.data_cadastro_membro <= '".$dataCadastroAte."'";
	}

	/*
	* define os campos do select para consulta
	*/
	public function setCamposSelect($camposSelect = '*')
	{
		if(!empty($camposSelect) && is_array($camposSelect))
		{
			$camposSelect = array_fill_keys($camposSelect, '');
			$campos = array();
			$campos['nome'] = 'M.nome_membro';
	        $campos['sobrenome'] = 'M.sobrenome_membro';
	        $campos['data_nascimento'] = 'M.data_nascimento_membro';
	        $campos['sexo'] = 'M.sexo_membro';
	        $campos['rg'] = 'M.rg_membro';
	        $campos['cpf'] = 'M.cpf_membro';
	        $campos['estado_civil'] = 'ESTCIV.nome_estado_civil';
	        $campos['data_casamento'] = 'M.data_casamento_membro';
	        $campos['endereco'] = '';
	        $campos['telefones'] = '';
	        $campos['profissao'] = 'M.profissao_membro';
	        $campos['email'] = '';
	        $campos['igreja'] = 'IGREJ.nome_igreja';
	        $campos['num_rol'] = 'M.numero_rol_membro';
	        $campos['data_recebimento_membro'] = 'M.data_recebimento_membro';
	        $campos['data_batismo'] = 'M.data_batismo';
	        $campos['data_profissao_fe'] = 'M.data_profissao_fe_membro';
	        $campos['celebrante_batismo'] = 'M.celebrante_batismo';
	        $campos['local_batismo'] = 'M.local_batismo';
	        $campos['tipo_recebimento'] = 'TIPORECE.nome_tipo_recebimento';
	        $campos['tipo_membro'] = 'TIPOMEMB.nome_tipo_membro';
	        $campos['oficial_igreja'] = 'OFICIGRE.nome_tipo_oficio_igreja, STATOFICIGRE.nome_status_tipo_oficio_igreja';
	        $campos['dizimista'] = 'M.dizimista_membro, M.numero_dizimista';
	        $campos['data_cadastro'] = 'M.data_cadastro_membro';
	        $campos['status'] = 'M.status_membro';

	        foreach($camposSelect as $key=>$cmp)
	        {
	        	$camposSelect[$key] = $campos[$key];
	        }
	        $camposSelect = array_filter($camposSelect);
			$this->camposSelect = 'M.id_membro,'.implode(', ',$camposSelect);
		}else
			$this->camposSelect = '*';

	}

	/*
	* filtragem da consulta pela busca especifica
	*/
	public function setBusca_especifica($busca)
	{
		$mult = explode(' ',$busca);
		$this->busca = ' AND(';
		if(count($mult) > 1)
		{
			$this->busca .= ' ESTCIV.nome_estado_civil REGEXP "'.$busca.'"';
			$this->busca .= ' OR TIPORECE.nome_tipo_recebimento REGEXP "'.$busca.'"';
			$this->busca .= ' OR TIPOMEMB.nome_tipo_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR OFICIGRE.nome_tipo_oficio_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR STATOFICIGRE.nome_status_tipo_oficio_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR IGREJ.nome_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.nome_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.data_nascimento_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.naturalidade_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.nacionalidade_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.rg_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.cpf_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.profissao_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.aptidoes_artisticas_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.outras_informacoes_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.celebrante_batismo REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.local_batismo REGEXP "'.$busca.'"';

			foreach ($mult as $value)
			{
				$this->busca .= ' OR ESTCIV.nome_estado_civil REGEXP "'.$value.'"';
				$this->busca .= ' OR TIPORECE.nome_tipo_recebimento REGEXP "'.$value.'"';
				$this->busca .= ' OR TIPOMEMB.nome_tipo_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR OFICIGRE.nome_tipo_oficio_igreja REGEXP "'.$value.'"';
				$this->busca .= ' OR STATOFICIGRE.nome_status_tipo_oficio_igreja REGEXP "'.$value.'"';
				$this->busca .= ' OR IGREJ.nome_igreja REGEXP "'.$value.'"';
				$this->busca .= ' OR M.nome_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.data_nascimento_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.naturalidade_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.nacionalidade_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.rg_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.cpf_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.profissao_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.aptidoes_artisticas_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.outras_informacoes_membro REGEXP "'.$value.'"';
				$this->busca .= ' OR M.celebrante_batismo REGEXP "'.$value.'"';
				$this->busca .= ' OR M.local_batismo REGEXP "'.$value.'"';
			}


		}else
		{
			$this->busca .= ' ESTCIV.nome_estado_civil REGEXP "'.$busca.'"';
			$this->busca .= ' OR TIPORECE.nome_tipo_recebimento REGEXP "'.$busca.'"';
			$this->busca .= ' OR TIPOMEMB.nome_tipo_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR OFICIGRE.nome_tipo_oficio_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR STATOFICIGRE.nome_status_tipo_oficio_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR IGREJ.nome_igreja REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.nome_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.data_nascimento_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.naturalidade_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.nacionalidade_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.rg_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.cpf_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.profissao_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.aptidoes_artisticas_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.outras_informacoes_membro REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.celebrante_batismo REGEXP "'.$busca.'"';
			$this->busca .= ' OR M.local_batismo REGEXP "'.$busca.'"';

 		}

 		$this->busca .= ' )';
	}



	/*
	* retorna a consulta do relatório
	*/
	public function gerarRelatorio()
	{
		$this->clear();
		$sql = 'SELECT '.$this->camposSelect.' FROM membros AS M';
		$sql .= ' LEFT JOIN estado_civil AS ESTCIV ON M.id_estado_civil = ESTCIV.id_estado_civil';
		$sql .= ' LEFT JOIN tipo_recebimento AS TIPORECE ON M.id_tipo_recebimento = TIPORECE.id_tipo_recebimento';
		$sql .= ' LEFT JOIN tipo_membro AS TIPOMEMB ON M.id_tipo_membro = TIPOMEMB.id_tipo_membro';
		$sql .= ' LEFT JOIN tipo_oficio_igreja AS OFICIGRE ON M.id_tipo_oficio_igreja = OFICIGRE.id_tipo_oficio_igreja';
		$sql .= ' LEFT JOIN status_tipo_oficio_igreja AS STATOFICIGRE ON M.id_status_tipo_oficio_igreja = STATOFICIGRE.id_status_tipo_oficio_igreja';
		$sql .= ' LEFT JOIN igreja AS IGREJ ON M.id_igreja = IGREJ.id_igreja';
		

		$sql .= ' WHERE M.status_membro <> "Excluído" ';
		$sql .= $this->estadoCivil;
		$sql .= $this->dataNascimento;
		$sql .= $this->sexo;
		$sql .= $this->dataCasamento;
		$sql .= $this->data_recebimento;
		$sql .= $this->data_batismo;
		$sql .= $this->data_profissao_fe;
		$sql .= $this->tipo_recebimento;
		$sql .= $this->tipo_membro;
		$sql .= $this->dizimista;
		$sql .= $this->dataCadastro;
		$sql .= $this->igreja;
		$sql .= $this->status;
		$sql .= $this->busca;
		$sql .= ' GROUP BY M.id_membro';
		//echo $sql;
		$this->query($sql);
		$this->totalReg = $this->rowCount();
		if($this->rowCount()>0)
			return $this->resultAll();
		else
			return false;

	}

	/*
	* retorna o total de registro
	*/
	public function getTotalReg()
	{
		return $this->totalReg;
	}

	/*
	* retorn os endereços
	*/
	public function getEndereco($id){
		$this->clear();
		$this->setTabela('enderecos');
		$this->setCondicao('id_membro = "'.$id.'"');
		$this->select();
		$endereco = $this->result();
		if($this->rowCount() > 0)
		{
			$endereco = $endereco['rua_endereco'].', '.$endereco['numero_endereco'].' '.$endereco['complemento_endereco'].'. '.$endereco['bairro_endereco']. ' - '.$endereco['cidade_endereco'].'-'.$endereco['estado_endereco'].'. CEP: '.$endereco['cep_endereco'];
			return $endereco;
		}else
			return false;
	}

	/*
	* retorna os telefones
	*/
	public function getTelefones($id){
		$this->clear();
		$this->setTabela('telefones AS A, tipo_telefone AS B');
		$this->setCondicao('A.id_membro = "'.$id.'" and B.id_tipo_telefone = A.id_tipo_telefone');
		$this->select();
		$telefones = $this->resultAll();
		$lisTel = '';
		if($this->rowCount() > 0)
		{
			foreach ($telefones as $tel)
			{
				$lisTel .= '<p>'.$tel['nome_tipo_telefone'].': '.$tel['telefone'].' Op:'.$tel['operadora'].'</p>';
			}
			return $lisTel;
		}else
			return false;
	}

	/*
	* retorna os emails
	*/
	public function getEmails($id){
		$this->clear();
		$this->setTabela('emails AS A, tipo_email AS B');
		$this->setCondicao('A.id_membro = "'.$id.'" and B.id_tipo_email = A.id_tipo_email');
		$this->select();
		$emails = $this->resultAll();
		$lisEm = '';
		if($this->rowCount() > 0)
		{
			foreach ($emails as $email)
			{
				$lisEm .= '<p>'.$email['nome_tipo_email'].': '.$email['email'].'</p>';
			}
			return $lisEm;
		}else
			return false;
	}



	/*
	* retorna a listagem geral dos relatórios
	*/
	public function listar($condicao = '<>', $valor = 'Excluído'){
		$this->clear();
		$this->query("SELECT * FROM relatorio_especifico WHERE status_relatorio $condicao '$valor' ORDER BY data_cadastro_relatorio DESC");
		if($this->rowCount() > 0){
			return $this->resultAll();
		}else{
			return false;
		}
	}


	/*
	* insere um novo relatório
	*/
	public function inserir($nome_relatorio, $relatorio)
	{
		$data = array(
			'nome_relatorio' => $nome_relatorio,
			'content_relatorio' => $relatorio,
			'autor_relatorio' => $_SESSION['login_adm']['nome'].' '.$_SESSION['login_adm']['sobrenome'],
			'data_cadastro_relatorio' => date('Y-m-d H:i:s')
		);

		$this->clear();
		$this->setTabela('relatorio_especifico');
		$this->insert($data);
		if($this->rowCount() > 0)
			return true;
		else
			return 'Erro não foi possível gravar o relatório';
	}



	public function getRelatorio()
	{
	
		$this->clear();
		$this->setTabela('relatorio_especifico');
		$this->setCondicao('id_relatorio_especifico = "'.$this->id.'"');
		$this->select();
		if($this->rowCount() > 0)
		{
			return $this->result();
		}
		else
			return false;
	}


	public function atualizarStatus()
	{
		$data = array(
			'status_relatorio' => filter_var($this->status)
		);

		$this->clear();
		$this->setTabela('relatorio_especifico');
		$this->setCondicao('id_relatorio_especifico = "'.$this->id.'"');
		$this->update($data);

		if($this->rowCount() > 0)
			return true;
		else
			return false;
	}
}

