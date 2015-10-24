<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class exemploDao extends Dao{
	public function __construct(){
		parent::__construct();
	}


	public function inserir($exemplo)
	{
		$dados = array(
			'nome' => $exemplo->getNome(),
			'idade' => $exemplo->getIdade()
		);


		$this->db->setTabela('exemplo');
		$this->db->insert($dados);

		if($this->db->rowCount() > 0 )
			return true;
		else
			return false;
	}


	public function consultar($exemplo)
	{
		$this->db->setTabela('exemplo');
		$this->db->setCondicao('id_exemplo = "'.$exemplo->getId().'"');
		$this->db->select();

		if($this->db->rowCount() > 0 )
		{
			$resp = $this->db->result();
			$exemplo->setNome( $resp['nome'] );
			$exemplo->setIdade( $resp['idade'] );
			return $exemplo;
		}else
			return false;
	}
}