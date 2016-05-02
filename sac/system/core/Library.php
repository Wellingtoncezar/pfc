<?php
/**
*@author Wellington cezar - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Library
{
	protected $db;
	protected $load = null;
	public function __construct(){
		$this->load = Load::getInstance();
        $this->load->_autoloadComplement();
        
		$this->load->library('db');
		$this->db = new db();
	}
}