<?php
/**
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
abstract class Controller extends Load
{
	protected $load = null;
	public function __construct(){
		parent::__construct();
		$this->load = Load::getInstance();
        $this->load->_autoloadComplement();
	}

}