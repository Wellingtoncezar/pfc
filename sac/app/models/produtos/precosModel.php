<?php
/**
*@author Wellington cezar, Diego Hernandes
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class precosModel{
	/**
	 * @id
	 * @var int
	 * */ 
	private $id;
	/**
	 * @preco
     * @Column(type="decimal(10,2)", name="preco_produto")
     * @var double
     * */
	private $preco;
	/**
	 * @dataInicio
     * @Column(type="date", name="data_inicio")
     * @var date
     * */
	private $dataInicio;
	/**
	 * @dataFim
     * @Column(type="date", name="data_fim")
     * @var date
     * */
	private $dataFim;
	/**
	 * @padrao
     * @Column(type="boolean", name="preco_padrao")
     * @var boolean
   	 * */
	private $padrao = false;
	/**
	 * @dataCadastro
     * @Column(type="boolean", name="data_cadastro")
     * @var date
     * */
	private $dataCadastro;

 	//SETERS
 	public function setId($id)
 	{
 		$this->id = $id;
 	}
 	public function setPreco($preco)
	{
		$this->preco = $preco;
	}
	public function setDataInicio($dataInicio)
	{
		$this->dataInicio = $dataInicio;
	}
	public function setDataFim($dataFim)
	{
		$this->dataFim = $dataFim;
	}
	public function setPadrao($padrao)
	{
		$this->padrao = $padrao;
	}
	public function setDataCadastro($dataCadastro)
	{
		$this->dataCadastro = $dataCadastro;
	}



	//GETERS
 	public function getId()
 	{
 		return $this->id;
 	}
 	public function getPreco()
	{
		return $this->preco;
	}
	public function getDataInicio()
	{
		return $this->dataInicio;
	}
	public function getDataFim()
	{
		return $this->dataFim;
	}
	public function getPadrao()
	{
		return $this->padrao;
	}
	public function getDataCadastro()
	{
		return $this->dataCadastro;
	}

}