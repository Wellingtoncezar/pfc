<?php
/**
*@author Wellington cezar, Diego Hernandes, Jessica Azevedo
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class telefoneModel extends Model{
	private $id;
	private $tipo;
	private $numero;
	

	public function __construct(){
		parent::__construct();
	}

 	//SETERS
	public function setId($id)
	{
		$this->id = $id;
	}
	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}
	public function setNumero($numero)
	{
		$this->numero = $numero;
	}
	

	//GETERS
	public function getId()
	{
		return $this->id;
	}
	public function getTipo()
	{
		return $this->tipo;
	}
	public function getNumero()
	{
		return $this->numero;
	}
}