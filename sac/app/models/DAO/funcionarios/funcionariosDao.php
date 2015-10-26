<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class funcionariosDao extends Dao{
	public function __construct(){
		parent::__construct();
	}

 	public function inserir(funcionariosModel $funcionario)
 	{
 		$data = array(
 			'nome_funcionario' => $funcionario->getNome(),
 			'sobrenome_funcionario' => $funcionario->getSobrenome(),
 			'data_nascimento_funcionario' => $funcionario->getDataNascimento(),
 			'sexo_funcionario' => $funcionario->getSexo(),
 			'rg_funcionario' => $funcionario->getRg(),
 			'cpf_funcionario' => $funcionario->getCpf(),
 			'estado_civil_funcionario' => $funcionario->getEstadoCivil(),
 			'escolaridade_funcionario' => $funcionario->getEscolaridade(),
 			'codigo_funcionario' => $funcionario->getCodigo(),
 			'cargo_funcionario' => $funcionario->getCargo(),
 			'data_admissao_funcionario' => $funcionario->getDataAdmissao(),
 			'salario_funcionario' => $funcionario->getSalario(),
 			'status_funcionario' => $funcionario->getStatus(),
 			'data_cadastro_funcionario' => $funcionario->getDataCadastro()
 		);

 		$this->db->clear();
		$this->db->setTabela('funcionarios');
		$this->db->insert($data);
		if($this->db->rowCount() > 0)
		{
			$funcionario->setId($this->db->getUltimoId()); //RETORNA O ID INSERIDO

			$this->db->clear();
			$this->db->setTabela('enderecos');
			$data = array(
				'id_funcionario' => $funcionario->getId(),
				'cep_endereco' => $funcionario->getEndereco()->getCep(),
				'rua_endereco' => $funcionario->getEndereco()->getLogradouro(),
				'numero_endereco' => $funcionario->getEndereco()->getNumero(),
				'complemento_endereco' => $funcionario->getEndereco()->getComplemento(),
				'bairro_endereco' => $funcionario->getEndereco()->getBairro(),
				'cidade_endereco' => $funcionario->getEndereco()->getCidade(),
				'estado_endereco' => $funcionario->getEndereco()->getEstado(),
				'data_cadastro_endereco' => date('Y-m-d h:i:s')
			);
			
			$this->db->insert($data);



	 		$telefones = $funcionario->getTelefones();
			return true;
 		}else
 		{
 			return json_encode(array('erro'=>'Erro ao inserir registro'));
 		}
 		
 	}
}