<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
/**
* Arquivo de configuração geral
* @author Wellington cezar  - wellington-cezar@hotmail.com
* @since 05/03/2015
* @version 3.0
*
*/

class config{
	/*
	ARQUIVO DE CONFIGURAÇÕES DO SISTEMA
	*/
	private static $_config = array();
    protected function __construct(){
    	
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }
    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone()
    {
    }


    /**
     * Método unserialize do tipo privado para prevenir a desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    public function getConfig()
    {
    	require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

		foreach ($_config as $key => $value)
		{
			$key = strtoupper($key);
			define($key,$value);
		}

		if( ERRORREPORTING == 'E_ALL')
			error_reporting(E_ALL);
		else
			error_reporting(0);
    }
}