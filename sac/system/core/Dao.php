<?php
/**
*@author Wellington cezar (programador jr) - wellington.infodahora@gmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Dao
{
	protected $db;
	protected $load = null;
    public function __construct()
    {
        $this->load = Load::getInstance();
        $this->load->_autoloadComplement();
        
		$this->load->library('db');
		$this->db = new db();
    }
}