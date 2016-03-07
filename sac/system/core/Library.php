<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Library extends Common
{
	protected $db;
	public function __construct(){
		parent::__construct();
		$this->load->library('db');
		$this->db = new db();
	}
}