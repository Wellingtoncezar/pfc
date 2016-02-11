<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class configModel extends Model{
	private $titulo;
	private $favicon;
	private $status;

	public function __construct(){
		parent::__construct();
	}

	public function getTitulo()
	{
		return $this->titulo;
	}

	public function getFavicon()
	{
		return $this->favicon;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}

	public function setFavicon($favicon)
	{
		$this->favicon = $favicon;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}
}