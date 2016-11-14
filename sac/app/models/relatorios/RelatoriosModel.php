<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class RelatoriosModel{
	private $id;
	private $periodo_de;
	private $periodo_ate;
	private $tiporelatorio = Array();

	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}


	public function setPeriodoDe($periodo_de){
		$this->periodo_de = $periodo_de;
	}
	public function getPeriodoDe(){
		return $this->periodo_de;
	}


	public function setPeriodoAte($periodo_ate){
		$this->periodo_ate = $periodo_ate;
	}
	public function getPeriodoAte(){
		return $this->periodo_ate;
	}


	public function addTipoRelatorio(IRelatoriosModel $tiporelatorio)
	{
		$this->tiporelatorio[] = $tiporelatorio;
	}

	public function getTipoRelatorio()
	{
		return $this->tiporelatorio;
	}

}