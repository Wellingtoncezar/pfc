<?php
/**
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class Common extends LoadSingleton
{
    protected $load = null;
    public function __construct()
    {
        $this->load = LoadSingleton::getInstance();
        $this->_autoloadComplement();
    }
}