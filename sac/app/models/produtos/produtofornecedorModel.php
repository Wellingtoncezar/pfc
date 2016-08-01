<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class produtofornecedorModel{
	private $id;
	private $fornecedor;
	public function setId($id){
		$this->id = $id;
	}
	public function setFornecedor(fornecedoresModel $fornecedor){
		$this->fornecedor = $fornecedor;
	}

	public function getId(){
		return $this->id;
	}
	public function getFornecedor(){
		return $this->fornecedor;
	}


}
