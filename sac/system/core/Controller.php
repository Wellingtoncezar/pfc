<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Controller extends Common
{
	protected $rout; //caminho para o controller
	private $controller;
	private $action;
	private $_idModulo;
	private $_idPagina = 0;
	private static $instance;

	public function __construct(){
		parent::__construct();
		//$this->db = new db;
	}


	
}